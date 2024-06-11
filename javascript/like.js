$(document).ready(function () {
  // Event ketika likeBUtton di tekan
  $("#likeButton").on("click", function () {
    // $.get()
    $.get("../ajax/video.php?userId=" + $("#userLikeId").val() + "&videoId=" + $("#videoLikeId").val(), function (data) {
      $("#container").html(data);
    });
  });
  
  $("#unLikeButton").on("click", function () {
    // $.get()
    $.get("../ajax/video.php?userId=" + $("#userLikeId").val() + "&videoId=" + $("#videoLikeId").val(), function (data) {
      $("#container").html(data);
    });
  });
});
