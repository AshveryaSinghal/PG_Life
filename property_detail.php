<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id = $_GET["property_id"];
$property_id = $_GET['property_id'];


// Get property details
$sql_1 = "SELECT *, p.id AS property_id, p.name AS property_name, c.name AS city_name 
          FROM properties p
          INNER JOIN cities c ON p.city_id = c.id 
          WHERE p.id = $property_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$property = mysqli_fetch_assoc($result_1);
if (!$property) {
    echo "Something went wrong!";
    return;
}

// Get next property
$sql_next = "SELECT id FROM properties 
             WHERE city_id = {$property['city_id']} AND id > $property_id 
             ORDER BY id ASC LIMIT 1";
$result_next = mysqli_query($conn, $sql_next);
$next_property = mysqli_fetch_assoc($result_next);

// Get previous property
$sql_prev = "SELECT id FROM properties 
             WHERE city_id = {$property['city_id']} AND id < $property_id 
             ORDER BY id DESC LIMIT 1";
$result_prev = mysqli_query($conn, $sql_prev);
$prev_property = mysqli_fetch_assoc($result_prev);


$sql_2 = "
    SELECT 
        t.*, 
        COALESCE(u.full_name, t.user_name) AS full_name,
        COALESCE(u.profile_img, t.profile_img) AS profile_img
    FROM testimonials t
    LEFT JOIN users u ON t.user_id = u.id
    WHERE t.property_id = $property_id
    ORDER BY t.id DESC
";


$result_2 = mysqli_query($conn, $sql_2);

if (!$result_2) {
    echo "Something went wrong!";
    return;
}

$testimonials = mysqli_fetch_all($result_2, MYSQLI_ASSOC);


// Get amenities
$sql_3 = "SELECT a.* 
          FROM amenities a
          INNER JOIN properties_amenities pa ON a.id = pa.amenity_id
          WHERE pa.property_id = $property_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$amenities = mysqli_fetch_all($result_3, MYSQLI_ASSOC);

// Get interested users
$sql_4 = "SELECT * FROM interested_users_properties WHERE property_id = $property_id";
$result_4 = mysqli_query($conn, $sql_4);
if (!$result_4) {
    echo "Something went wrong!";
    return;
}
$interested_users = mysqli_fetch_all($result_4, MYSQLI_ASSOC);
$interested_users_count = mysqli_num_rows($result_4);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $property['property_name']; ?> | PG Life</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/property_detail.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="property_list.php?city=<?= $property['city_name']; ?>"><?= $property['city_name']; ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $property['property_name']; ?>
            </li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $property_images = glob("img/properties/" . $property['property_id'] . "/*");
            foreach ($property_images as $index => $property_image) {
            ?>
                <li data-target="#property-images" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active" : ""; ?>"></li>
            <?php
            }
            ?>
        </ol>
        <!-- <div class="carousel-inner">
            <?php
            foreach ($property_images as $index => $property_image) {
            ?>
                <div class="carousel-item <?= $index == 0 ? "active" : ""; ?>">
                    <img class="d-block w-100" src="<?= $property_image ?>" alt="slide">
                </div>
            <?php
            }
            ?>
        </div> -->
        <!-- Modify the carousel-inner div to add click handlers -->
<div class="carousel-inner">
    <?php
    foreach ($property_images as $index => $property_image) {
    ?>
        <div class="carousel-item <?= $index == 0 ? "active" : ""; ?>">
            <img class="d-block w-100 property-image-popup" 
                 src="<?= $property_image ?>" 
                 alt="Property image"
                 data-index="<?= $index ?>">
        </div>
    <?php
    }
    ?>
