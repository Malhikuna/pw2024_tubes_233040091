<?php 

session_start();
require "../functions/functions.php";

$keyword = $_GET["keyword"];

// Pagination
$jumlahDataPerHalaman = 9;
$jumlahData = count(query("SELECT * FROM courses"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN categories ON (courses.category_id = categories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE 
                  name LIKE '%$keyword%' OR 
                  username LIKE '%$keyword%'
                  ORDER BY courses.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

// Ambil semua data dari tabel kategori
$categories = query("SELECT * FROM categories");
$ctgss = query("SELECT * FROM categories LIMIT 6");

// Sorting
if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN categories ON (courses.category_id = categories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE 
                      name LIKE '%$keyword%' OR 
                      username LIKE '%$keyword%'
                      ORDER BY courses.id ASC 
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }

  if($_POST["sort"] === "new") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN categories ON (courses.category_id = categories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE 
                      name LIKE '%$keyword%' OR 
                      username LIKE '%$keyword%'
                      ORDER BY courses.id DESC 
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }
}

?>

<?php 

require "../layouts/cards.php";

?>