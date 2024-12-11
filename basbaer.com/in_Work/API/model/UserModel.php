<?php
require_once PROJECT_ROOT_PATH . "/model/Database.php";

class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function addUser($email, $password_hash) {
        echo "Usermodel/addUser called";
    }
}
