$(document).ready(function () {
  $("#sign-up").click(function (e) {
    $(".right-content").addClass("slide1");
    $(".sign-in-left").addClass("slide1");
    $(".sign-in-open").addClass("slide1");
    $(".sign-up-input").addClass("slide1");
    $(".sign-up").addClass("slide1");
    $(".left-content").addClass("slide1");

    $(".right-content").removeClass("slide2");
    $(".sign-in-left").removeClass("slide2");
    $(".sign-in-open").removeClass("slide2");
    $(".sign-up-input").removeClass("slide2");
    $(".sign-up").removeClass("slide2");
    $(".left-content").removeClass("slide2");
  });

  $("#sign-in").click(function (e) {
    $(".right-content").addClass("slide2");
    $(".sign-in-left").addClass("slide2");
    $(".sign-in-open").addClass("slide2");
    $(".sign-up-input").addClass("slide2");
    $(".sign-up").addClass("slide2");
    $(".left-content").addClass("slide2");

    $(".right-content").removeClass("slide1");
    $(".sign-in-left").removeClass("slide1");
    $(".sign-in-open").removeClass("slide1");
    $(".sign-up-input").removeClass("slide1");
    $(".sign-up").removeClass("slide1");
    $(".left-content").removeClass("slide1");
  });
});
