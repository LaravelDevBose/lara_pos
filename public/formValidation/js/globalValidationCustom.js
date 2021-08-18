$(document).ready(function () {
    GlobalFormValidation  = {
        formValidationApply: function(){
            var elm = $('.GlobalFormValidation');
            elm.formValidation({
                framework: 'bootstrap',
            })
                .on('success.form.fv', function(e) {
                    var form = $(this);
                    e.preventDefault();
                    if(typeof form.find('.prv-msg') !== 'undefined'){
                        $('.prv-msg').css('display','none');
                    }
                    let data = new FormData($(".GlobalFormValidation")[0]);
                    form.find('#success').addClass('hidden');
                    form.find('#error').addClass('hidden');
                    form.find('#please-wait').removeClass('hidden');
                    // let data = new FormData($(".GlobalFormValidation")[0]);
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: form.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(json){
                            form.find('#please-wait').addClass('hidden');
                            if(json.status == 200){

                                var success = form.find('#success');
                                success.find('.message').html(json.message);
                                success.removeClass('hidden');
                                if(json.url == '#'){
                                    form.find('button[type=submit]').attr('disabled', true);
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 2000);
                                }else if(json.url != 0){
                                    setTimeout(function(){
                                        window.location.href = json.url;
                                    }, 2000);
                                }else {
                                    $('button.disabled').removeAttr('disabled');
                                    setTimeout(function(){
                                        form.find('#success').addClass('hidden');
                                    }, 3000);
                                }
                            } else if(json.status == 'false') {
                                var error = form.find('#error');
                                error.find('.message').html(json.message);
                                error.removeClass('hidden');

                                setTimeout(function(){
                                    // form.find('#error').addClass('hidden');
                                    form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                                }, 3000);

                            } else if(json.statusText == 'Validation'){
                                var error = form.find('#error');
                                error.find('.message').html(json.message);
                                error.removeClass('hidden');

                                setTimeout(function(){
                                    // form.find('#error').addClass('hidden');
                                    form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                                }, 3000);

                            }else if(json.statusText == 'Error'){
                                console.log(json);
                                var error = form.find('#error');
                                error.find('.message').html(json.message);
                                error.removeClass('hidden');

                                setTimeout(function(){
                                    form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                                    // form.find('#error').addClass('hidden');
                                }, 3000);
                            }
                        },
                        error : function(json){
                            form.find('#please-wait').addClass('hidden');
                            var error = form.find('#error');
                            error.find('.message').html(json.message);
                            error.removeClass('hidden');

                            setTimeout(function(){
                                form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                                // form.find('#error').addClass('hidden');
                            }, 3000);

                        },
                        dataType: "json"
                    });


                });

        }
    };

    GlobalFormValidation.formValidationApply();
    $('.GlobalFormValidationDelete')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }
        })
        .on('success.form.fv', function(e) {
            var form = $(this);
            e.preventDefault();


            form.find('#success').addClass('hidden');
            form.find('#error').addClass('hidden');
            form.find('#please-wait').removeClass('hidden');

            $.ajax({
                type: "DELETE",
                cache: false,
                url: form.attr('action'),
                data: form.serialize(),
                success: function(json){
                    console.log(json)
                    form.find('#please-wait').addClass('hidden');
                    if(json.status == 'success'){
                        var success = form.find('#success');
                        success.find('.message').text(json.message);
                        success.removeClass('hidden');
                        if(json.url != 0){
                            form.find('button[type=submit]').attr('disabled', true);
                            setTimeout(function(){
                                window.location.href = json.url;
                            }, 2000);
                        }else if(json.url == '#'){
                            form.find('button[type=submit]').attr('disabled', true);
                            setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }else {
                            $('button.disabled').removeAttr('disabled');
                            setTimeout(function(){
                                form.find('#success').addClass('hidden');
                            }, 3000);
                        }
                    } else if(json.status == 'false') {
                        var error = form.find('#error');
                        error.find('.message').text(json.message);
                        error.removeClass('hidden');

                        setTimeout(function(){
                            form.find('#error').addClass('hidden');
                            form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                        }, 3000);

                    } else if(json.status == 'validation'){
                        var error = form.find('#error');
                        error.find('.message').text(json.message);
                        error.removeClass('hidden');

                        setTimeout(function(){
                            form.find('#error').addClass('hidden');
                            form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                        }, 3000);

                    }else if(json.status == 'error'){
                        var error = form.find('#error');
                        error.find('.message').text(json.message);
                        error.removeClass('hidden');

                        setTimeout(function(){
                            form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                            form.find('#error').addClass('hidden');
                        }, 3000);

                    }
                },
                error : function(json){
                    console.log(json)
                    var error = form.find('#error');
                    error.find('.message').text(json.message);
                    error.removeClass('hidden');

                    setTimeout(function(){
                        form.find('input[type=submit]').prop('disabled', false).removeClass('disabled');
                        form.find('#error').addClass('hidden');
                    }, 3000);

                },
                dataType: "json"
            });
        });
});
