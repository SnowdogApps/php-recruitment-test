
$('.varnish-website-relation').on('change', function (e) {
    var status = $(this).is(':checked') ? 1 : 0;
    var varnishId = $(this).data('varnish_id');
    var websiteId = $(this).data('website_id');
    var requestData = {
        'status'        : status,
        'varnish_id'    : varnishId,
        'website_id'    : websiteId
    };

    $.post('/varnish-link', requestData, function(res){
        res = $.parseJSON(res);
        if(res.status)
            toastr.success(res.message);
        else
            toastr.error(res.message);
    });

});