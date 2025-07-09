<?php
session_start();
require "includes/database_connect.php";

// Validate session and input
if (!isset($_SESSION['user_id']) || !isset($_POST['property_id']) || !isset($_POST['testimonial'])) {
    die("Invalid request.");
}

$user_id = $_SESSION['user_id'];
$property_id = intval($_POST['property_id']);
$content = mysqli_real_escape_string($conn, trim($_POST['testimonial']));

// Insert testimonial
$sql = "INSERT INTO testimonials (user_id, property_id, content) VALUES ('$user_id', '$property_id', '$content')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error inserting testimonial: " . mysqli_error($conn));
}

$testimonial_id = mysqli_insert_id($conn);

// Handle image uploads
if (!empty($_FILES['review_images']['name'][0])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_files = 4;
    $upload_dir = "uploads/review_images/";

    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $total_files = count($_FILES['review_images']['name']);
    for ($i = 0; $i < min($total_files, $max_files); $i++) {
        $tmp_name = $_FILES['review_images']['tmp_name'][$i];
        $original_name = basename($_FILES['review_images']['name'][$i]);
        $type = $_FILES['review_images']['type'][$i];

        // Validate file type
        if (!in_array($type, $allowed_types)) {
            continue;
        }

        // Generate unique file name
        $safe_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $original_name);
        $target_file = $upload_dir . time() . "_" . $safe_name;

        // Move file to destination
        if (move_uploaded_file($tmp_name, $target_file)) {
            $escaped_path = mysqli_real_escape_string($conn, $target_file);
            $img_sql = "INSERT INTO testimonial_images (testimonial_id, image_path) VALUES ('$testimonial_id', '$escaped_path')";
            mysqli_query($conn, $img_sql);
        }
    }
}

// Redirect back to the property detail page
header("Location: property_detail.php?property_id=" . $property_id);
exit;
?>
