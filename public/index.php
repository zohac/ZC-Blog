<?php

use zcblog\http\Uri;
use zcblog\http\Request;
use zcblog\http\Response;

// We load the autolaoder of Composer
require __DIR__.'/../vendor/autoload.php';

$request = Request::createRequest();

$response = new Response();

var_dump($response);
