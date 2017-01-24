<?php

namespace SimpleZoo\Controllers;

use League\Plates\Engine;
use Okneloper\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BaseController
 * @package SimpleZoo\Controllers
 */
class BaseController
{

    protected $templates;
    protected $session;
    protected $request;
    protected $response;

    /**
     * BaseController constructor.
     *
     * @param \League\Plates\Engine $templates
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(
      Engine $templates,
      Session $session,
      ServerRequestInterface $request,
      ResponseInterface $response
    )
    {
        $this->templates = $templates;
        $this->session = $session;
        $this->request = $request;
        $this->response = $response;
    }

}
