$(document).ready(function () {
  // $(".course-content").hide();

  $(".card").on("click", function () {
    $(".course-content").show();
  });

  $(".close").on("click", function () {
    $(".course-content").hide();
  });
});
