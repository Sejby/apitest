<?php declare(strict_types=1);

namespace App\Models;

readonly class Coin
{
    /**
     * @param string|null $id
     * @param string|null $symbol
     * @param string|null $name
     */
    public function __construct(
        private ?string $id,
        private ?string $symbol,
        private ?string $name,
    ){
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
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
