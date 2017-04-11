<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class _ApiController
 */
final class _ApiController
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $powered;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param string $powered
     */
    public function __construct(LoggerInterface $logger, $powered)
    {
        $this->logger  = $logger;
        $this->powered = $powered;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showHello(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        return $response->write($this->powered.' using Slim 3 Framework');
    }
}
