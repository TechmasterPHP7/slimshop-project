$(document).ready(function(){
    $.ajax({
        type: 'post',
        url: '/product',
        data:{
            total_call_items:"totalitems"
        },
        success:function(response) {
            document.getElementById("total_items").value=response;
        }
    });
});

function cart(id) {
    var ele=document.getElementById(id);
    var img_src=ele.getElementsByTagName("img")[0].src;
    var name=document.getElementById(id+"_name").value;
    var price=document.getElementById(id+"_price").value;

    $ajax({
        type: 'post',
        url: 'cart.html',
        data: {
            item_src: img_src,
            item_name: name,
            item_price: price
        },
        success:function(response) {
            document.getElementById("total_items").value=response;
        }
    });
}

function show_cart() {
    $.ajax({
        type:'post',
        url:'cart.html',
        data:{
            showcart:"cart"
        },
        success:function(response) {
            document.getElementById("mycart").innerHTML=response;
            $("#mycart").slideToggle();
        }
    });
}