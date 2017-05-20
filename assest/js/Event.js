//by chen

$(document).ready(function() {
    var category_event_btn = $('#category_event_btn');
    var input_category = $('#form-category');
    var event_category_panel = $('#event-category-panel');
    var all_event_category = $('#all-event-category');
    var event_category = $('#event-category');
    var display = $('#display-category-description');
    var all_category_titles = $('span.cform');

    $('.click-add').on('click', removeFromAll);
    $('.click-remove').on('click', addToAll);
    category_event_btn.on('click', function (e) {
        event_category_panel.toggleClass('nondisplay');
    })

    function displayDes(e) {
        display.text(e.currentTarget.dataset.des);
    }

    function getAllCategoryId() {
        var eventCategories = $('.click-remove');
        var ids = [];
        $.each(eventCategories, function (key, value) {
            ids.push(value.dataset.id);
        })
        input_category.val(ids.join(","));
    }

    function removeFromAll(e) {
        var element = e.currentTarget;
        $(element).removeClass('click-add').removeClass('label-primary');
        $(element).addClass('label-default').addClass('click-remove');
        $(element).remove();
        event_category.append(element);
        e.currentTarget.removeEventListener('click', removeFromAll);
        displayDes(e);
        e.currentTarget.addEventListener("click", addToAll);
        getAllCategoryId();
    }

    function addToAll(e) {
        var element = e.currentTarget;
        $(element).removeClass('click-remove').removeClass('label-default');
        $(element).addClass('label-primary').addClass('click-add');
        $(element).remove();
        all_event_category.append(element);
        e.currentTarget.removeEventListener('click', addToAll);
        displayDes(e);
        e.currentTarget.addEventListener("click", removeFromAll);
        getAllCategoryId();
    }


});