<?php
session_start();
require "../includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    echo "Unauthorized access!";
    exit;
}

$user_id = $_SESSION["user_id"];


$full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
$phone = mysqli_real_escape_string($conn, $_POST["phone"]);

$profile_img_path = "";

// Handle profile picture upload if a file is selected
if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
    $target_dir = "../uploads/";
    
    // Create the uploads folder if not exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Prepare file
    $file_tmp = $_FILES["profile_picture"]["tmp_name"];
    $file_ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
    $file_name = "user_" . $user_id . "." . $file_ext;
    $target_file = $target_dir . $file_name;

    // Move file
    if (move_uploaded_file($file_tmp, $target_file)) {
        $profile_img_path = "uploads/" . $file_name;
    }
}

// Update query
$update_query = "UPDATE users SET full_name = '$full_name', phone = '$phone'";
if ($profile_img_path !== "") {
    $update_query .= ", profile_img = '$profile_img_path'";
}
$update_query .= " WHERE id = $user_id";

// Run query
if (mysqli_query($conn, $update_query)) {
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "Error updating profile!";
}
