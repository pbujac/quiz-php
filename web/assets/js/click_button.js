$(function () {
    bindAddQuestionButton();
    bindAddAnswerButton();
});

function bindAddQuestionButton() {
    $('.add-question-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.quiz-questions').first();
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;

        var answerPrototype = $(prototype).find('.question-answers').data('prototype');
        prototype = prototype.replace(/__name__label__/g, 'Question #' + index);
        prototype = prototype.replace(/__name__/g, index);
        var $prototype = $(prototype);
        $prototype.find('.question-answers').data('prototype', answerPrototype);

        $collectionHolder.append($prototype);
        $collectionHolder.data('index', index + 1);
        bindAddAnswerButton();
    });
}

function bindAddAnswerButton() {
    $('.add-answer-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.question-answers').first();
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index') ? $collectionHolder.data('index') : 1;

        prototype = prototype.replace(/__name__label__/g, 'Answer #' + index);
        prototype = prototype.replace(/__name__/g, index);

        $collectionHolder.append(prototype);
        $collectionHolder.data('index', index + 1);
    });
}
