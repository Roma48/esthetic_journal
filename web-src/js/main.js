(function($){
    //var loading = false;
    //var last_page = false;
    //var page = 2;
    //
    //function loadItems() {
    //    loading = true;
    //    $.ajax({
    //        type: "GET",
    //        url: "/page?page=" + page,
    //        success: function(data) {
    //            if(data.length > 0){
    //                $('tbody').append(data);
    //            } else {
    //                last_page = true;
    //            }
    //        },
    //        error: function(data) {
    //            alert(data)
    //        }
    //    });
    //    loading = false;
    //    page++;
    //}
    //
    //$(window).scroll(function() {
    //    var scrollTop = $(window).scrollTop(),
    //        docHeight = $(document).height(),
    //        winHeight = $(window).height(),
    //        scrollTrigger = 0.80;
    //
    //    if ((scrollTop / (docHeight - winHeight)) > scrollTrigger) {
    //
    //        if (last_page === false && loading === false) {
    //            loadItems();
    //        }
    //    }
    //});

    $('.admin-menu > li > a').click(function(e){
        e.preventDefault();

        $(this).parent().find('.sub-menu').slideToggle();
    });

}(jQuery));