$(document).ready(function () {
  $(".alert").hide();

  $(".delete").click(function () {
    $(".alert").show();
  });

  $(".no").click(function () {
    $(".alert").hide();
  });

  // Dashboard / Videos
  $(".add-ctg").hide();

  $("#add").click(function () {
    $(".alert").show();
    $(".add-ctg").show();
  });
});
