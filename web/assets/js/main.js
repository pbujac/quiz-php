$(document).ready(function () {

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


    $(function () {

        var $collectionHolder = $('#answer-fields-list');
        removeAnswerButton($collectionHolder);
        bindAddAnswerButton($collectionHolder);


    });

    function bindAddAnswerButton($collectionHolder) {
        $('#add-answer-form').off('click').on('click', function () {

            $collectionHolder.data('index', $collectionHolder.find(':input').length);

            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;
            var newForm = prototype.replace(/__name__/g, index);

            $collectionHolder.append('<li class="answer-row">' + newForm + '</li>');
            $collectionHolder.data('index', index + 1);
        });
    }

    function removeAnswerButton($collectionHolder) {
        $collectionHolder.on('click', '.remove-answer', function () {
            $(this).closest('li').remove();
        });
    }
});
