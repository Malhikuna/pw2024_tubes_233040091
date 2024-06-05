<?php 

$adminId = $_SESSION["id"];
$email = $_SESSION["email"];
$imageProfile = query("SELECT image FROM profile WHERE user_id = $adminId")[0]["image"];

?>

<div class="left">
  <div class="profile-box">
    <img src="../img/profile/<?= $imageProfile; ?>" alt="">
    <h4><?= $username; ?></h4>
    <p><?= $email; ?></p>
    <div class="role"><?= $role; ?></div>
  </div>
  <div class="menu-box">
    <p>Menu</p>
    <a href="../pages/dashboard.php"><i class="ri-home-6-fill"></i> Home</a>
    <a href="../pages/dashboard-courses.php"><i class="ri-slideshow-3-fill"></i> Manage Courses</a>
    <a href="../pages/dashboard-videos.php"><i class="ri-video-fill"></i> Manage Videos</a>
    <a href="../pages/dashboard-categories.php"><i class="ri-stack-fill"></i> Manage Categories</a>
    <a href="../pages/manage-accounts.php"><i class="ri-account-box-fill"></i> Manage Users</a>
    <a href="../pages/payment-history.php"><i class="ri-bank-card-2-fill"></i> Payment History</a>
  </div>
</div>