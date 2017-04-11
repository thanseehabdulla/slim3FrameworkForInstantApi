<?php

namespace App\DataAccess;

use Psr\Log\LoggerInterface;
use PDO;

/**
 * Class _DataAccess.
 */
class _DataAccess
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
     * @return array
     */
    public function getAll($path, $arrparams)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

        $orderby = "";
        foreach ($arrparams as $key => $value) {
        	if ($key = "sort") {
        		$orderby = " ORDER BY " . $value;
        		break;
        	}
        }

        $stmt = $this->pdo->prepare('SELECT * FROM '.$table.$orderby);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } else {
        	$result = null;
        }

        return $result;
    }
    
    /**
     * @param int $id
     *
     * @return one object
     */
    public function get($path, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

        $sql = "SELECT * FROM ". $table . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));

        $stmt->execute();
        if ($stmt) {
            $result = array();
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $result[] =$row ;}
        } else {
        	$result = null;
        }

        return $result;
    }

    /**
     * @param array $request_data
     *
     * @return int (last inserted id)
     */

public function post($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

if ($request_data == null) {
            return false;
        }
 $columnString = implode(',', array_flip($request_data));
        $valueString = ":".implode(',:', array_flip($request_data));
        $sql = "SELECT * FROM ". $table . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));

        $stmt->execute();
        if ($stmt) {
            $result = array();
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $result[] =$row ;}
        } else {
        	$result = null;
        }

        return $result;
    }


    public function add($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

        if ($request_data == null) {
            return false;
        }

        $columnString = implode(',', array_flip($request_data));
        $valueString = ":".implode(',:', array_flip($request_data));

        $sql = "INSERT INTO " . $table . " (" . $columnString . ") VALUES (" . $valueString . ")";
        $stmt = $this->pdo->prepare($sql);

        foreach($request_data as $key => $value){
            $stmt->bindValue(':' . $key,$request_data[$key]);
        }

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    /**
     * @param array $request_data
     *
     * @return bool
     */
    public function update($path, $args,$request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

        // if no data to update or not key set = return false
        if ($request_data == null || !isset($args[implode(',', array_flip($args))])) {
            return false;
        }

        $sets = 'SET ';
        foreach($request_data as $key => $value){
            $sets = $sets . $key . ' = :' . $key . ', ';
        }
        $sets = rtrim($sets, ", ");

        $sql = "UPDATE ". $table . ' ' . $sets . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));
        
        $stmt = $this->pdo->prepare($sql);

        foreach($request_data as $key => $value){
            $stmt->bindValue(':' . $key,$request_data[$key]);
        }
        
        // bind the key
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));

        $stmt->execute();

      	return ($stmt->rowCount() == 1) ? true : false;
    }

    /**
     * @param int pk
     *
     * @return bool
     */
    public function delete($path, $args)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

        $table = $this->maintable != '' ? $this->maintable : $path;

        $sql = "DELETE FROM ". $table . ' WHERE ' . implode(',', array_flip($args)) . ' = :' . implode(',', array_flip($args));
        
        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':' . implode(',', array_flip($args)), implode(',', $args));

        $stmt->execute();

      	return ($stmt->rowCount() > 0) ? true : false;
    }
    
    public function getdataByAgentDealerID($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

       $result = '{"error": 0}';
       $table = 'item_order';

        if ($request_data == null) {
            return $result;
        }
        //var_dump($request_data);
        //$request_array = json_decode($request_data);
        $sql = "SELECT * FROM ". $table . ' WHERE agent_id = :user' ;

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':user', $request_data['agent_id']);
        $stmt->execute();
        if ($stmt) { 
          if ($result==null) {
            $result = '{"error": 2}';    //error=2 --> user not exist.
          }
$result=array();
           $res = array();
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $res[] =$row ;}
            $result['data']=$res;

        } else {
          $result = '{"error": 1}';
        }

       return $result;

    }

public function getPaymentByUserID($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

       $result = '{"error": 0}';
       $table = 'item_order';

        if ($request_data == null) {
            return $result;
        }
        //var_dump($request_data);
        //$request_array = json_decode($request_data);
        $sql = 'select *
            from payment_transaction TR join payment_type TY on TR.type_id=TY.id 
            where TR.order_id='.$request_data['order_id'] ;

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':user', $request_data['order_id']);
        $stmt->execute();
        if ($stmt) { 
          if ($result==null) {
            $result = '{"error": 2}';    //error=2 --> user not exist.
          }
$result=array();
           $res = array();
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $res[] =$row ;}
            $result['data']=$res;

        } else {
          $result = '{"error": 1}';
        }

       return $result;

    }


    public function getSpinnerItem($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

       $result = '{"error": 0}';
       $table = 'item_order';

        if ($request_data == null) {
            return $result;
        }
        //var_dump($request_data);
        //$request_array = json_decode($request_data);
        $sql = 'select type_name,id from payment_type' ;

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':user', $request_data['id']);
        $stmt->execute();
        if ($stmt) { 
          if ($result==null) {
            $result = '{"error": 2}';    //error=2 --> user not exist.
          }
$result=array();
           $res = array();
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $res[] =$row ;}
            $result['data']=$res;

        } else {
          $result = '{"error": 1}';
        }

       return $result;

    }


public function insertPayment($path, $request_data)
    {
        $this->logger->info(substr(strrchr(rtrim(__CLASS__, '\\'), '\\'), 1).': '.__FUNCTION__);

       $result = '{"error": 0}';
       $table = 'item_order';

        if ($request_data == null) {
            return $result;
        }
        //var_dump($request_data);
        //$request_array = json_decode($request_data);
        // $sql = 'INSERT INTO payment_transaction(order_id,payment_date,type_id, payment_status,payment_amount) values('.$request_data['order_id'].','.$request_data['payment_date'].','.$request_data['type_id'].','.$request_data['payment_status'].','.$request_data['payment_amount'].')' ;

        $sql = "INSERT INTO payment_transaction(order_id,payment_date,type_id, payment_status,payment_amount, isactive) values(:user5, :user, :user3, :user2, :user4, 1)" ;

        $stmt = $this->pdo->prepare($sql);
        // bind the key
        $stmt->bindValue(':user', $request_data['payment_date']);
 $stmt->bindValue(':user2', $request_data['payment_status']);
 $stmt->bindValue(':user3', $request_data['type_id']);
 $stmt->bindValue(':user4', $request_data['payment_amount']);
 $stmt->bindValue(':user5', $request_data['order_id']);
        $stmt->execute();
$result=array();
        if ($stmt) { 
           
            $result['status'] = 1;    //error=2 --> user not exist.

        } else {
          $result['status'] = 2;
        }

       return $result;

    }
    
}
