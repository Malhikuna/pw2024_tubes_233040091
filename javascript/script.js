$(document).ready(function () {
  // $(".course-content").hide();

  //  $(".card").on("click", function () {
  //   $(".course-content").show();
  // });

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

  // $("#sign-up").on("click", function () {
  //   $(".sign-in").class("display", "none");
  // });
});

$(window).scroll(function () {
  $(".next").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
  });

  $(".prev").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
  });
});
