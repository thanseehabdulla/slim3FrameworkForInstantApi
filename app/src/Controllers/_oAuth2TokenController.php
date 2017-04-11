<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use OAuth2\HttpFoundationBridge\Request as BridgeRequest;

/**
 * Class _oAuth2TokenController
 */
final class _oAuth2TokenController
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var oAuth2server
     */
    private $oAuth2server;

    /**
     * @param \Psr\Log\LoggerInterface       $logger
     */
    public function __construct(LoggerInterface $logger, $server)
    {
        $this->logger       = $logger;
        $this->oAuth2server = $server;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function token(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        // convert a request from PSR7 to hhtpFoundation
        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($request);
        $bridgeRequest = BridgeRequest::createFromRequest($symfonyRequest);
        
		$this->oAuth2server->handleTokenRequest($bridgeRequest)->send();

    }

    
}
