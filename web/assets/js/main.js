$(document).ready(function () {

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
        bindAddAnswerButton();
    });

    function bindAddAnswerButton() {
        $('.add-answer-button').off('click').on('click', function () {

            var $collectionHolder = $('.quiz-question');

            $collectionHolder.data('index', $collectionHolder.find(':input').length);

            var prototype = $collectionHolder.data('prototype');

            var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;

            console.log(index);
            var newForm = prototype.replace(/__name__/g, index);
            //
            $collectionHolder.append(newForm);
            //
            $collectionHolder.data('index', index + 1);
        });
    }

});
