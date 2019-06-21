<?php

declare(strict_types=1);

namespace Application\Provider;

use Application\Exception\InvalidDatabaseConfigurationException;

final class FileDbConfigProvider implements DbConfigProvider
{
    private $host;
    private $name;
    private $pass;
    private $port;
    private $user;

    public function __construct()
    {
        $config = require __DIR__ . '/../../../config/database.config.php';
        if (!isset(
            $config['host'],
            $config['name'],
            $config['user'],
            $config['pass'],
            $config['port']
        )) {
            throw new InvalidDatabaseConfigurationException(
                "La configuration de base de donnée fournie dans le fichier config/database.config.php est invalide"
            );
        }
        $this->host = $config['host'];
        $this->name = $config['name'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->port = (int)$config['port'];
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
