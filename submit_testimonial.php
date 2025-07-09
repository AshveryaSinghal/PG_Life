<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['property_id']) || !isset($_POST['testimonial'])) {
    die("Invalid request.");
}

$user_id = $_SESSION['user_id'];
$property_id = $_POST['property_id'];
$content = mysqli_real_escape_string($conn, $_POST['testimonial']);

// Insert testimonial
$sql = "INSERT INTO testimonials (user_id, property_id, content) VALUES ('$user_id', '$property_id', '$content')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error inserting testimonial: " . mysqli_error($conn));
}

$testimonial_id = mysqli_insert_id($conn);

// Handle image uploads
$image_paths = [];

if (isset($_FILES['review_images']) && count($_FILES['review_images']['name']) > 0) {
    $total_files = count($_FILES['review_images']['name']);
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_files = 4;

    for ($i = 0; $i < min($total_files, $max_files); $i++) {
        $tmp_name = $_FILES['review_images']['tmp_name'][$i];
        $name = basename($_FILES['review_images']['name'][$i]);
        $type = $_FILES['review_images']['type'][$i];

        // Validate image type
        if (!in_array($type, $allowed_types)) {
            continue;
        }

        // Create upload folder if doesn't exist
        $upload_dir = "uploads/review_images/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique name
        $target_file = $upload_dir . time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $name);

        // Move file
        if (move_uploaded_file($tmp_name, $target_file)) {
            $path = mysqli_real_escape_string($conn, $target_file);

            // Save in testimonial_images table
            $img_sql = "INSERT INTO testimonial_images (testimonial_id, image_path) VALUES ('$testimonial_id', '$path')";
            mysqli_query($conn, $img_sql);
        }
    }
}

// Redirect
header("Location: property_detail.php?property_id=" . $property_id);
exit;
?>
