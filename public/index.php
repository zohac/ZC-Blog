<?php

use zcblog\http\Uri;
use zcblog\http\Request;

// We load the autolaoder of Composer
require __DIR__.'/../vendor/autoload.php';

$request = Request::createRequest();

var_dump($request);
