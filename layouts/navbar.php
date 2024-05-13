<nav>
  <div class="navbar-brand">
    <a href="#" class="judul"
      >UP YOUR SKIL</a
    >
  </div>

  <div class="search-content">
    <form action="index.php" method="post">
      <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
      <input type="hidden" class="search" name="search" id="tombol-cari"></input>
    </form>
  </div>

  <div class="navbar-list">
    <ul>
      <li><a href="./index.php" class="link">home</a></li>
      <li><a href="./course.php" class="link">course</a></li>
      <li><a href="./playlist.php" class="link">playlist</a></li>
      <li><a href="./liked.php" class="link">liked</a></li>
      <?php if(!isset($_SESSION["login"])) : ?>
        <li><a href="./login.php" class="link">Login</a></li>
      <?php else : ?>
        <li><a href="./upload.php" class="link">upload</a></li>
      <?php endif ; ?>
    </ul>
  </div>

  <div class="menu">
    <input type="checkbox" />
    <img src="img/icons/menu_icon.png" class="menu-icon" height="15px" width="15px" />
  </div>
</nav>