function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    var title = 'Delete Record';
    $("#some_name").html(title);
    $("#confirm_msg").html("Are you sure delete all article with group ");
    $("#record_id").val(id);
}

$('#RecordDelete').on('click', function () {
    var id = $("#record_id").val();
    $.ajax({
        url: site_url + "delete-group-article/" + id,
        type: "post",
        data: {id: id, token_id: csrf_token_name},
        beforeSend: function () {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        },
        success: function (data) {
           window.location.href = site_url + "manage-group";
          },error: function (data) {
           window.location.href = site_url + "manage-group";
          }
    });
});


