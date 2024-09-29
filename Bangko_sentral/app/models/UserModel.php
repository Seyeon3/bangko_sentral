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

    // Updated: Including the username in withdrawal records
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

    // Updated: Including the username in deposit records
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
            $DB->write($insertQuery, $attemptData); // Assuming you have a write method for insert operations
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

    function logout()
    {
        session_destroy();
    }
}

