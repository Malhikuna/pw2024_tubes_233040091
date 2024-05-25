<nav>
  <div class="navbar-brand">
    <a href="./index.php" class="judul"
      >UPSKIL</a
    >
  </div>

  <form action="search.php" method="post">
    <div class="search-content">
      <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
      <input type="hidden" class="search" name="search" id="tombol-cari"></input>
    </div>
  </form>

  <div class="navbar-list">
    <a href="" class="link ctgs">catagories</a>
    <a href="playlist.php" class="link">playlist</a>
    <a href="likes.php" class="link">liked</a>
    <?php if(!isset($_SESSION["login"])) : ?>
      
    <div class="login-button">
      <a href="./login.php" class="link login">Login</a>
    </div>
      
    <?php else : ?>
      <a href="./upload.php" class="link">upload</a>
    <?php endif ; ?>
  </div>

  <?php $ctgs = query("SELECT * FROM catagories"); ?>
  <div class="catagory-menu">
    <?php foreach($ctgs as $ctg) : ?>
    <a href="catagory.php?catagory=<?= $ctg["catagory_name"]; ?>"><?= $ctg["catagory_name"]; ?></a>
    <?php endforeach ; ?>
  </div>

  <?php if(isset($_SESSION["login"])) : ?>
  <?php 
    
    $userId = $_SESSION["id"];
    $profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

  ?>
  <a href="../pages/profile.php?profile=<?= $_SESSION["username"]; ?>"><img class="profile" src="../img/profile/<?= $profilePicture; ?>"></a>
  
  <div class="profile-menu">
    <a href="../pages/edit-profile.php">Edit Profile</a>
    <a href="../pages/course.php">My Courses</a>
    <a href="../pages/dashboard.php">Playlist</a>
    <a href="../pages/dashboard.php">Setting</a>
    <a href="../pages/dashboard.php">Dashboard</a>
    <a href="../pages/logout.php">Logout</a>
  </div>
  <?php endif ; ?>
</nav>

<script src="../javascript/jquery.js"></script>
<script>
  $(document).ready(function () {
    // $(".profile-menu").hide();
    $(".profile-menu").hide();


    $(".profile").mouseover(function () {
        $(".profile-menu").show();
      }
    );

    $(".navbar-list").mouseout(function () {
        $(".profile-menu").hide();
        $(".catagory-menu").hide();

      }
    );
    
    $(".profile-menu").mouseover(function () { 
      $(".profile-menu").show();
    });

    $(".profile-menu").mouseout(function () { 
      $(".profile-menu").hide();
    });

    $(".catagory-menu").hide();

    $(".ctgs").mouseover(function () {
        $(".catagory-menu").show();
      }
    );
    
    $(".catagory-menu").mouseover(function () { 
      $(".catagory-menu").show();
    });

    $(".catagory-menu").mouseout(function () { 
      $(".catagory-menu").hide();
    });
  })
</script>