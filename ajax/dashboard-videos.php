<?php 
require "../functions/functions.php";
$keyword = $_GET["keyword"];
$query = "SELECT *, videos.id as videoId 
          FROM courses 
          JOIN videos ON (course_id = courses.id)
          WHERE
          channel_name LIKE '%$keyword%' OR
          video_name LIKE '%$keyword%'
          ORDER BY videos.id DESC 
          LIMIT 5
";
$courseVideos = query($query);

?>

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