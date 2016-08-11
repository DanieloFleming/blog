@extends('cms.layouts.main')
@section('content')

    <ul class="list-horizontal action-list">
        <li><a href="#" class="action-link action-publish" data-action="published">publish</a> </li>
        <li><a href="#" class="action-link action-draft" data-action="draft">draft</a> </li>
        <?php $showDelete = ($data->id) ? 'inline-block' : 'none';?>
            <li style="display:{{$showDelete}}"><a href="/cms/post/delete/{{$data->id}}" class="action-delete" data-action="delete">trash</a> </li>

    </ul>
    <div class="container" style="margin-top: 40px">
        <form class="form-editor" method="post" action="/cms/post/store/">
            <input type="hidden" name="_token" class="editor-field field-token" value="{{csrf_token() }}" />
            <input type="hidden" name="id" value="{{$data->id}}" class="editor-field field-id"/>
            <input type="hidden" name="type" value="{{$data->type}}" class="editor-field field-type"/>
            <input type="text" name="title" value="{{$data->title}}" placeholder="Enter a title here..." class="editor-field field-title"/>

            <input type="text" name="slug" value="{{$data->slug}}" placeholder="slug-is-auto-generated..."class="editor-field field-slug"/>

            <input type="datetime" name="published_at" value="{{$data->published_at}}" placeholder="open datepicker..."class="editor-field field-published"/>

            <textarea id="ss" class="editor-field field-content" name="content" placeholder="Share a new story with the world..." autofocus>{{$data->content}}</textarea>
        </form>
    </div>

    <script>

        var Editorium = (function() {
            var Api = {
                slug: {
                    type: "GET",
                    url: '/cms/post/slug',
                },
                store: {
                    type: "POST",
                    url: '/cms/post/store'
                }
            };

            var SlugChecker = (function () {
                var titleField = $('.field-title')[0];
                var slugField = $('.field-slug')[0];

                function _addEvents() {
                    titleField.addEventListener('blur', _handleBlur);
                    slugField.addEventListener('blur', _handleBlur);
                }

                function _handleBlur(event) {
                    var value = event.currentTarget.value;

                    if (!isEmpty(value)) {
                        var isTitleField = (event.currentTarget == titleField);

                        if (isTitleField && !isEmpty(slugField.value)) return;

                        _checkSlug(value);
                    }
                }

                function _checkSlug(value) {
                    var slug = _createSlug(value);

                    doApiCall(Api.slug, {slug: slug}, _setSlug);
                }

                function _createSlug(value) {
                    return value.toString().toLowerCase().trim()
                            .replace(/\s+/g, '-')           // Replace spaces with -
                            .replace(/&/g, '-and-')         // Replace & with 'and'
                            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                            .replace(/\-\-+/g, '-');        // Replace multiple - with single -
                }

                function _setSlug(slug) {
                    slugField.value = slug;
                }

                _addEvents();
            })();

            var DatePicker = new Pikaday({
                field: document.querySelector('.field-published'),
                format: 'MMMM Do, YYYY',
                firstDay : 1,
            });

            var TextEditor = (function(){
                Simditor.locale = 'en-US';

                var editor = new Simditor({
                    textarea: $('#ss'),
                    toolbar: ['title', '|', 'bold', 'italic', 'underline',
                        'strikethrough', '|', 'fontScale', 'color', 'alignment', '|','ol',
                        'ul', 'blockquote',  'code', 'table', 'link',
                        'image', 'hr', 'indent', 'outdent', 'html' ,
                    ],
                    toolbarFloatOffset: 99
                });
            })();

            var StoreActions = (function(){
                var actionLinks = {};
                var idField = document.querySelector('[name=id]');

                var _addEvents = function _addEvents() {
                    document.querySelectorAll('.action-link').forEach(function(element) {
                        var actionType = element.dataset.action;
                            actionLinks[actionType] = element;

                        element.addEventListener('click', _handleClick);
                    });
                };

                var _handleClick = function _handleClick(event) {
                    event.preventDefault();

                    var actionType = event.currentTarget.dataset.action;

                    var data = _getFormData(actionType);

                    doApiCall(Api.store, data, _handleSuccess);
                };

                var _getFormData = function(postType) {
                    var data = {};

                    $('.form-editor').serializeArray().forEach( function(obj){
                        data[obj.name] = obj.value;
                    });

                    data['type'] = postType;
                    data['published_at'] = _getDateValue();

                    return data;
                };

                var _getDateValue = function() {
                    var d = new Date();
                    var time = moment(d.getHours() + ':' + d.getMinutes(), "h:m").format('hh:mm:ss');
                    var date = DatePicker.getMoment().format('YYYY-MM-DD');

                    return date + " " + time;
                };

                function _handleSuccess(model) {
                    if(idField.value.toString().trim() == "") {
                        if(model.type == 'draft') {
                            actionLinks['draft'].innerHTML = 'update draft+';
                            actionLinks['published'].innerHTML = 'publish';
                        } else if(model.type =='published') {
                            actionLinks['published'].innerHTML = 'update';
                            actionLinks['draft'].innerHTML = 'draft';
                        }
                        idField.value = model.id;

                    }
                    ToastBar.showMessage("post save as " + model.type);
                }

                _addEvents();
            })();

            var ToastBar = (function(){

                var bar = document.querySelector('.toastbar');
                var text = bar.querySelector('.toastbar-text');
                var timer;

                var _showMessage = function(message) {
                    text.innerHTML = message;
                    bar.classList.add('show-toast');
                    timer = window.setTimeout(_hideToast, 2000);
                }

                var _hideToast = function() {
                    window.clearTimeout(timer);
                    bar.classList.remove('show-toast');
                    bar.addEventListener('transitionend', _reset);
                }

                var _reset = function() {
                    bar.removeEventListener('transitionend', _reset);
                }

                return {
                    showMessage : _showMessage
                }
            })();

            function isEmpty(value) {
                var val = value.toString().trim();
                return (val == "" || val == null);
            }

            function doApiCall(request, data, callback) {
                $.ajax({
                    url: request.url,
                    type: request.type,
                    data: data,
                    success: callback
                })
            }
        });

        $(document).ready(function(){
            Editorium();
        })
    </script>
@stop