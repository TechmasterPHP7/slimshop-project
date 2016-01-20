$(document).ready(function add_cart(id) {
    $.ajax({
        type: 'POST',
        url: window.location.pathname
    }).success(function(){

    });
};

$(document).ready(function () {
    $(".productinfo div img").on("click", function () {
        window.location.href = '/products/' + this.slug;
    });
    $('.overlay-content img').on("click", function () {
        window.location.href = '/products/' + this.slug;
    });
    $('.overlay-content p').on("click", function () {
        window.location.href = '/products/' + this.slug;
    });
});