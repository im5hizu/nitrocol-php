<?php
class Read {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readData() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

class readSetUser{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readSetUserData($user) {
        $query = "SELECT * FROM users WHERE username = '".$user."'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>