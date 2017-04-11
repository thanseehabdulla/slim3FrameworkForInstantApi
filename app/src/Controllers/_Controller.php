<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DataAccess\_DataAccess;

/**
 * Class _Controller.
 */
class _Controller
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \App\DataAccess
     */
    protected $dataaccess;

    /**
     * @param \Psr\Log\LoggerInterface       $logger
     * @param \App\DataAccess                $dataaccess
     */
    public function __construct(LoggerInterface $logger, _DataAccess $dataaccess)
    {
        $this->logger = $logger;
        $this->dataaccess = $dataaccess;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getAll(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];
        $arrparams = $request->getParams();

		return $response->write(json_encode($this->dataaccess->getAll($path, $arrparams)));
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];

        $result = $this->dataaccess->get($path, $args);
        if ($result == null) {
            return $response ->withStatus(404);
        } else {
            return $response->write(json_encode($result));
        }
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];
        $request_data = $request->getParsedBody();

        $last_inserted_id = $this->dataaccess->add($path, $request_data);
        if ($last_inserted_id > 0) {
            $RequesPort = '';
		    if ($request->getUri()->getPort()!='')
		    {
		        $RequesPort = '.'.$request->getUri()->getPort();
		    }
            $LocationHeader = $request->getUri()->getScheme().'://'.$request->getUri()->getHost().$RequesPort.$request->getUri()->getPath().'/'.$last_inserted_id;

            return $response ->withHeader('Location', $LocationHeader)
                             ->withStatus(201);
        } else {
            return $response ->withStatus(403);
        }
    }


 public function post(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];
        $request_data = $request->getParsedBody();

        $last_inserted_id = $this->dataaccess->post($path, $request_data);
        if ($last_inserted_id > 0) {
            $RequesPort = '';
		    if ($request->getUri()->getPort()!='')
		    {
		        $RequesPort = '.'.$request->getUri()->getPort();
		    }
            $LocationHeader = $request->getUri()->getScheme().'://'.$request->getUri()->getHost().$RequesPort.$request->getUri()->getPath().'/'.$last_inserted_id;

            return $response ->withHeader('Location', $LocationHeader)
                             ->withStatus(201);
        } else {
            return $response ->withStatus(403);
        }
    }


    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];
        $request_data = $request->getParsedBody();

        $isupdated = $this->dataaccess->update($path, $args, $request_data);
        if ($isupdated) {
            return $response ->withStatus(200);
        } else {
            return $response ->withStatus(404);
        }
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = explode('/', $request->getUri()->getPath())[1];

        $isdeleted = $this->dataaccess->delete($path, $args);
        if ($isdeleted) {
            return $response ->withStatus(204);
        } else {
            return $response ->withStatus(404);
        }
    }
    
    public function getdataByAgentDealerID(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = $request->getUri();
        $request_data = $request->getParsedBody();

        $result = $this->dataaccess->getdataByAgentDealerID($path, $request_data);
        if ($result == null) {
            return $response ->withStatus(404);
        } else {
            return $response->write(json_encode($result));
        }
 }   
public function getPaymentByUserID(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = $request->getUri();
        $request_data = $request->getParsedBody();

        $result = $this->dataaccess->getPaymentByUserID($path, $request_data);
        if ($result == null) {
            return $response ->withStatus(404);
        } else {
            return $response->write(json_encode($result));
        }



}

public function getSpinnerItem(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = $request->getUri();
        $request_data = $request->getParsedBody();

        $result = $this->dataaccess->getSpinnerItem($path, $request_data);
        if ($result == null) {
            return $response ->withStatus(404);
        } else {
            return $response->write(json_encode($result));
        }



}

public function insertPayment(Request $request, Response $response, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $path = $request->getUri();
        $request_data = $request->getParsedBody();

        $result = $this->dataaccess->insertPayment($path, $request_data);
        if ($result == null) {
            return $response ->withStatus(404);
        } else {
            return $response->write(json_encode($result));
        }



}

    
    
}
