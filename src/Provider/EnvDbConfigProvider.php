<?php

declare(strict_types=1);

namespace Application\Provider;

use Application\Exception\InvalidDatabaseConfigurationException;

final class EnvDbConfigProvider implements DbConfigProvider
{
    private $host;
    private $name;
    private $pass;
    private $port;
    private $user;

    public function __construct()
    {
        if (!isset(
            $_ENV['PHPOOP_DB_HOST'],
            $_ENV['PHPOOP_DB_NAME'],
            $_ENV['PHPOOP_DB_USER'],
            $_ENV['PHPOOP_DB_PASS'],
            $_ENV['PHPOOP_DB_PORT']
        )) {
            throw new InvalidDatabaseConfigurationException(
                "La configuration de base de donnée fournie en variable d'environnement est invalide"
            );
        }
        $this->host = $_ENV['PHPOOP_DB_HOST'];
        $this->name = $_ENV['PHPOOP_DB_NAME'];
        $this->user = $_ENV['PHPOOP_DB_USER'];
        $this->pass = $_ENV['PHPOOP_DB_PASS'];
        $this->port = (int)$_ENV['PHPOOP_DB_PORT'];
    }

    public function host() : string
    {
        return $this->host;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function pass() : string
    {
        return $this->pass;
    }

    public function port() : int
    {
        return $this->port;
    }

    public function user() : string
    {
        return $this->user;
    }
}
