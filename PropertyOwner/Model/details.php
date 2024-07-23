<?php
    require '../../Database/db.php'; 

    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
    if (!isset($_POST['user_id']) || !isset($_FILES['profile_picture']) || !isset($_POST['profession']) || !isset($_POST['residence']) || !isset($_POST['pan_number']) || !isset($_POST['age'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    $user_id = $_POST['user_id'];
    $profession = $_POST['profession'];
    $residence = $_POST['residence'];
    $pan_number = $_POST['pan_number'];
    $age = $_POST['age'];

    
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = basename($_FILES['profile_picture']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $profile_picture;

       
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) {
                echo json_encode(['success' => false, 'message' => 'Failed to create uploads directory.']);
                exit;
            }
        }

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload profile picture.']);
            exit;
        }
    }

    
    $sql = "INSERT INTO user_details (user_id, profile_picture, profession, residence, pan_number, age, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
        exit;
    }

    $stmt->bind_param("issssi", $user_id, $profile_picture, $profession, $residence, $pan_number, $age);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit details. Error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

