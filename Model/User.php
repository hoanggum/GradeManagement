<?php
class User extends Db{
    public function getAllUsers() {
        return $this->getTable("users");
    }
    public function countUser() {
        $sql = "SELECT COUNT(*) AS NumberUser FROM users";
        return $this->selectQuery($sql);
    }
    public function addUser($fullName, $gender, $email, $address, $phone, $username, $password, $role, $deptId) {
        $sql = "INSERT INTO users (FullName, Gender, Email, Address, Phone, Username, Password, Role, DeptID) VALUES (:fullName, :gender, :email, :address, :phone, :username, :password, :role, :deptId)";
        $params = array(
            ':fullName' => $fullName,
            ':gender' => $gender,
            ':email' => $email,
            ':address' => $address,
            ':phone' => $phone,
            ':username' => $username,
            ':password' => $password,
            ':role' => $role,
            ':deptId' => $deptId
        );
        return $this->updateQuery($sql, $params);
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->updateQuery($sql, $params);
    }
    
    public function updateUser($userId, $fullName, $gender, $email, $address, $phone, $username, $password, $role, $deptId) {
        $sql = "UPDATE users SET FullName = :fullName, Gender = :gender, Email = :email, Address = :address, Phone = :phone, Username = :username, Password = :password, Role = :role, DeptID = :deptId WHERE UserID = :userId";
        $params = array(
            ':userId' => $userId,
            ':fullName' => $fullName,
            ':gender' => $gender,
            ':email' => $email,
            ':address' => $address,
            ':phone' => $phone,
            ':username' => $username,
            ':password' => $password,
            ':role' => $role,
            ':deptId' => $deptId
        );
        return $this->updateQuery($sql, $params);
    }
    
