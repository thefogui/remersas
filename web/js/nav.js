$(document).ready(function() {
    $(".content").css("display", "none");
    $("nav").css('width', "auto");

    $(".hamburguer-bt").click(function() {
        if ($(this).hasClass("on")) {
            $(this).removeClass("on");
            $(".content").css("display", "none");
            $("nav").css('width', "auto");
        } else {
            $(this).toggleClass("on");
            $(".content").css("display", "block");
            $("nav").css('width', "200px");
        }
    });

    $('.content a').on("click", function(e){
        // Prevent link being followed (you can use return false instead)
        e.preventDefault();

        if ($(this).attr('id') === "home-link") {
            $('#table').css("display", "none");
            $('#form').css("display", "none");
            $('#accounts').css("display", "none");
            $('#home').delay(2500).show();
        } else if ($(this).attr('id') === "billing-link") {
            $('#home').css("display", "none");
            $('#form').css("display", "none");
            $('#accounts').css("display", "none");
            $('#table').delay(2500).show();
        } else if ($(this).attr('id') === "remesas-link") {
            $('#table').css("display", "none");
            $('#home').css("display", "none");
            $('#accounts').css("display", "none");
            $('#form').delay(2500).show();
        } else if ($(this).attr('id') === "accounts-link") {
            $('#table').css("display", "none");
            $('#form').css("display", "none");
            $('#home').css("display", "none");
            $('#accounts').delay(2500).show();
        }
    });
});