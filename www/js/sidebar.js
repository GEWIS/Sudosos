$(function () {
    //Enable sidebar toggle
    $("#toggle-sidebar-button").click(function (e) {
        e.preventDefault();
        //Enable sidebar push menu
        const body = $("body");
        if(!body.hasClass('sidebar-collapse') && !body.hasClass('sidebar-open')){
            body.addClass('sidebar-collapse');
            body.addClass('sidebar-mini');
        } else {
            if(body.hasClass('sidebar-open')){
                body.removeClass('sidebar-open');
                body.addClass('sidebar-mini');
                body.addClass('sidebar-collapse');
            }
            else {
                body.removeClass('sidebar-mini');
                body.removeClass('sidebar-collapse');
                body.addClass('sidebar-open');
            }
        }
    });
});