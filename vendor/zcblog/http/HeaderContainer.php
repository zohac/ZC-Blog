<?php

namespace zcblog\http;

class HeaderContainer
{
    private $header;

    protected function __construct(array $header = [])
    {
        $this->header = $header;
    }
}
