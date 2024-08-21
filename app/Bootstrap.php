<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;
use Symfony\Component\Dotenv\Dotenv;

class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator;
        $rootDir = dirname(__DIR__);

        $configurator->setDebugMode(true);
        $configurator->enableTracy($rootDir . '/log');

        $configurator->setTempDirectory($rootDir . '/temp');

        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addConfig($rootDir . '/config/common.neon');
        $configurator->addConfig($rootDir . '/config/services.neon');

        $dotenv = new Dotenv();
        $dotenv->load($rootDir . '\.env');

        $configurator->addDynamicParameters(['env' => $_ENV]);

        return $configurator;
    }
}
