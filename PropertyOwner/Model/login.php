<?php
    require '../../Database/db.php';

    session_start(); 

    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }

    
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            
            $user_id = $user['id'];
            $sql_check = "SELECT 1 FROM user_details WHERE user_id = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("i", $user_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows === 1) {
               
                echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
            } else {
                
                echo json_encode(['success' => true, 'redirect' => 'details.html?user_id=' . $user_id]);
                
                
            }

          
            $stmt_check->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }

   
    $stmt->close();
    $conn->close();

