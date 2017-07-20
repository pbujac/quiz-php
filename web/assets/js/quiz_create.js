$(function () {
    bindAddQuestionButton();
    bindAddAnswerButton();
});

function bindAddQuestionButton() {
    $('.add-question-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.quiz-questions').first();
        var prototype = $collectionHolder.data('prototype');
        var questionIndex = $collectionHolder.find(' > .form-group').length + 1;

        var answerPrototype = $(prototype).find('.question-answers').data('prototype');
        prototype = prototype.replace(/__name__label__/g, 'Question #' + questionIndex);
        prototype = prototype.replace(/__name__/g, questionIndex);
        var $prototype = $(prototype);
        $prototype.find('.question-answers').data('prototype', answerPrototype);

        $collectionHolder.append($prototype);
        bindAddAnswerButton();
    });
}

function bindAddAnswerButton() {
    $('.add-answer-button').off('click').on('click', function () {
        var $collectionHolder = $(this).siblings('.question-answers').first();
        var prototype = $collectionHolder.data('prototype');
        var answerIndex = $collectionHolder.find(' > .form-group').length + 1;
        var questionIndex = $(this).closest('[id^="quiz_questions_"]').data('name');

        prototype = prototype.replace(/__name___answers___name__/g, questionIndex + '_answers_' + answerIndex);
        prototype = prototype.replace(/\[__name__]\[answers]\[__name__]/g, '[' + questionIndex + '][answers][' + answerIndex + ']');
        prototype = prototype.replace(/__name__/g, answerIndex);

        $collectionHolder.append(prototype);
    });
}
