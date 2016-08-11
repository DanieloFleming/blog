/*var Editorium = (function(){
    var Api = {
        slug : {
            type : "GET",
            url : 'cms/post/slug',
        },
        store : {
            type : "POST",
            url : 'cms/post/store'
        }
    };

    var fields = document.querySelectorAll('.editor-field');


    var SlugChecker = (function(){
        var titleField = getField('title');
        var slugField = getField('slug');

        function addEvents() {
            titleField.addEventListener('blur', handleBlur);
            slugField.addEventListener('blur', handleBlur);
        }

        function handleBlur(event) {
            var value = event.currentTarget.value;

            console.log(value);

            if(!isEmpty(value)) {
                var isTitleField = (event.currentTarget == titleField);

                if (isTitleField && isEmpty(!slugField.value)) return

                checkSlug(value, isTitleField);
            }
        }

        function checkSlug(value, removeEvent) {
            var fieldValue = value.trim();
            var slug = createSlug(fieldValue);

            doApiCall(Api.slug, {slug: slug}, setSlug);
        }

        function createSlug(value) {
            return value.toString().toLowerCase().trim()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/&/g, '-and-')         // Replace & with 'and'
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-');        // Replace multiple - with single -
        }

        function setSlug(slug) {
            slugField.value = slug;
        }

        addEvents();
    })();



    function getField (name) {
        for(var i = 0; i < fields.length; i++) {
            if(fields[i].getAttribute('name') == name) return fields[i];
        }
    }

    function isEmpty(value) {
        return (value.trim() == "" || value.trim == null);
    }

    function doApiCall(request, data, callback) {
        $.ajax({
            url : request.url,
            type : request.type,
            data : data,
            success : callback
        })
    }

    /**
     * A. [published]
     *
     * 1. save model to server
     * 2. add id to input-field
     * 3. change publish to update.
     */

    /**
     * A. [draft]
     * 1. save model to server
     * 2. add id to input-field
     * 3. change draft to update-draft
     */

    /**
     *
     *//*
});
$(document).ready(function(){
    if(document.querySelector('.form-editor')) {
        Editorium();
    }
});*/