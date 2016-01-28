$('.add-to-cart').click(function() {
    var id = $(this).attr('data-id');

    $.ajax({
        url : "/addcart",
        type : "POST",
        data : {
            id : id
        },
        success : function(result) {
            data = JSON.parse(result);
            console.log(typeof data, result);
        }
    });
});

//$(document).ready(function delete_cart(id) {
//    $.ajax({
//        url : "/cart",
//        type : "post",
//        success : function() {
//            $.removeCookie('id');
//        }
//    });
//});