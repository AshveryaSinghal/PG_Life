<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$property_id = $_POST['property_id'];
$testimonial = trim($_POST['testimonial']);

if ($testimonial == "") {
    header("Location: property_detail.php?property_id=" . $property_id);
    exit;
}

// Fetch the user's name and profile image
$sql_user = "SELECT full_name, profile_img FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);
$user_name = $user['full_name'] ?? 'Anonymous';
$profile_img = $user['profile_img'] ?? 'uploads/default.jpg'; // Default image if none exists

// Insert testimonial with user_id
$sql_insert = "INSERT INTO testimonials (user_id, user_name, property_id, content, profile_img) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql_insert);
mysqli_stmt_bind_param($stmt, "isiss", $user_id, $user_name, $property_id, $testimonial, $profile_img);
mysqli_stmt_execute($stmt);

header("Location: property_detail.php?property_id=" . $property_id);
exit;