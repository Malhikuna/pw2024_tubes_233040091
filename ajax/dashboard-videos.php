<?php 
require "../functions/functions.php";

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT *, videos.id as videoId FROM courses JOIN videos ON (course_id = courses.id)"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT *, videos.id as videoId 
          FROM courses 
          JOIN videos ON (course_id = courses.id)
          WHERE
          channel_name LIKE '%$keyword%' OR
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
          <th>Realease</th>
          <th>Delete</th>
        </tr>
      </thead>
      
      <tbody>
        <?php foreach($courseVideos as $video) : ?>
          <tr>
            <td><?= $video["channel_name"]; ?></td>
            <td><img src="../img/<?= $video["thumbnail"]; ?>"></td>
            <td><?= $video["video_name"]; ?></td>
            <td>08-02-2024</td>
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

  <div class="pagination">
    <?php if( $halamanAktif > 1 ) : ?>
      <a href="?page=<?= $halamanAktif - 1 ?>">&laquo;</a>
    <?php endif ; ?>

    <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
      <?php if( $i == $halamanAktif ) : ?>
      <div class="active">
        <a href="?page=<?= $i ?>"><?= $i; ?></a>
      </div>
      <?php else : ?>
      <a href="?page=<?= $i ?>"><?= $i; ?></a>
      <?php endif ; ?>
    <?php endfor ; ?>

    <?php if( $halamanAktif < $jumlahHalaman ) : ?>
      <a href="?page=<?= $halamanAktif + 1 ?>">&raquo;</a>
    <?php endif ; ?>
  </div>