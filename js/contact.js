$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                company: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: {
                name: {
                    required: "Debe ingresar su nombre",
                    minlength: "Su nombre debe contener al menos 2 caracteres"
                },
                company: {
                    required: "Debe ingresar el nombre de su empresa",
                    minlength: "El nombre de su empresa debe contener al menos 2 caracteres"
                },
                email: {
                    required: "Debe ingresar su email",
                    email: "El email ingresado no es válido"
                },
                message: {
                    required: "Debe ingresar un mensaje",
                    minlength: "El mensaje debe contener al menos 20 caracteres"
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url:"mail.php",
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo( "slow", 1, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor','default');
                                $('#success').fadeIn();
                                $('#error').fadeOut();
                            })
                        } else {
                            if (response.hasOwnProperty('message')) {
                                $('#error').html(response.message);
                            }
                            $('#error').fadeIn();
                            $('#success').fadeOut();
                        }
                    },
                    error: function() {
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $('#error').fadeIn();
                            $('#success').fadeOut();
                        })
                    }
                })
            }
        })
    })
        
 })(jQuery)
})