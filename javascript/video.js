$(document).ready(function () {
  $(".add").hide();
  $(".close-click").hide();

  $("#add").click(function (e) {
    $(".add").show();
    $(".close-click").show();
    $("#add-list").show();
    $(".alert").show();
  });

  $("#close").click(function (e) {
    $(".close-click").hide();
    $(".add").hide();
    $("#new").hide();
  });

  $(".close-click").click(function (e) {
    $(".close-click").hide();
    $(".add").hide();
    $("#new").hide();
  });

  $("#liked").click(function (e) {
    $.post($("#form-like").attr("action"), $("#form-like : input").serializeArray(), function (info) {});

    $("#form-like").submit(function () {
      return false;
    });
  });

  $("#new").hide();

  $("#add-list").click(function (e) {
    $("#new").show();
    $("#add-list").hide();
  });

  $(".check1").change(function (e) {
    $(".alert").show();
  });

  $(".check2").change(function (e) {
    $(".alert").show();
  });

  $(".continue").click(function (e) {
    $(".alert").hide();
  });
});
