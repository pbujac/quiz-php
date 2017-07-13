// // var $addTagLink = $('            {{ form_row(form.questions) }}');
// var myEl = document.getElementById('addQuestionButton');
//
// myEl.addEventListener('click', function() {
//     // document.getElementById("demo").innerHTML = "Hello JavaScript!";
//     // nickname = {{ profile.nickname|json_encode() }}; // Nickname will be a string
//     alert("{{ form.questions|e('js') }}" );
// });
var $collectionHolder;

// setup an "add a tag" link
var $addQuestionLink = $('<a href="#" class="add_question_link">Add question</a>');
var $newLinkLi = $('<li></li>').append($addQuestionLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.questions');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addQuestionLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addQuestionForm($collectionHolder, $newLinkLi);
    });
});