    public function getUserById($userId) {
        $sql = "SELECT users.*, i.Urls AS ImageURL 
                FROM users 
                INNER JOIN images i ON users.UserID = i.UserID  
                WHERE users.UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }
    public function getEmployeesByDeptId($deptId) {
        $sql = "SELECT users.*, img.url AS ImageURL,position.positionName FROM users INNER JOIN img ON users.UserID = img.UserID INNER JOIN position ON users.PositionID = position.PositionID WHERE DeptID = :deptId";
        $params = array(':deptId' => $deptId);
        return $this->selectQuery($sql, $params);
    }
    public function getAllEmployees() {
        $sql = "SELECT users.*, img.url AS ImageURL, position.positionName AS positionName
                FROM users 
                INNER JOIN img ON users.UserID = img.UserID 
                INNER JOIN position ON users.PositionID = position.PositionID";
        return $this->selectQuery($sql);
    }
    // public function addEmployee($fullName, $birthday, $gender, $email, $address, $phone, $username, $departmentID, $positionID, $imgPath, $status) {
    //     $sql = "CALL createEmployee(:fullName, :birthday, :gender, :email, :address, :phone, :username, :departmentID, :positionID, :imgPath,:status)";
    //     $params = array(
    //         ':fullName' => $fullName,
    //         ':birthday' => $birthday,
    //         ':gender' => $gender,
    //         ':email' => $email,
    //         ':address' => $address,
    //         ':phone' => $phone,
    //         ':username' => $username,
    //         ':departmentID' => $departmentID,
    //         ':positionID' => $positionID,
    //         ':imgPath' => $imgPath,
    //         ':status' => $status
    //     );
    //     return $this->updateQuery($sql, $params);
    // }
    public function addEmployee($fullName, $birthday, $gender, $email, $address, $phone, $username, $positionID, $deptID, $imgPath, $status) {
        try {
            // Begin a transaction
            $this->beginTransaction();
    
            // Insert into users table
            $sqlUser = "INSERT INTO users (FullName, Birthday, Gender, Email, Address, Phone, Username, Password, PositionID, DeptID, Status) 
                        VALUES (:fullName, :birthday, :gender, :email, :address, :phone, :username, MD5(RIGHT(:phone, 6)), :positionID, :deptID, :status)";
            $paramsUser = array(
                ':fullName' => $fullName,
                ':birthday' => $birthday,
                ':gender' => $gender,
                ':email' => $email,
                ':address' => $address,
                ':phone' => $phone,
                ':username' => $username,
                ':positionID' => $positionID,
                ':deptID' => $deptID,
                ':status' => $status
            );
            $this->updateQuery($sqlUser, $paramsUser);
    
            // Get the last inserted user ID
            $v_userID = $this->lastInsertId();
    
            // Insert into img table
            $sqlImg = "INSERT INTO img (UserID, Url) VALUES (:userID, :imgPath)";
            $paramsImg = array(
                ':userID' => $v_userID,
                ':imgPath' => $imgPath
            );
            $result = $this->updateQuery($sqlImg, $paramsImg);
    
            // Commit the transaction
            $this->commit();
            
            // Return true if both queries were successful, otherwise return false
            return $result !== false;
        } catch (Exception $e) {
            // Rollback the transaction if something went wrong
            $this->rollBack();
            throw $e;
        }
    }
    
    
    public function updateUserInfo($userID, $fullName, $userName, $userEmail, $userPhoneNumber, $userAddress) {
        $sql = "UPDATE users SET FullName = :fullName, Username = :userName, Email = :userEmail, Phone = :userPhoneNumber, Address = :userAddress WHERE UserID = :userID";
        $params = array(
            ':userID' => $userID,
            ':fullName' => $fullName,
            ':userName' => $userName,
            ':userEmail' => $userEmail,
            ':userPhoneNumber' => $userPhoneNumber,
            ':userAddress' => $userAddress
        );
        return $this->updateQuery($sql, $params);
    }
    public function updatePassword($userID, $newPassword) {
        $hashedNewPassword = md5($newPassword); // Mã hóa mật khẩu mới bằng MD5
        $sql = "UPDATE users SET Password = :newPassword WHERE UserID = :userID";
        $params = array(
            ':userID' => $userID,
            ':newPassword' => $hashedNewPassword
        );
        return $this->updateQuery($sql, $params);
    }
    public function getUserDetailsById($userId) {
        $sql = "
            SELECT 
                users.*, 
                department.deptName, 
                img.url AS ImageURL, 
                position.positionName 
            FROM users
            LEFT JOIN department ON users.DeptID = department.DeptID
            LEFT JOIN img ON users.UserID = img.UserID
            LEFT JOIN position ON users.PositionID = position.PositionID
            WHERE users.UserID = :userId
        ";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }
    public function updateEmployee($userId, $fullName, $birthday, $gender, $email, $address, $phone, $positionID, $deptID, $imgPath, $status) {
        try {
            // Begin a transaction
            $this->beginTransaction();

            // Update the users table
            $sqlUser = "UPDATE users 
                        SET FullName = :fullName, Birthday = :birthday, Gender = :gender, Email = :email, 
                            Address = :address, Phone = :phone, PositionID = :positionID, DeptID = :deptID, Status = :status 
                        WHERE UserID = :userId";
            $paramsUser = array(
                ':userId' => $userId,
                ':fullName' => $fullName,
                ':birthday' => $birthday,
                ':gender' => $gender,
                ':email' => $email,
                ':address' => $address,
                ':phone' => $phone,
                ':positionID' => $positionID,
                ':deptID' => $deptID,
                ':status' => $status
            );
            $this->updateQuery($sqlUser, $paramsUser);

            // Update the img table
            $sqlImg = "UPDATE img SET Url = :imgPath WHERE UserID = :userId";
            $paramsImg = array(
                ':userId' => $userId,
                ':imgPath' => $imgPath
            );
            $result = $this->updateQuery($sqlImg, $paramsImg);

            // Commit the transaction
            $this->commit();

            // Return true if both queries were successful, otherwise return false
            return $result !== false;
        } catch (Exception $e) {
            // Rollback the transaction if something went wrong
            $this->rollBack();
            throw $e;
        }
    }
    public function getPasswordById($userId) {
        $sql = "SELECT Password FROM users WHERE UserID = :userId";
        $params = array(':userId' => $userId);
        return $this->selectQuery($sql, $params);
    }
    public function countUsersByRole($roleName) {
        $sql = "SELECT COUNT(*) AS UserCount FROM users WHERE Role = :roleName";
        $params = array(':roleName' => $roleName);
        $result = $this->selectQuery($sql, $params);
        // Trả về số lượng người dùng có vai trò là roleName
        return $result[0]['UserCount'];
    }
    public function getUsersByRole($roleName) {
        $sql = "SELECT * FROM users WHERE Role = :roleName";
        $params = array(':roleName' => $roleName);
        return $this->selectQuery($sql, $params);
    }
    public function updateUserRole($userID, $role) {
        $sql = "UPDATE users SET Role = :role WHERE UserID = :userID";
        $params = array(
            ':userID' => $userID,
            ':role' => $role
        );
        return $this->updateQuery($sql, $params);
    }
    public function storeResetToken($email, $token) {
        $sql = "INSERT INTO password_resets (email, token) VALUES (:email, :token) ON DUPLICATE KEY UPDATE token = :token";
        $params = array(
            ':email' => $email,
            ':token' => $token
        );
        return $this->updateQuery($sql, $params);
    }

    public function getUserByResetToken($token) {
        $sql = "SELECT users.* FROM users 
                INNER JOIN password_resets ON users.Email = password_resets.email 
                WHERE password_resets.token = :token";
        $params = array(':token' => $token);
        return $this->selectQuery($sql, $params);
    }

    // Hàm xóa reset token
    public function deleteResetToken($token) {
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $params = array(':token' => $token);
        return $this->updateQuery($sql, $params);
    }
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE Email = :email";
        $params = array(':email' => $email);
        return $this->selectQuery($sql, $params);
    }
    


}
?>
