<?php 
require "../functions/functions.php";
$keyword = $_GET["keyword"];

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM courses"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$query = "SELECT *, 
          courses.id as courseId,
          users.id as userId,
          courses.date AS course_date 
          FROM courses 
          JOIN categories ON (courses.category_id = categories.id) 
          JOIN users ON (courses.user_id = users.id)
          WHERE
          username LIKE '%$keyword%' OR
          name LIKE '%$keyword%'
          ORDER BY courses.id DESC 
          LIMIT 5
";
$courses= query($query);

?>

<table>
  <thead>
    <tr>
      <th>Channnel</th>
      <th>Course</th>
      <th>Name</th>
      <th>Date</th>
      <th>Delete</th>
    </tr>
  </thead>

  <tbody>
    <?php 
    foreach($courses as $course) : 
      $dateTimestamp = $course["course_date"];
      $timestamp = strtotime($dateTimestamp);
      $date = date('d-m-y', $timestamp);
    ?>
    <tr>
      <td><?= $course["username"]; ?></td>
      <td><img src="../img/thumbnail/<?= $course["thumbnail"]; ?>"></td>
      <td><?= $course["name"]; ?></td>
      <td>08-02-2024</td>
      <td>
        <form action="delete-course.php" method="post">
          <input type="hidden" name="id" value="<?= $course["courseId"]; ?>">
          <button class="delete">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach ; ?>
  </tbody>
</table>

<?php require "../layouts/pagination.php" ?>