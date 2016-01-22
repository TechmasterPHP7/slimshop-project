$(document).ready(function add_cart(id) {
    $.ajax({
        url : "/addcart",
        type : "POST",
        data : {
          id : id
        },
        success : function(data) {
            data = JSON.parse(data);
            console.log(typeof data, data);
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