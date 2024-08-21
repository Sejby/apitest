<?php declare(strict_types=1);

namespace App\UI\Api;

use App\Exceptions\ErrorWhileFetchingException;
use App\Services\ApiService;
use Nette;
use Throwable;

final class ApiPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @inject
     * @var ApiService
     */
    public ApiService $apiService;

    /**
     * @return void
     * @throws Throwable
     */
    public function renderDefault(): void
    {
        try {
            $this->template->coins = $this->apiService->fetchCoinsList();
            $this->template->markets = $this->apiService->fetchMarkets();

            $this->flashMessage('Úspěšně fetchnuta data!');
        } catch (ErrorWhileFetchingException $e) {
            $this->flashMessage($e->getMessage());
        }
    }
}
