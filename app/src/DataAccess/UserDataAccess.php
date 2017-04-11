<?php

namespace App\DataAccess;

use Psr\Log\LoggerInterface;
use PDO;

/**
 * Class UserDataAccess.
 */
class UserDataAccess
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \PDO
     */
    private $pdo;
    
    /**
     * @var \App\DataAccess
     */
    private $maintable;
    
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \PDO                     $pdo
     */
    public function __construct(LoggerInterface $logger, PDO $pdo, $table)
    {
        $this->logger    = $logger;
        $this->pdo       = $pdo;
        $this->maintable = $table;
    }

    /**
     * @param array $request_data
     *
     * @return array 
     */
    public function login($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

       $result = '{"error": 0}';
       $table = 'users';

        if ($request_data == null) {
            return $result;
        }
        //var_dump($request_data);
        //$request_array = json_decode($request_data);
        $sql = "SELECT * FROM ". $table . ' WHERE email = :user and password = :pwd' ;

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':user', $request_data['username']);
        $stmt->bindValue(':pwd', sha1($request_data['password']));

        $stmt->execute();
        if ($stmt) { 
          if ($result==null) {
            $result = '{"error": 2}';    //error=2 --> user not exist.
          }
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
          $result = '{"error": 1}';
        }

       return $result;

    }


 



}
