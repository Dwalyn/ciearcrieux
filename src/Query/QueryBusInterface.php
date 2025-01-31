<?php

namespace App\Query;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}
