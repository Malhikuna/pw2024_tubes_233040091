$(document).ready(function () {
  $(".close").on("click", function () {
    $(".course-content").hide();
  });

  $(".form-content-2").hide();

  $(".next").on("click", function () {
    $(".form-content-2").show();
  });

  $(".prev").on("click", function () {
    $(".form-content-2").hide();
  });

  $(".con-red").on("click", function () {
    $(".alert").hide();
  });

  // Dashboard.php

  $(".add").hide();

  $(".col-1").hover(
    function () {
      $(".add-1").show();
    },
    function () {
      $(".add-1").hide();
    }
  );

  $(".col-2").hover(
    function () {
      $(".add-2").show();
    },
    function () {
      $(".add-2").hide();
    }
  );

  $(".col-3").hover(
    function () {
      $(".add-3").show();
    },
    function () {
      $(".add-3").hide();
    }
  );

  $(".back").click(function (e) {
    $(location).attr("href", "dashboard.php");
  });

  $(".add-1").click(function (e) {
    $(location).attr("href", "dashboard-courses.php");
  });

  $(".add-2").click(function (e) {
    $(location).attr("href", "dashboard-videos.php");
  });

  $(".add-3").click(function (e) {
    $(location).attr("href", "dashboard-categories.php");
  });

  $(".add-ctg").hide();

  $("#submit").click(function (e) {
    $(".add-ctg").hide();
  });
});

$(window).scroll(function () {
  $(".next").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
  });

  $(".prev").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
  });
});

// $("#sign-up").on("click", function () {
//   $(".sign-in").class("display", "none");
// });
