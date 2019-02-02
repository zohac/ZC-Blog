<?php

namespace zcblog\tests\http;

use zcblog\http\Uri;
use zcblog\http\Request;
use zcblog\http\ArrayContainer;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private $get = [];
    private $post = [];
    private $attributes = [];
    private $cookies = [];
    private $files = [];
    private $server = [];

    /**
     * Initialise variables.
     */
    protected function setUp()
    {
        $this->server = [
            'REDIRECT_STATUS' => '200',
            'HTTP_HOST' => '192.168.1.1',
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE' => 'fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3',
            'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
            'HTTP_CONNECTION' => 'keep-alive',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
            'SERVER_NAME' => '192.168.1.1',
            'SERVER_ADDR' => '192.168.1.1',
            'SERVER_PORT' => '80',
            'REMOTE_ADDR' => '192.168.1.10',
            'REQUEST_SCHEME' => 'http',
            'CONTEXT_PREFIX' => '',
            'REMOTE_PORT' => '52048',
            'REDIRECT_URL' => '/test',
            'REDIRECT_QUERY_STRING' => 'test=test',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'test=test',
            'REQUEST_URI' => '/test?test=test',
            'SCRIPT_NAME' => '/index.php',
            'PHP_SELF' => '/index.php',
        ];

        $this->get = [
            'test_GET' => 'Get value',
        ];

        $this->post = [
            'test_POST' => 'Post value',
        ];
    }

    public function testRequest()
    {
        $request = Request::createRequest();
        $this->assertInstanceOf(Request::class, $request);

        $request = new Request(
            $this->get,
            $this->post,
            $this->cookies,
            $this->files,
            $this->server
        );

        $this->assertInstanceOf(Uri::class, $request->getUri());
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertRegExp('/^1\.[1,0]$/', $request->getProtocolVersion());

        $this->assertInstanceOf(ArrayContainer::class, $request->getQuery());
        $this->assertEquals($request->getQuery()->get('test_GET'), 'Get value');
        $this->assertNull($request->getQuery()->get('KeysThatDoNotExist'));

        $this->assertInstanceOf(ArrayContainer::class, $request->getPost());
        $this->assertEquals($request->getPost()->get('test_POST'), 'Post value');
        $this->assertNull($request->getPost()->get('KeysThatDoNotExist'));

        $this->assertEquals($request->getBody(), '');
    }
}
