$(function () {
    var $collectionHolder = $('#answer-fields-list');

    removeAnswerButton($collectionHolder);
    bindEditAnswerButton($collectionHolder);
});

function bindEditAnswerButton($collectionHolder) {
    $('#add-answer-form').off('click').on('click', function () {

        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        var prototype = $collectionHolder.data('prototype');
        console.log(prototype);
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