</div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
            <?php
            $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
            $total_rating = round($total_rating, 1);
            ?>
            <div class="star-container" title="<?= $total_rating ?>">
                <?php
                $rating = $total_rating;
                for ($i = 0; $i < 5; $i++) {
                    if ($rating >= $i + 0.8) {
                ?>
                        <i class="fas fa-star"></i>
                    <?php
                    } elseif ($rating >= $i + 0.3) {
                    ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php
                    } else {
                    ?>
                        <i class="far fa-star"></i>
                <?php
                    }
                }
                ?>
            </div>
            <div class="interested-container">
                <?php
                $is_interested = false;
                foreach ($interested_users as $interested_user) {
                    if ($interested_user['user_id'] == $user_id) {
                        $is_interested = true;
                    }
                }

                if ($is_interested) {
                ?>
                    <i class="is-interested-image fas fa-heart"></i>
                <?php
                } else {
                ?>
                    <i class="is-interested-image far fa-heart"></i>
                <?php
                }
                ?>
                <div class="interested-text">
                    <span class="interested-user-count"><?= $interested_users_count ?></span> interested
                </div>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?= $property['property_name'] ?></div>
            <div class="property-address"><?= $property['address'] ?></div>
            <div class="property-gender">
                <?php
                if ($property['gender'] == "male") {
                ?>
                    <img src="img/male.png">
                <?php
                } elseif ($property['gender'] == "female") {
                ?>
                    <img src="img/female.png">
                <?php
                } else {
                ?>
                    <img src="img/unisex.png">
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="rent">₹ <?= number_format($property['rent']) ?>/-</div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <a href="#" class="btn btn-primary">Book Now</a>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5>Building</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Building") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Common Area") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Bedroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Washroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?= $property['description'] ?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_clean'] ?>">
                            <?php
                            $rating = $property['rating_clean'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_food'] ?>">
                            <?php
                            $rating = $property['rating_food'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_safety'] ?>">
                            <?php
                            $rating = $property['rating_safety'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rating-circle">
                        <?php
                        $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                        $total_rating = round($total_rating, 1);
                        ?>
                        <div class="total-rating"><?= $total_rating ?></div>
                        <div class="rating-circle-star-container">
                            <?php
                            $rating = $total_rating;
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                     

<div class="property-testimonials page-container">
    <h1>What people say</h1>

    <?php foreach ($testimonials as $testimonial): ?>
        <?php
         

$profile_img = !empty($testimonial['profile_img']) ? $testimonial['profile_img'] : 'uploads/default.jpg';
    $user_name = !empty($testimonial['full_name']) ? $testimonial['full_name'] : 'Anonymous';




            // Get review images for this testimonial
            $testimonial_id = $testimonial['id'];
            $review_images = [];
            $img_result = mysqli_query($conn, "SELECT image_path FROM testimonial_images WHERE testimonial_id = $testimonial_id");
            while ($img_row = mysqli_fetch_assoc($img_result)) {
                $review_images[] = $img_row['image_path'];
            }
        ?>
        <div class="testimonial-block" style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div class="testimonial-image-container">
    <div class="profile-wrapper">
        <img class="testimonial-img" src="<?= htmlspecialchars($profile_img) ?>" alt="User image">
    </div>
</div>

            <!-- <div class="testimonial-text" style="flex: 1;">
                <i class="fa fa-quote-left" aria-hidden="true"></i>
                <p><?= htmlspecialchars($testimonial['content']) ?></p> -->
                <div class="testimonial-text" style="flex: 1; word-break: break-word; overflow-wrap: break-word; white-space: normal; max-width: 100%;">
    <i class="fa fa-quote-left" aria-hidden="true"></i>
    <p style="margin: 0; word-break: break-word; overflow-wrap: break-word; white-space: normal; max-width: 100%;">
        <?= htmlspecialchars($testimonial['content']) ?>
    </p>


                <?php if (!empty($review_images)): ?>
                    <div class="review-images-row"
                         style="display: flex; gap: 10px; margin-top: 10px; overflow-x: auto; padding-bottom: 10px;">
                        <?php foreach ($review_images as $image): ?>
                            <img src="<?= htmlspecialchars($image) ?>"
                                 class="review-image-popup"
                                 alt="Uploaded PG photo"
                                 style="width: 150px; height: auto; border-radius: 5px; cursor: pointer; flex-shrink: 0;">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                    <span>- <?= htmlspecialchars($user_name) ?></span>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $testimonial['user_id']): ?>
                        <form method="POST" action="delete_testimonial.php"
                              onsubmit="return confirm('Are you sure you want to delete this review?');"
                              style="margin: 0;">
                            <input type="hidden" name="testimonial_id" value="<?= $testimonial['id'] ?>">
                            <input type="hidden" name="property_id" value="<?= $property_id ?>">
                            <button type="submit" class="btn btn-link text-danger p-0" title="Delete Review">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Review Form -->
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="page-container" style="margin-top: 40px;">
        <h1>Give Reviews</h1>
        <form id="review-form" enctype="multipart/form-data">
    <input type="hidden" name="property_id" value="<?= $property_id ?>">

    <div class="form-group">
        <textarea name="testimonial" rows="4" class="form-control" placeholder="Write your review here..." required></textarea>
    </div>

    <div class="form-group">
        <label for="review_images">Upload up to 4 images (you can add one-by-one or multiple):</label>
        <input type="file" id="review_images" accept="image/*" multiple>
    </div>

    <!-- Preview container -->
    <div id="preview-container" style="margin-bottom: 10px;"></div>

    <button type="submit" class="btn btn-primary">Submit Review</button>
</form>

    </div>
<?php else: ?>
    <div class="page-container" style="margin-top: 40px;">
        <p><a href="#" data-toggle="modal" data-target="#login-modal">Login</a> to give a review.</p>
    </div>
<?php endif; ?>


<!-- Navigation -->
<div class="page-container text-center" style="margin-top: 40px;">
    <div class="btn-group" role="group" aria-label="Navigation">
        <?php if ($prev_property): ?>
            <a href="property_detail.php?property_id=<?= $prev_property['id'] ?>" class="btn btn-primary mx-5">
                &laquo; Previous Property
            </a>
        <?php endif; ?>

        <?php if ($next_property): ?>
            <a href="property_detail.php?property_id=<?= $next_property['id'] ?>" class="btn btn-primary mx-5">
                Next Property &raquo;
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Image Modal -->
<!-- Image Modal -->
<div id="review-image-modal" class="image-popup"
     style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
    
    <span class="close-popup"
          style="position: absolute; top: 20px; right: 30px; font-size: 40px; color: white; cursor: pointer;">&times;</span>

    <!-- Navigation Arrows -->
    <span id="prev-image" style="position: absolute; left: 20px; font-size: 50px; color: white; cursor: pointer;">&#10094;</span>
    <span id="next-image" style="position: absolute; right: 20px; font-size: 50px; color: white; cursor: pointer;">&#10095;</span>

    <!-- Image -->
    <img class="popup-img" id="popup-img" src="" alt="Popup image"
         style="max-width: 90%; max-height: 90%; border-radius: 10px;">
</div>


<?php
include "includes/signup_modal.php";
include "includes/login_modal.php";
include "includes/footer.php";
?>

<script type="text/javascript" src="js/property_detail.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById('review_images');
    const previewContainer = document.getElementById('preview-container');
    const form = document.getElementById('review-form');

    let selectedFiles = [];

    fileInput.addEventListener('change', function (e) {
        const newFiles = Array.from(e.target.files);

        newFiles.forEach(file => {
            if (selectedFiles.length < 4) {
                selectedFiles.push(file);
            }
        });

        updatePreview();
        fileInput.value = ''; // Clear input so same file can be selected again
    });

    function updatePreview() {
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.margin = '5px';
                img.style.borderRadius = '5px';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '❌';
                removeBtn.style.marginLeft = '5px';
                removeBtn.style.border = 'none';
                removeBtn.style.cursor = 'pointer';
                removeBtn.onclick = function () {
                    selectedFiles.splice(index, 1);
                    updatePreview();
                };

                const wrapper = document.createElement('div');
                wrapper.style.display = 'inline-block';
                wrapper.style.position = 'relative';
                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);

                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        selectedFiles.forEach(file => {
            formData.append('review_images[]', file);
        });

        fetch('submit_testimonial.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            alert("Review submitted successfully!");
            window.location.href = "property_detail.php?property_id=" + <?= $property_id ?>;
        })
        .catch(error => {
            alert("There was an error submitting the review.");
            console.error(error);
        });
    });
});
</script>

