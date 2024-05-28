<?php 

if(isset($_SESSION["login"])) {
  $userId = $_SESSION["id"];
  $cartResult = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $userId"));

  $cartList = query("SELECT *, cart.user_id as userId FROM cart JOIN courses ON course_id = courses.id WHERE cart.user_id = $userId LIMIT 3");
}

?>

<nav>
  <div class="navbar-brand">
    <a href="./index.php" class="judul">UPSKIL</a>
  </div>

  <form action="search.php" method="post">
    <div class="search-content">
      <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
      <input type="hidden" class="search" name="search" id="tombol-cari"></input>
    </div>
  </form>

  <div class="navbar-list">
    <a href="" class="link ctgs">categories</a>
    <?php if(isset($_SESSION["login"])) : ?>
    <a class="link cart">
      <i class="ri-shopping-cart-2-line"></i>
      <?php if($cartResult > 0) : ?>
      <?php if($cartResult > 9) : ?>
      <div class="number">
        <p>9+</p>
      </div>
      <?php endif ; ?>
      <div class="number">
        <p><?= $cartResult; ?></p>
      </div>
      <?php endif ; ?>
    </a>
    <a href="likes.php" class="link">liked</a>
    <?php endif ; ?>
    <?php if(!isset($_SESSION["login"])) : ?>
    <div class="login-button">
      <a href="./login.php" class="link login"><button>Sign In</button></a>
      <a href="./login.php" class="link login"><button>Sign Up</button></a>
    </div>

    <?php else : ?>
    <a href="./upload.php" class="link">upload</a>
    <?php endif ; ?>
  </div>

  <?php $ctgs = query("SELECT * FROM categories"); ?>
  <div id="category-menu-content">
    <div class="category-menu">
      <?php foreach($ctgs as $ctg) : ?>
      <a href="category.php?category=<?= $ctg["category_name"]; ?>"><?= $ctg["category_name"]; ?></a>
      <?php endforeach ; ?>
    </div>
  </div>

  <div id="cart-content">
    <div id="cart">
      <div class="cart-list">
        <?php foreach($cartList as $crt) : ?>
        <div class="course-list">
          <img src="../img/thumbnail/<?= $crt["thumbnail"]; ?>" alt="" width="20px">
          <p><?= $crt["name"]; ?></p>
        </div>
        <?php endforeach ; ?>
      </div>
      <a href="cart.php"><button>See Cart</button></a>
    </div>
  </div>

  <?php if(isset($_SESSION["login"])) : ?>
  <?php 
    
    $userId = $_SESSION["id"];
    $profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

  ?>
  <a href="../pages/profile.php?profile=<?= $_SESSION["username"]; ?>"><img class="profile"
      src="../img/profile/<?= $profilePicture; ?>"></a>

  <div class="profile-menu">
    <a href="../pages/edit-profile.php">Edit Profile</a>
    <a href="../pages/course.php">My Courses</a>
    <a href="../pages/my-learning.php">My Learning</a>
    <a href="../pages/playlist.php">Playlist</a>
    <a href="../pages/setting.php">Setting</a>
    <a href="../pages/dashboard.php">Dashboard</a>
    <a href="../pages/logout.php">Logout</a>
  </div>
  <?php endif ; ?>
</nav>

<script src="../javascript/jquery.js"></script>
<script>
$(document).ready(function() {
  // $(".profile-menu").hide();
  $(".profile-menu").hide();


  $(".profile").mouseover(function() {
    $(".profile-menu").show();
  });

  $(".navbar-list").mouseout(function() {
    $(".profile-menu").hide();
    $("#category-menu-content").hide();
    $("#cart-content").hide();
  });

  $(".profile-menu").mouseover(function() {
    $(".profile-menu").show();
  });

  $(".profile-menu").mouseout(function() {
    $(".profile-menu").hide();
  });

  $("#category-menu-content").hide();

  $(".ctgs").mouseover(function() {
    $("#category-menu-content").show();
  });

  $("#category-menu-content").mouseover(function() {
    $("#category-menu-content").show();
  });

  $("#category-menu-content").mouseout(function() {
    $("#category-menu-content").hide();
  });

  $("#cart-content").hide();

  $(".cart").mouseover(function() {
    $("#cart-content").show();
  });

  $("#cart-content").mouseover(function() {
    $("#cart-content").show();
  });

  $("#cart-content").mouseout(function() {
    $("#cart-content").hide();
  });
})
</script>