<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$testimonial_id = $_POST['testimonial_id'];
$property_id = $_POST['property_id'];
$user_id = $_SESSION['user_id'];

// First, check if the testimonial belongs to this user
$sql_check = "SELECT * FROM testimonials WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt, "ii", $testimonial_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$testimonial = mysqli_fetch_assoc($result);

if (!$testimonial) {
    header("Location: property_detail.php?property_id=" . $property_id);
    exit;
}

// Delete the testimonial
$sql_delete = "DELETE FROM testimonials WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $testimonial_id);
mysqli_stmt_execute($stmt_delete);

// Optional: also delete uploaded image if exists
if (!empty($testimonial['review_image']) && file_exists($testimonial['review_image'])) {
    unlink($testimonial['review_image']);
}

header("Location: property_detail.php?property_id=" . $property_id);
exit;
?>