<script>

document.addEventListener("DOMContentLoaded", function() {
    const popup = document.getElementById('review-image-modal');
    const popupImg = document.getElementById('popup-img');
    const closeBtn = document.querySelector('.close-popup');
    const prevBtn = document.getElementById('prev-image');
    const nextBtn = document.getElementById('next-image');

    let currentImageIndex = 0;
    let currentImageList = [];

    // Handle property image clicks
    document.querySelectorAll('.property-image-popup').forEach(img => {
        img.addEventListener('click', function() {
            // Get all property images
            currentImageList = Array.from(document.querySelectorAll('.property-image-popup')).map(img => img.src);
            currentImageIndex = parseInt(this.getAttribute('data-index'));

            popupImg.src = this.src;
            popup.style.display = 'flex';
        });
    });

    // Handle testimonial image clicks (your existing code)
    document.querySelectorAll('.review-image-popup').forEach(img => {
        img.addEventListener('click', function() {
            const parentRow = this.closest('.review-images-row');
            currentImageList = Array.from(parentRow.querySelectorAll('.review-image-popup')).map(img => img.src);
            currentImageIndex = currentImageList.indexOf(this.src);

            popupImg.src = this.src;
            popup.style.display = 'flex';
        });
    });

    // Navigation (works for both property and testimonial images)
    prevBtn.addEventListener('click', function() {
        if (currentImageList.length === 0) return;
        currentImageIndex = (currentImageIndex - 1 + currentImageList.length) % currentImageList.length;
        popupImg.src = currentImageList[currentImageIndex];
    });

    nextBtn.addEventListener('click', function() {
        if (currentImageList.length === 0) return;
        currentImageIndex = (currentImageIndex + 1) % currentImageList.length;
        popupImg.src = currentImageList[currentImageIndex];
    });

    // Close popup
    closeBtn.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Click outside image closes modal
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (popup.style.display === 'flex') {
            if (e.key === 'ArrowLeft') {
                prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                nextBtn.click();
            } else if (e.key === 'Escape') {
                popup.style.display = 'none';
            }
        }
    });
});
</script>
