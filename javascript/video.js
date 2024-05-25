$(document).ready(function () {
  $(".add").hide();

  $("#add").click(function (e) {
    $(".add").show();
  });

  $("#close").click(function (e) {
    $(".add").hide();
  });

  $("#liked").click(function (e) {
    $.post($("#form-like").attr("action"), $("#form-like : input").serializeArray(), function (info) {});

    $("#form-like").submit(function () {
      return false;
    });
  });
});
