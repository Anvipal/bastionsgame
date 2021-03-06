/**
 * Created by Alexan on 10.07.2015.
 */

$.popup = function (options) {

    var self = this;

    var settings = $.extend({
        'class': "",
        updateContentClass: 'popup-grid'
    }, options);

    //$(".popup-bg, .popup-grid").remove();
    var bg = $("<div>", {
        'class': 'popup-bg'
    });
    var popup = $("<div>", {
        'class': "popup-grid " + settings.class
    });


    var showed = false;

    bg.on("click", function () {
        self.close();
    });

    popup.on("click", ".close, a[href=#close], *[rel=close]", function () {
        self.close();
    });

    self.doAction = function (action, link) {
        var _popup = self.element();
        if (action[0] !== "#") {

            /*_popup.find('.popup-tab-wrap').animate({top: -150}, 300);
             _popup.find('.popup-body').animate({left: -900}, 300);*/

            _popup.find('.popup-tab-wrap').fadeOut(300);
            _popup.find('.popup-body').fadeOut(300);

            self.element().addClass('loading');

            var filter = $('#filter-form'),
                data = filter.length ? filter.serialize() : {} ;

            $.ajax({
                url: action,
                data: data,
                type: 'POST'
            }).done(function (res) {
                try {
                    if ('redirect' in res) {
                        if (res.redirect != false)
                            self.doAction(res.redirect);
                        else
                            self.close();
                    }
                } catch (e) {
                    _popup.removeClass('create-new');

                    /*setTimeout(function(){
                     _popup.html(res);
                     _popup.find("a[href='" + action + "']").addClass("active");
                     _popup.find('.popup-body').not('.popup-body-main').hide();
                     }, 1000);*/

                    _popup.html(res);
                    /*_popup.find('.popup-tab-wrap').css({top: "-150px"});
                     _popup.find('.popup-body-main').css({left: "-900px"});*/

                    _popup.find('.popup-tab-wrap').fadeOut(0);
                    _popup.find('.popup-body-main').fadeOut(0);

                    _popup.find("a[href='" + action + "']").addClass("active");
                    _popup.find('.popup-body').not('.popup-body-main').hide();

                    /*_popup.find('.popup-tab-wrap').animate({top: 0}, 300);
                     _popup.find('.popup-body-main').animate({left: 0}, 300);*/

                    _popup.find('.popup-tab-wrap').fadeIn(300);
                    _popup.find('.popup-body-main').fadeIn(300);

                    self.element().removeClass('loading');
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $.popup().close();
                $.popup({
                    'class': 'error'
                }).show(jqXHR.responseText);
            });
        } else {
            if ($(action).length) {

                /*_popup.find('.popup-tab-wrap').animate({ top: -150 }, 300);
                 _popup.find('.popup-body:visible').animate({ left: -900 }, 300, function(){
                 _popup.find('.popup-body').hide();
                 _popup.find('.popup-tab-wrap').animate({ top: 0 }, 300);
                 $(action).css({ left: -900 }).show().animate({ left: 0 }, 300);
                 if(link !== undefined) link.addClass("active");
                 });*/

                _popup.find('.popup-body').hide();
                $(action).show();
                if (link !== undefined) link.addClass("active");
            }
        }
    };

    self.show = function (content) {
        if (showed) return false;
        if (content) popup.html(content);

        popup.find('.popup-body').not('.popup-body-main').hide();

        $("body").append(bg).append(popup);

        popup.on("click", "a", function (e) {


            var link = $(this);
            if (link.hasClass('active') || link.hasClass('close') || link.hasClass('disabled')) return false;
            if(link.attr('data-disable-ajax') !== undefined ) return;

            var action = link.attr("href");
            if (action == undefined || action == '' || action == '#close' || action == '#false') return false;

            popup.find(".active").removeClass("active");
            self.doAction(action, link);

            e.preventDefault();
            return false;
        });

        popup.on("submit", "form[data-ajax-file]", function (e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                type: "POST",
                contentType: false,
                processData: false,
                cache: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $('.progress-container .progress-bar').width((percentComplete*100)+'%');
                        }
                    }, false);
                    return xhr;
                },
                data: formData
            }).done(function (res) {
                form.trigger('onAjaxDone', [form, res]);
                try {
                    if ('redirect' in res) {
                        if (res.redirect != false)
                            self.doAction(res.redirect);
                        else
                            self.close();
                    }
                } catch (e) {
                    var _popup = $.popup().element();
                    _popup.html(res);
                    _popup.find("a[href='" + form.attr('action') + "']").addClass("active");
                    _popup.find('.popup-body').not('.popup-body-main').hide();
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $.popup().close();
                $.popup({
                    'class': 'error'
                }).show(jqXHR.responseText);
                form.trigger('onAjaxFail', [form, jqXHR, textStatus, errorThrown]);
            });
        });

        popup.on('click','form[data-ajax-file] .clearFile',function(){
            var list =$('#list');
            $('.clearFile').removeClass('visible');
            list.html('');
            $(this).closest('form').find('input[type="file"]').val('');
        });
        popup.on('change', 'form[data-ajax-file] input[type="file"]', function (evt) {
            var files = evt.target.files;
            var list =$('#list');
            list.html('');
            if(files.length>0)
                $('.clearFile').addClass('visible');
            else
                $('.clearFile').removeClass('visible');
            for (var i = 0, f; f = files[i]; i++) {
                var reader = new FileReader();
                // Only process image files.
                if (!f.type.match('image.*')) {
                    reader.onload = (function (theFile) {
                        return function (e) {
                            var span = document.createElement('span');
                            span.innerHTML = [
                                '<span class="type-default"></span>',
                                '<span class="file-wrap">',
                                '<span class="file-name">',
                                escape(theFile.name),
                                '</span>',
                                '</span>',
                            ].join('');
                            list.append(span);
                            //document.getElementById('list').insertBefore(span, null);
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }

                else {

                    reader.onload = (function (theFile) {

                        return function (e) {
                            // Render thumbnail.
                            var a = document.createElement('a');
                            a.innerHTML = ['<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
                            list.append(a);
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }

            }
        });
        popup.on("submit", "form[data-ajax]", function (e) {

            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: form.attr('method') || "POST"
            }).done(function (res) {



                try {
                    if( 'result' in res ){
                        if( res.result == true )
                            form.trigger('onAjaxDone', [form, res]);
                    }
                    if ('redirect' in res) {
                        if (res.redirect != false)
                            self.doAction(res.redirect);
                        else
                            self.close();
                    }
                } catch (e) {
                    var _popup = $.popup().element();
                    _popup.html(res);
                    _popup.find("a[href='" + form.attr('action') + "']").addClass("active");
                    _popup.find('.popup-body').not('.popup-body-main').hide();
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {
                $.popup().close();
                $.popup({
                    'class': 'error'
                }).show(jqXHR.responseText);
                form.trigger('onAjaxFail', [form, jqXHR, textStatus, errorThrown]);
            });

            e.preventDefault();
            return false;
        });

        showed = true;
        return true;
    };

    self.showURL = function (url, data) {
        $.ajax({
            url: url,
            type: "post",
            data: data || {}
        }).done(function (res) {
            self.show(res);
            self.element().find("a[href*='" + url + "']").addClass("active");
        }).fail(function (jqXHR, textStatus, errorThrown) {
            self.show(jqXHR.responseText);
        });
    };

    self.close = function () {

        $('.popup-bg').trigger('popupBeforeClose')

        $(".popup-bg, .popup-grid").remove();
        self.defaultAction = {};
    };

    self.element = function () {
        return $(".popup-grid");
    };

    self.onBeforeClose = function(callback){

        $(".popup-bg").on('popupBeforeClose', function(){
            callback(self);
        });
    };

    return this;
};

$(function () {

    if($.pjax) $.pjax.defaults.timeout=5000;
});


$(document).on('pjax:timeout', function (e) {
    console.log('Timeout pjax!');
}).on('pjax:error', function (e) {
    console.log('Error pjax!');
}).on('onAjaxDone', 'form[data-grid-view].form-fill, form[data-pjax-container].form-fill', function (e) {
    console.log('onAjaxDone!');
    var it = $(this),
        gridView = it.attr('data-grid-view') || false,
        pjaxConainer = it.attr('data-pjax-container') || false;
    if( gridView && $(gridView).length ){
        console.log('Update grid view');
        $(gridView).yiiGridView("applyFilter");
    } else if( pjaxConainer && $(pjaxConainer).length ){
        console.log('Update pjax container');
        $.pjax.reload({ container: pjaxConainer, timeout: 9000 });
    }

}).on('onAjaxFail', 'form[data-ajax=1].form-fill', function(e, form, jqXHR, textStatus, errorThrown){
    console.log('onAjaxFail', textStatus);
});
