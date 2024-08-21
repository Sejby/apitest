<?php declare(strict_types=1);

namespace App\Models;

readonly class Market
{
    /**
     * @param string|null $id
     * @param float|null $currentPrice
     * @param string|null $image
     */
    public function __construct(
        private ?string $id,
        private ?float  $currentPrice,
        private ?string $image
    )
    {
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCurrentPrice(): ?string
    {
        return number_format((float) $this->currentPrice, 2, ',', ' ');
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}
