$(document).ready(function () {
  // Event Ketika Playlist Ditambahkan
  $(".check1").on("change", function () {
    $.get("../ajax/playlist.php?videoId=" + $("#videoId").val() + "&playListId=" + $("#playlistId").val() + "&playlistName=" + $("#playlistName").val() + "&value=" + $(".check1").val(), function (data) {
      $("#list-container").html(data);
    });
  });

  $(".check2").on("change", function () {
    $.get("../ajax/playlist.php?videoId=" + $("#videoId").val() + "&playListId=" + $("#playlistId").val() + "&playlistName=" + $("#playlistName").val() + "&value=" + $(".check2").val(), function (data) {
      $("#list-container").html(data);
    });
  });
});
