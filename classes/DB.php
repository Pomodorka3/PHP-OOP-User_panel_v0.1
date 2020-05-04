<?php

class DB
{
    private static $_instance = null;
    private $_pdo,
            $_query = '',    
            $_error = null, 
            $_results,
            $_count = 0;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:dbname='.Config::get('mysql/db').';host'.Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/pass'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //Creates instance of this class (kind of Singleton)
    public static function getInstance(){
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    //Sends SQL query to database
    public function query($sql, $params = array())
    {
        $this->_error = false;
        $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    //Function which is used to construct SQL queries
    private function action($action, $table, $where = array()){
        if (count($where) === 3) {
            $operators = array('=', '<', '>', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE $field $operator ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    //Constructs SELECT query
    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    //Constructs DELETE query
    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    //Constructs UPDATE query
    public function update($table, $id, $fields){
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    //Creates INSERT query
    public function insert($table, $fields = array())
    {
        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    //Gets first result from query return
    public function first(){
        return $this->results()[0];
    }

    //Gets all results from query return
    public function results(){
        return $this->_results;
    }

    //Gets content of private parameter containing errors
    public function error()
    {
        return $this->_error;
    }

    //Count results
    public function count()
    {
        return $this->_count;
    }
}