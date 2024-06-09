$(document).ready(function () {
  $("#follow").on("click", function () {
    // $.get()
    $.get("../ajax/follow.php?id=" + $("#userId").val(), function (data) {
      $("#followButton").html(data);
    });
    $.get("../ajax/follow2.php?id=" + $("#userId").val(), function (data) {
      $("#followers").html(data);
    });
  });
  $("#unFollow").on("click", function () {
    // $.get()
    $.get("../ajax/follow.php?id=" + $("#userId").val(), function (data) {
      $("#followButton").html(data);
    });
    $.get("../ajax/follow2.php?id=" + $("#userId").val(), function (data) {
      $("#followers").html(data);
    });
  });
});
