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

$('.cart_quantity_delete').click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
        url : "/removecart",
        type : "GET",
        data : {
            id : id
        },
        success : function(result) {
            data = JSON.parse(result);
            console.log(typeof data, result);
        }
    });
});