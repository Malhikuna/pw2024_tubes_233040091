<?php foreach($courses as $course) : ?>
<div class="card">
  <form action="check.php" method="post">
    <input type="hidden" name="category" value="<?= $course["category_name"]; ?>">
    <img src="../img/thumbnail/<?= $course["thumbnail"] ?>" class="card-image">
    <input type="hidden" name="thumbnail" value="<?= $course["thumbnail"]; ?>">
    <p class="category"><?= $course["category_name"] ?></p>

    <div class="like">
      <i class="ri-heart-3-line"></i>
    </div>

    <div class="bottom">
      <div class="left">
        <h3><?= $course["name"] ?></h3>
        <input type="hidden" name="course_name" value="<?= $course["name"]; ?>">
        <div class="channel-content">
          <img class="channel" src="../img/profile/<?= $course["image"]; ?>">
          <p><?= $course["username"] ?></p>
          <input type="hidden" name="channel_name" value="<?= $course["username"]; ?>">
        </div>
      </div>
      <div class="right">
        <input type="hidden" name="courseId" value="<?= $course["courseId"]; ?>">
        <input type="hidden" name="userId" value="<?= $course["userId"]; ?>">
        <button class="check" name="check"></button>
      </div>
    </div>
  </form>
</div>
<?php endforeach ; ?>