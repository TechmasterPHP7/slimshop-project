$('input.searchForm').searchForm(function() {
    var id = $(this).attr('data-id');

    $.ajax({
        url : "/searchNameProduct",
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