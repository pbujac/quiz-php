$(function () {
    bindAddQuestionButton();
    bindAddAnswerButton();
});

function bindAddAnswerButton() {
    $('.add-answer-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.question-answer').first();
        // var $collectionHolder = $('.quiz-question');
        // $collectionHolder.data('index', $collectionHolder.find(':input').length);
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;
        var newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.append(newForm);

        $collectionHolder.data('index', index + 1);
    });
}

function bindAddQuestionButton() {
    $('.add-question-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.quiz-question').first();
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;
        var newForm = prototype.replace(/__name__/g, index);

        $collectionHolder.append(newForm);

        $collectionHolder.data('index', index + 1);
    });
}
