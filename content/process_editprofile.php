<?php

session_start();
include('conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $role = $bio = $email = $photo_url = "";

// Prepare and execute the query to fetch user profile
$query = "SELECT * FROM m18_userprofiles WHERE m12_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_profile = $result->fetch_assoc();
$stmt->close();

// Fetch email from m12_signup table
$query_email = "SELECT m12_email FROM m12_signup WHERE m12_id = ?";
$stmt_email = $conn->prepare($query_email);
if ($stmt_email === false) {
    die('Error preparing the statement: ' . $conn->error);
}
$stmt_email->bind_param("i", $user_id);
$stmt_email->execute();
$email_result = $stmt_email->get_result();
$user_email = $email_result->fetch_assoc()['m12_email'];
$stmt_email->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if POST data is available
    $name = isset($_POST['18_name']) ? mysqli_real_escape_string($conn, $_POST['18_name']) : '';
    $role = isset($_POST['18_role']) ? mysqli_real_escape_string($conn, $_POST['18_role']) : '';
    $bio = isset($_POST['18_bio']) ? mysqli_real_escape_string($conn, $_POST['18_bio']) : '';
    $email = isset($_POST['18_email']) ? mysqli_real_escape_string($conn, $_POST['18_email']) : '';

    // Handle file upload for profile picture
    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == 0) {

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_info = pathinfo($_FILES['profile-pic']['name']);
        $extension = strtolower($file_info['extension']);

        if (in_array($extension, $allowed_extensions)) {

            $upload_dir = 'I:/wamp64/www/resc-main/content/images';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create directory if not exists
            }

            $new_photo_name = $upload_dir . uniqid() . '.' . $extension;

            if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $new_photo_name)) {
                $photo_url = $new_photo_name;
            } else {
                echo "Error uploading the file.";
                exit();
            }
        } else {
            echo "Only JPG, JPEG, and PNG files are allowed.";
            exit();
        }
    } else {
        // If no new file, keep the old photo URL
        $photo_url = $user_profile['18_photo_url'];
    }

    // Update user profile
    $query_update_profile = "UPDATE m18_userprofiles SET 18_name = ?, 18_role = ?, 18_bio = ?, 18_profile_photo_url = ? WHERE m12_id = ?";
    $stmt_update_profile = $conn->prepare($query_update_profile);
    if ($stmt_update_profile === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    $stmt_update_profile->bind_param("ssssi", $name, $role, $bio, $photo_url, $user_id);

    // Update email
    $query_update_user = "UPDATE m12_signup SET m12_email = ? WHERE m12_id = ?";
    $stmt_update_user = $conn->prepare($query_update_user);
    if ($stmt_update_user === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    $stmt_update_user->bind_param("si", $email, $user_id);

    // Execute both update queries
    if ($stmt_update_profile->execute() && $stmt_update_user->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    // Close prepared statements
    $stmt_update_profile->close();
    $stmt_update_user->close();
}
?>
