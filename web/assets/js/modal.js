$message = "Are you sure you want to delete?";
$title = "Delete action";

$('#confirmDelete').on('show.bs.modal', function (e) {

    $message = $(e.relatedTarget).attr('data-message');
    $(this).find('.modal-body p').text($message);

    $title = $(e.relatedTarget).attr('data-title');
    $(this).find('.modal-title').text($title);

    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
});

$('#confirmDelete').find('.modal-footer #confirm').on('click', function () {
    $(this).data('form').submit();
});
