$(document).ready(function () {
  $("#menu").hide();

  $(".profile").mouseover(function () {
    $("#menu").show();
  });

  $(".navbar-list").mouseout(function () {
    $("#menu").hide();
    $("#category-menu-content").hide();
    $("#cart-content").hide();
  });

  $("#menu").mouseover(function () {
    $("#menu").show();
  });

  $("#menu").mouseout(function () {
    $("#menu").hide();
  });

  $("#category-menu-content").hide();

  $(".ctgs").mouseover(function () {
    $("#category-menu-content").show();
  });

  $("#category-menu-content").mouseover(function () {
    $("#category-menu-content").show();
  });

  $("#category-menu-content").mouseout(function () {
    $("#category-menu-content").hide();
  });

  $("#cart-content").hide();

  $(".cart").mouseover(function () {
    $("#cart-content").show();
  });

  $("#cart-content").mouseover(function () {
    $("#cart-content").show();
  });

  $("#cart-content").mouseout(function () {
    $("#cart-content").hide();
  });
});
