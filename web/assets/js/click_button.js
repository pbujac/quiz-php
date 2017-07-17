$(function () {
    bindAddQuestionButton();
    bindAddAnswerButton();
});

function bindAddQuestionButton() {
    $('.add-question-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.quiz-question').first();
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;
        var questionForm = prototype.replace(/__name__label__/, '');

        $collectionHolder.append(questionForm);
        $collectionHolder.data('index', index + 1);
        bindAddAnswerButton();
    });
}

function bindAddAnswerButton() {
    $('.add-answer-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.question-answer').first();
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;
        var answerForm = prototype.replace(/__name__label__/, '');

        $collectionHolder.append(answerForm);
        $collectionHolder.data('index', index + 1);
    });
}
