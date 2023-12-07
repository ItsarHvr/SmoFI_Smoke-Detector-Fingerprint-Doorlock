<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "login_register";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

    }

    public function getConnection(){
        return $this->conn;
    }

    public function closeConnection(){
        $this->conn->close();
    }

    public function updateUsername($userId, $newUsername) {
        $stmt = $this->conn->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        $stmt->bind_param("si", $newUsername, $userId);
        
        if ($stmt->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }
    
    
    public function updateEmail($userId, $newEmail) {
        $stmt = $this->conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $newEmail, $userId);
        
        if ($stmt->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }
    
    public function updatePassword($userId, $newPassword) {
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $newPassword, $userId);
        
        if ($stmt->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }
    

}


?>
