<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use OAuth2\HttpFoundationBridge\Request as BridgeRequest;

use App\Controllers\_Controller;
use App\DataAccess\_DataAccess;

/**
 * Class _Controller_oAuth2
 */
class _Controller_oAuth2 extends _Controller
{
    /**
     * @var oAuth2server
     */
    protected $oAuth2server;

    /**
     * @var user
     */
    protected $user;

    /**
     * @param \Psr\Log\LoggerInterface       $logger
     * @param \App\DataAccess                $dataaccess
     * @param                                $server
     */
    public function __construct(LoggerInterface $logger, _DataAccess $dataaccess, $server)
    {
        parent::__construct($logger,$dataaccess);
        $this->oAuth2server = $server;
    }
    
     /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $next
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function validateToken($request)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);
        
        // convert a request from PSR7 to hhtpFoundation
        $httpFoundationFactory = new HttpFoundationFactory();
        $symfonyRequest = $httpFoundationFactory->createRequest($request);
        $bridgeRequest = BridgeRequest::createFromRequest($symfonyRequest);

        if (!$this->oAuth2server->verifyResourceRequest($bridgeRequest)) {
            $this->oAuth2server->getResponse()->send();
            die;
         }

        // store the user_id
        $token = $this->oAuth2server->getAccessTokenData($bridgeRequest);
        $this->user = $token['user_id'];

        return TRUE;
    }

	// needs an oAuth2 Client credentials grant
	// with Resource owner credentials grant alseo works
    public function getAll(Request $request, Response $response, $args) {
    	if ($this->validateToken($request)) {
	    	parent::getAll($request, $response, $args);
    	}    		
    }

	// needs an oAuth2 Client credentials grant
	// with Resource owner credentials grant alseo works
    public function get(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request)) {
	    	parent::get($request, $response, $args);
    	}    		
    }

	// needs an oAuth2 Resource owner credentials grant
	// checked with isset($this->user)
    public function add(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request) && isset($this->user)) {
	    	return (parent::add($request, $response, $args));
    	} else {
            return $response ->withStatus(400);
    	}
    }

	// needs an oAuth2 Resource owner credentials grant
	// checked with isset($this->user)
    public function update(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request) && isset($this->user)) {
	    	return (parent::update($request, $response, $args));
    	} else {
            return $response ->withStatus(400);
    	}    		
    }

	// needs an oAuth2 Resource owner credentials grant
	// checked with isset($this->user)
    public function delete(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request) && isset($this->user)) {
	    	return (parent::delete($request, $response, $args));
    	} else {
            return $response ->withStatus(400);
    	}    		
    }
    // needs an oAuth2 Client credentials grant
	// with Resource owner credentials grant alseo works
    public function getdataByAgentDealerID(Request $request, Response $response, $args) {
    	
                if ($this->validateToken($request)) {
	    	parent::getdataByAgentDealerID($request, $response, $args);
    	}    		
    }

	// needs an oAuth2 Client credentials grant
	// with Resource owner credentials grant alseo works
    public function getPaymentByUserID(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request)) {
	    	parent::getPaymentByUserID($request, $response, $args);
    	}    		
    }


	// needs an oAuth2 Resource owner credentials grant
	// checked with isset($this->user)
    public function insertPayment(Request $request, Response $response, $args)
    {
    	if ($this->validateToken($request) && isset($this->user)) {
	    	return (parent::insertPayment($request, $response, $args));
    	} else {
            return $response ->withStatus(400);
    	}
    }
}
