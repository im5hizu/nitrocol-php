<?php
class Update {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function updateData($id, $nom, $email){
        $query = "UPDATE users SET :nom, :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nom" , $nom);
        $stmt->bindParam(":email" , $email);
        $stmt->bindParam(":id", $id);
        if($stmt-> execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>