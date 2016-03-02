$(document).ready(function() {

    $(".tab-pane:not(.active)").hide();

    $(".nav-links a").click(function(e) {

        $(".nav-links li").removeClass("active");
        $(this).parent().addClass("active");
        $(".tab-pane").hide();
        $(".tab-pane" + $(this).attr("href")).show();

        e.preventDefault();

    });

});