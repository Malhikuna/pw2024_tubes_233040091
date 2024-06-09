$(document).ready(function () {
  let offset = 320;
  let duration = 500;

  $(window).scroll(function () {
    if ($(this).scrollTop() > offset) {
      $(".categories-line").fadeOut(duration);
      // $(".categories-line").show();
    } else {
      $(".categories-line").fadeIn(duration);
    }
  });

  $("#keyword").on("keyup", function () {
    // $.get()
    $.get("../ajax/search.php?keyword=" + $("#keyword").val(), function (data) {
      $("#container").html(data);
    });
  });
});
