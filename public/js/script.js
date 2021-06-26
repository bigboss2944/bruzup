$(document).foundation();

$(function() {
    $('.search')
        .bind('click', function(event) {
            $(".search-field").toggleClass("expand-search");

            // if the search field is expanded, focus on it
            if ($(".search-field").hasClass("expand-search")) {
                $(".search-field").focus();
            }
        })
});


function galleryPhoto(){
    console.log('sim-thumb')
    $('.sim-thumb').on('click', function() {
        $('#main-product-image').attr('src', $(this).data('image'));
    })
}
