<?php
class UserModel
{
    function create($post)
    {
        $DB = new Database();
        $data = [
            'full_name' => $post['full_name'],
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
        ];
        $query = "INSERT INTO users (full_name, username, password) VALUES (:full_name, :username, :password)";
        $result = $DB->write($query, $data);
        return $result ? true : false;
    }

    function selectAllAccounts()
    {
        $DB = new Database();
        $query = "SELECT a.*, u.username
                  FROM accounts a
                  LEFT JOIN users u ON a.user_id = u.user_id";
        $result = $DB->read($query);
        return $result ? $result : false;
    }

    function selectAllLoginAttempts()
    {
        $DB = new Database();
        $query = "SELECT * FROM login_attempts ORDER BY timestamp DESC";
        $result = $DB->read($query);
        return $result ? $result : false;
    }

    function selectAllWithdrawals()
    {
        $DB = new Database();
        $query = "SELECT w.withdrawal_id, a.account_number, u.username, w.amount, w.date 
                  FROM withdrawals w
                  JOIN accounts a ON w.account_id = a.account_id
                  JOIN users u ON a.user_id = u.user_id
                  ORDER BY w.date DESC";
        $result = $DB->read($query);
        return $result ? $result : false;
    }

    function selectAllDeposits()
    {
        $DB = new Database();
        $query = "SELECT d.deposit_id, a.account_number, u.username, d.amount, d.date 
                  FROM deposits d
                  JOIN accounts a ON d.account_id = a.account_id
                  JOIN users u ON a.user_id = u.user_id
                  ORDER BY d.date DESC";
        $result = $DB->read($query);
        return $result ? $result : false;
    }

    function insertLoginAttempt($username, $success)
    {
        $DB = new Database();
        $data = [
            'username' => $username,
        ];

        // Step 1: Check if the username exists and get the user_id
        $query = "SELECT user_id FROM users WHERE username = :username";
        $result = $DB->read($query, $data);
        if ($result) {
            $user_id = $result[0]->user_id;
            $attemptData = [
                'user_id' => $user_id,
                'username' => $username,
                'ip_address' => getUserIpAddr(),
                'timestamp' => manilaTimeZone('Y-m-d H:i:s'),
                'success' => $success ? 1 : 0,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ];

            // Step 2: Insert into the login_attempts table
            $insertQuery = "INSERT INTO login_attempts (user_id, username, ip_address, timestamp, success, user_agent) 
                            VALUES (:user_id, :username, :ip_address, :timestamp, :success, :user_agent)";
            $DB->write($insertQuery, $attemptData);
            return true;
        }
        return false;
    }

    function selectUser($post)
    {
        $DB = new Database();
        $data = [
            'username' => $post['username'],
        ];
        $query = "SELECT * FROM users WHERE username = :username";
        $result = $DB->read($query, $data);
        return $result ? $result : false;
    }
    // Method to find a user by their email address
    public function findByEmail($email)
    {
        $DB = new Database();
        $data = [
            'email' => $email,
        ];

        $query = "SELECT * FROM users WHERE email = :email"; // Assuming you have an 'email' column in your users table
        $result = $DB->read($query, $data);
        return $result ? $result[0] : false; // Return the first result or false if no user is found
    }
    // Method to store OTP in the database
    public function storeOtp($userId, $otp)
    {
        $DB = new Database();
        $data = [
            'user_id' => $userId,
            'otp' => $otp,
            'created_at' => manilaTimeZone('Y-m-d H:i:s'), // Assuming you have a function to get the current time
        ];

        // Assuming you have an otp_requests table to store OTPs
        $query = "INSERT INTO otp_requests (user_id, otp, created_at) VALUES (:user_id, :otp, :created_at)";
        $result = $DB->write($query, $data);

        return $result ? true : false; // Return true if insertion was successful
    }

    // Method to initiate password reset process
    function resetPassword($username, $newPassword)
    {
        $DB = new Database();

        // Step 1: Check if the username exists
        $data = [
            'username' => $username,
        ];
        $query = "SELECT user_id FROM users WHERE username = :username";
        $result = $DB->read($query, $data);

        if ($result) {
            $user_id = $result[0]->user_id;

            // Step 2: Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Step 3: Update the user's password in the database
            $updateData = [
                'password' => $hashedPassword,
                'user_id' => $user_id,
            ];
            $updateQuery = "UPDATE users SET password = :password WHERE user_id = :user_id";
            $updateResult = $DB->write($updateQuery, $updateData);

            return $updateResult ? true : false;
        }

        return false; // Username not found
    }

    function logout()
    {
        session_destroy();
    }
}
