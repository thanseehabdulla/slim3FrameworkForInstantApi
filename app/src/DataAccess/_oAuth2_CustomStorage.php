<?php

namespace App\DataAccess;

use OAuth2\Storage\Pdo;

/**
 * Class _oAuth2_CustomStorage
 */
 
class _oAuth2_CustomStorage extends Pdo 
{
    protected $db;
    protected $config;

    public function __construct($connection, $config = array())
    {
        parent::__construct($connection,$config);
        $this->config['user_table'] = 'users';
    }

    public function getUser($username)
    {
        $stmt = $this->db->prepare($sql = sprintf('SELECT id, name, email, password from %s where email=:username', $this->config['user_table']));
        $stmt->execute(array('username' => $username));

        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        // we use id as the user_id
        return array_merge(array(
            'user_id' => $userInfo['id']
        ), $userInfo);
    }
    
}
