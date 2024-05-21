<?php 
require "../functions/functions.php";
$keyword = $_GET["keyword"];
$query = "SELECT *, courses.id as courseId
          FROM courses 
          JOIN catagories ON (catagory_id = catagories.id)
          WHERE
          channel_name LIKE '%$keyword%' OR
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
            <th>Realease</th>
            <th>Delete</th>
          </tr>
        </thead>
        
        <tbody>
          <?php foreach($courses as $course) : ?>
            <tr>
              <td><?= $course["channel_name"]; ?></td>
              <td><img src="../img/<?= $course["thumbnail"]; ?>"></td>
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