<?php

namespace App\Model;

class SearchData
{
    /**
     * @var string|null
     */
    public ?string $q = null;

    /**
     * @var int
     */
    public int $page = 1;
}