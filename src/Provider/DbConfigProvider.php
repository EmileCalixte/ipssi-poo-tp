<?php

declare(strict_types=1);

namespace Application\Provider;

interface DbConfigProvider
{
    public function host() : string;

    public function name() : string;

    public function pass() : string;

    public function port() : int;

    public function user() : string;
}
