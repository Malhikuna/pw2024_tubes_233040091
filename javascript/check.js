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

  // $("#add").click(function () {
  //   $(".alert").show();
  //   $(".add-ctg").show();
  // });

  $("#add").on("click", function () {
    // $.get()
    $.get("../ajax/checkout.php?courseId=" + $("#courseId").val(), function (data) {
      $("#container").html(data);
    });
    $.get("../ajax/numCart.php", function (data) {
      $("#numCart").html(data);
    });
    $.get("../ajax/cartList.php", function (data) {
      $("#cart").html(data);
    });
  });
});
