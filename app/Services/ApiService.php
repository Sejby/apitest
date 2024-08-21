<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ErrorWhileFetchingException;
use App\Models\Coin;
use App\Models\Market;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Throwable;
use Tracy\Debugger;

readonly class ApiService
{
    /**
     * @var Cache
     */
    private Cache $cache;

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var string
     */
    private string $vsCurrency;

    /**
     * @var array<array<string, array<string, string>>>
     */
    private array $headers;

    /**
     * @var string|null
     */
    private ?string $apiKey;

    /**
     * @param Client $client
     * @param Storage $storage
     * @param string|null $apiKey
     */
    public function __construct(
        private Client  $client,
        private Storage $storage,
        ?string $apiKey = null
    )
    {
        $this->apiKey = $apiKey ?? $_ENV['API_KEY'];
        $this->apiUrl = "https://api.coingecko.com/api/v3/";
        $this->vsCurrency = "CZK";
        $this->headers = [
            'headers' => [
                'accept' => 'application/json',
                'x-cg-demo-api-key' => $this->apiKey,
            ],
        ];
        $this->cache = new Cache($this->storage, 'ApiService');
    }

    /**
     * @return Coin[]
     * @throws ErrorWhileFetchingException|Throwable
     */
    public function fetchCoinsList(): array
    {
        $cacheKey = 'coins_list';

        $coins = $this->cache->load($cacheKey);

        if ($coins === null) {
            try {
                $response = $this->client->request('GET', $this->apiUrl . 'coins/list', $this->headers);

                $coins = json_decode($response->getBody()->getContents(), true);

                $coins = array_map(fn($coin) => new Coin(
                    $coin['id'] ?? null,
                    $coin['symbol'] ?? null,
                    $coin['name'] ?? null,
                ), $coins);

                $this->cache->save($cacheKey, $coins, [
                    Cache::Expire => '1 hour',
                ]);

                return $coins;
            } catch (GuzzleException|Exception $e) {
                Debugger::log($e);
                throw new ErrorWhileFetchingException();
            }
        }

        return $coins;
    }

    /**
     * @return Market[]
     * @throws ErrorWhileFetchingException|Throwable
     */
    public function fetchMarkets(): array
    {
        $cacheKey = 'markets';

        $markets = $this->cache->load($cacheKey);

        if ($markets === null) {
            try {
                $response = $this->client->request('GET', $this->apiUrl . 'coins/markets?vs_currency=' . $this->vsCurrency, $this->headers);

                $markets = json_decode($response->getBody()->getContents(), true);

                $markets = array_map(fn($market) => new Market(
                    $market['id'] ?? null,
                    $market['current_price'] ?? null,
                    $market['image'] ?? null,
                ), $markets);

                $this->cache->save($cacheKey, $markets, [
                    Cache::Expire => '1 hour',
                ]);

                return $markets;
            } catch (GuzzleException|Exception $e) {
                Debugger::log($e);
                throw new ErrorWhileFetchingException();
            }
        }

        return $markets;
    }
}