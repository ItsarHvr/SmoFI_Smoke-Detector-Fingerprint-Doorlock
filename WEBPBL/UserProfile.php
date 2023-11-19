<?php
require_once "database.php"; 

class UserProfile
{
    private $conn;
    private $userId;

    public function __construct(Database $db, $userId)
    {
        $this->conn = $db->getConnection();
        $this->userId = $userId;
    }

    public function getUserData()
    {
        $sql = "SELECT full_name, email, alamat, password FROM users WHERE id = ?";

        $stmt = mysqli_stmt_init($this->conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $this->userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $userData = mysqli_fetch_assoc($result);
                return $userData;
            } else {
                // Handle error fetching user data
                return false;
            }
        } else {
            // Handle error preparing SQL statement
            return false;
        }
    }
}
?>
