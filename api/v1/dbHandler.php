<?php

class DbHandler {

    private $conn;

    function __construct() {

        require_once 'dbConnect.php';
        $db = new dbConnect();
        $this->conn = $db->connect();
    }

    public function updateTable($query) {
        $this->conn->query($query) or die($this->conn->error.__LINE__);
    }

    public function delete($query) {
        $this->conn->query($query) or die($this->conn->error.__LINE__);
    }

    public function executeQuery($query) {
        
        $values = array();

        $result = $this->conn->query($query) or die($this->conn->error.__LINE__);

        while ($row = $result->fetch_assoc()) {
            $values[] = array_map('utf8_encode', $row);;
        }
        
        return $values;
    }

    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();    
    }

    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {
        
        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = '';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }

    public function getSession(){
        
        $this->initSession();

        unset($_SESSION['slim.flash']);

        return $_SESSION;
    }

    public function destroySession(){
        
        $this->initSession();

        session_unset();

    }

    public function initSession() {

        if (!isset($_SESSION)) {

            session_start();
        }

    }

    public function insertInSession($name, $value) {
        
        $this->initSession();

        $_SESSION[$name] = $value;
    }
 
}