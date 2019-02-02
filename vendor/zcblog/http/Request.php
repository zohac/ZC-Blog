<?php

namespace zcblog\http;

use zcblog\http\ArrayContainer;

/**
 * Request represents an HTTP request.
 */
class Request
{
    /**
     * The GET parameters
     *
     * @var ArrayContainer
     */
    private $query;

    /**
     * The POST parameters
     *
     * @var ArrayContainer
     */
    private $post;

    /**
     * The COOKIE parameters
     *
     * @var ArrayContainer
     */
    private $cookies;

    /**
     * The FILES parameters
     *
     * @var ArrayContainer
     */
    private $files;

    /**
     * The SERVER parameters
     *
     * @var ArrayContainer
     */
    private $server;

    /**
     * The body of the HTTP Request
     *
     * @var string
     */
    private $body;

    /**
     * The Uri
     *
     * @var Uri
     */
    private $uri;

    /**
     * Constructor.
     *
     * @param array $query      The GET parameters
     * @param array $post       The POST parameters
     * @param array $cookies    The COOKIE parameters
     * @param array $files      The FILES parameters
     * @param array $server     The SERVER parameters
     */
    public function __construct(
        array $query = [],
        array $post = [],
        array $cookies = [],
        array $files = [],
        array $server = []
    ) {
        $this->query = new ArrayContainer($query);
        $this->post = new ArrayContainer($post);
        $this->cookies = new ArrayContainer($cookies);
        $this->files = $files;
        $this->server = new ArrayContainer($server);
        $this->setUri();
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return static
     */
    public static function createRequest(): Request
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    /**
     * Set an URI from global
     * URL structure :
     *      scheme://username:password@domain:port/path?query_string#fragment_id.
     */
    private function setUri()
    {
        $scheme = (null !== $this->server->get('REQUEST_SCHEME')) ? $this->server->get('REQUEST_SCHEME').'://' : null;
        $domain = (null !== $this->server->get('HTTP_HOST')) ? $this->server->get('HTTP_HOST') : null;
        $port = (null !== $this->server->get('SERVER_PORT')) ? ':'.$this->server->get('SERVER_PORT') : null;
        $path = (null !== $this->server->get('REQUEST_URI')) ? $this->server->get('REQUEST_URI') : null;
        $uri = $scheme.$domain.$port.$path;

        $this->uri = new Uri($uri);
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string returns the request method
     */
    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD');
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a Uri instance.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @return Uri returns a Uri instance
     *             representing the URI of the request
     */
    public function getUri(): Uri
    {
        return $this->uri;
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version
     */
    public function getProtocolVersion(): string
    {
        list($protocol, $version) = \explode('/', $this->server->get('SERVER_PROTOCOL'));

        return \preg_match('/^1\.[1,0]$/', $version) ? $version : '1.1';
    }

    /**
     * Gets the body of the message.
     */
    public function getBody(): string
    {
        if (null === $this->body) {
            $this->body = file_get_contents('php://input');
        }

        return $this->body;
    }

    /**
     * Get the value of query (query = _GET)
     */
    public function getQuery(): ArrayContainer
    {
        return $this->query;
    }

    /**
     * Get the value of post (post = _POST)
     */
    public function getPost(): ArrayContainer
    {
        return $this->post;
    }
}
