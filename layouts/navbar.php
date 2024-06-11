<?php 

if(isset($_SESSION["login"])) {
  $userId = $_SESSION["id"];
  $cartResult = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $userId"));

  $cartList = query("SELECT *, cart.user_id as userId FROM cart JOIN courses ON course_id = courses.id WHERE cart.user_id = $userId LIMIT 2");
}

?>

<nav>
  <div class="navbar-brand">
    <a href="./index.php" class="judul">COURSEAREA</a>
  </div>

  <form action="search.php" method="post">
    <div class="search-content">
      <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off">
      <input type="hidden" class="search" name="search" id="tombol-cari"></input>
    </div>
  </form>

  <div class="navbar-list">
    <a href="" class="link ctgs">categories</a>
    <?php if(isset($_SESSION["login"])) : ?>
    <a class="link cart" id="numCart">
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


  <?php if(isset($_SESSION["login"])) : ?>
  <div id="cart-content">
    <div id="cart">
      <div class="cart-list">
        <input type="hidden" id="courseId2" value="<?= $myCourseId; ?>">
        <?php foreach($cartList as $crt) : ?>
        <div class="course-list">
          <img src="../img/thumbnail/<?= $crt["thumbnail"]; ?>" alt="" class="course-img">
          <p><?= $crt["name"]; ?></p>
        </div>
        <?php endforeach ; ?>
      </div>
      <div id="total-price">
        <?php 
        
        $total_price = query("SELECT SUM(price) AS 'Total Price'
        FROM cart JOIN courses ON courses.id = course_id WHERE cart.user_id = $userId ")[0]["Total Price"];

        ?>
        <h3>Total</h3>
        <?php if($total_price === null) : ?>
        <p>Rp0</p>
        <?php else : ?>
        <p>Rp<?= $total_price; ?></p>
        <?php endif ; ?>
      </div>
      <a href="cart.php"><button>See Cart</button></a>
    </div>
  </div>

  <?php 
    
    $userId = $_SESSION["id"];
    $profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

  ?>
  <a href="../pages/profile.php?profile=<?= $_SESSION["username"]; ?>"><img class="profile"
      src="../img/profile/<?= $profilePicture; ?>"></a>

  <div id="menu">
    <div class="menu-content">
      <div class="menu menu-1">
        <a href="../pages/profile.php?profile=<?= $_SESSION["username"]; ?>"><img class="profile-image"
            src="../img/profile/<?= $profilePicture; ?>"></a>
        <div class="username">
          <h4><?= $_SESSION["username"]; ?></h4>
          <p class="email"><?= $_SESSION["email"]; ?></p>
        </div>
      </div>
      <div class="menu menu-2">
        <a href="../pages/course.php"><i class="ri-play-fill"></i> My Courses</a>
        <a href="../pages/my-learning.php"><i class="ri-video-fill"></i> My Learning</a>
        <a href="../pages/playlist.php"><i class="ri-play-list-2-line"></i> Playlist</a>
        <a href="../invoice.php"><i class="ri-bank-card-2-fill"></i> Invoice</a>
      </div>
      <div class="menu menu-3">
        <a href="../pages/edit-profile.php"><i class="ri-user-settings-fill"></i> Edit Profile</a>
        <a href="../pages/setting.php"><i class="ri-settings-fill"></i> Setting</a>
        <a href="../pages/dashboard.php"><i class="ri-dashboard-fill"></i> Dashboard</a>
      </div>
      <div class="menu menu-4">
        <a href="../pages/logout.php"><i class="ri-login-box-fill"></i> Logout</a>
      </div>
    </div>
  </div>
  <?php endif ; ?>
</nav>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/navbar.js"></script>