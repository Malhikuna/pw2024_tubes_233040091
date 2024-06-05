<?php 

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT *, videos.id as videoId FROM courses JOIN videos ON (course_id = courses.id)"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT *, 
          videos.id as videoId,
          videos.date AS video_date 
          FROM courses 
          JOIN videos ON (course_id = courses.id)
          JOIN users ON (courses.user_id = users.id)
          WHERE
          username LIKE '%$keyword%' OR
          video_name LIKE '%$keyword%'
          ORDER BY videos.id DESC 
          LIMIT $dataAwal, $jumlahDataPerHalaman
";
$courseVideos = query($query);

?>

<div class="top">
</div>
<div class="bottom">
  <table>
    <thead>
      <tr>
        <th>Channnel</th>
        <th>Videos</th>
        <th>Title</th>
        <th>Date</th>
        <th>Delete</th>
      </tr>
    </thead>

    <tbody>
      <?php 
      foreach($courseVideos as $video) : 
        $dateTimestamp = $video["video_date"];
        $timestamp = strtotime($dateTimestamp);
        $date = date('d-m-y', $timestamp);
      ?>
      <tr>
        <td><?= $video["username"]; ?></td>
        <td><img src="../img/thumbnail/<?= $video["thumbnail"]; ?>"></td>
        <td><?= $video["video_name"]; ?></td>
        <td><?= $date; ?></td>
        <td>
          <form action="delete-video.php" method="post">
            <input type="hidden" name="id" value="<?= $video["videoId"]; ?>">
            <button class="delete">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ; ?>
    </tbody>
  </table>
</div>

<?php require "../layouts/pagination.php" ?>