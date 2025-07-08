<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
    die();
}
$user_id = $_SESSION['user_id'];

$sql_1 = "SELECT * FROM users WHERE id = $user_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$user = mysqli_fetch_assoc($result_1);
if (!$user) {
    echo "Something went wrong!";
    return;
}

$sql_2 = "SELECT * 
            FROM interested_users_properties iup
            INNER JOIN properties p ON iup.property_id = p.id
            WHERE iup.user_id = $user_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$interested_properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | PG Life</title>

    <?php include "includes/head_links.php"; ?>
    <link href="css/dashboard.css" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
<style>
   
.theme {
    display: flex;
    align-items: center;
    margin-top: 24px;
    gap: 12px;
}

.theme-toggle-switch {
    width: 50px;
    height: 26px;
    border-radius: 20px;
    background-color: #ccc;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s ease;
   
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
   
    -moz-outline: none !important;
    
    -webkit-focus-ring-color: none !important;
}

.toggle-slider {
    position: absolute;
    height: 22px;
    width: 22px;
    border-radius: 50%;
    background-color: #fff;
    top: 2px;
    left: 2px;
    transition: transform 0.3s ease;
   
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
}

.theme-toggle-switch.active {
    background-color: #2196F3;
}

.theme-toggle-switch.active .toggle-slider {
    transform: translateX(24px);
}

.theme-toggle-text {
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.theme-toggle-container *:focus,
.theme-toggle-container *:focus-visible,
.theme-toggle-container *:focus-within,
.theme-toggle-container *:active {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
}

@-moz-document url-prefix() {
    .theme-toggle-switch {
        outline: 0 !important;
    }
}

@media not all and (min-resolution:.001dpcm) { 
    .theme-toggle-switch {
        outline: none !important;
    }
}



</style>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="my-profile page-container">
        <h1>My Profile</h1>
        <div class="row">
            <div class="col-md-3 profile-img-container">
                <img src="<?= $user['profile_img'] ?? 'uploads/default.jpg' ?>" class="profile-img" id="profile-picture" alt="Profile Picture">
            </div>
            <div class="col-md-9">
                <div class="row no-gutters justify-content-between align-items-end">
                    <div class="profile">
                        <div class="name"><?= $user['full_name'] ?></div>
                        <div class="email"><?= $user['email'] ?></div>
                        <div class="phone"><?= $user['phone'] ?></div>
                        <div class="college"><?= $user['college_name'] ?></div>
                    </div>
                    <div class="edit">
                        <div class="edit-profile" onclick="document.getElementById('edit-form').style.display='block'">Edit Profile</div>
                    </div>
                </div>

                <form id="edit-form" action="api/update_profile.php" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 20px;">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= $user['phone'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('edit-form').style.display='none'">Cancel</button>
                </form>

                <!-- Theme Toggle -->
                <!-- <div class="theme-toggle-container">
                    <div class="theme-toggle-switch" id="theme-toggle-switch">
                        <div class="toggle-slider"></div>
                    </div>
                    <span id="theme-label">Dark Mode</span>
                </div> -->
               <div class= 'theme'><div class="theme-toggle-switch" id="theme-toggle-switch">
                        <div class="toggle-slider"></div>
                    </div>
                    <span id="theme-label">Dark Mode</span></div>
                    
                
            </div>
        </div>
    </div>

    <?php if (count($interested_properties) > 0) { ?>
        <div class="my-interested-properties">
            <div class="page-container">
                <h1>My Interested Properties</h1>
                <?php foreach ($interested_properties as $property) {
                    $property_images = glob("img/properties/" . $property['id'] . "/*"); ?>
                    <div class="property-card property-id-<?= $property['id'] ?> row">
                        <div class="image-container col-md-4">
                            <img src="<?= $property_images[0] ?>" />
                        </div>
                        <div class="content-container col-md-8">
                            <div class="row no-gutters justify-content-between">
                                <?php
                                $total_rating = round(($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3, 1);
                                ?>
                                <div class="star-container" title="<?= $total_rating ?>">
                                    <?php for ($i = 0; $i < 5; $i++) {
                                        if ($total_rating >= $i + 0.8) echo '<i class="fas fa-star"></i>';
                                        elseif ($total_rating >= $i + 0.3) echo '<i class="fas fa-star-half-alt"></i>';
                                        else echo '<i class="far fa-star"></i>';
                                    } ?>
                                </div>
                                <div class="interested-container">
                                    <i class="is-interested-image fas fa-heart" property_id="<?= $property['id'] ?>"></i>
                                </div>
                            </div>
                            <div class="detail-container">
                                <div class="property-name"><?= $property['name'] ?></div>
                                <div class="property-address"><?= $property['address'] ?></div>
                                <div class="property-gender">
                                    <img src="img/<?= $property['gender'] == 'male' ? 'male.png' : ($property['gender'] == 'female' ? 'female.png' : 'unisex.png') ?>">
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="rent-container col-6">
                                    <div class="rent">₹ <?= number_format($property['rent']) ?>/-</div>
                                    <div class="rent-unit">per month</div>
                                </div>
                                <div class="button-container col-6">
                                    <a href="property_detail.php?property_id=<?= $property['id'] ?>" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php include "includes/footer.php"; ?>

    <script src="js/dashboard.js"></script>
    <script>
        const toggleSwitch = document.getElementById('theme-toggle-switch');
        const themeLabel = document.getElementById('theme-label');

        function applyTheme(theme) {
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
                document.body.classList.remove('light-theme');
                toggleSwitch.classList.add('active');
                themeLabel.textContent = 'Light Mode';
            } else {
                document.body.classList.add('light-theme');
                document.body.classList.remove('dark-theme');
                toggleSwitch.classList.remove('active');
                themeLabel.textContent = 'Dark Mode';
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        toggleSwitch.addEventListener('click', () => {
            const isDark = toggleSwitch.classList.contains('active');
            const newTheme = isDark ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>

</html>
