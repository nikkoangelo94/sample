<style>
.asdasdasd {
    color : red;
}


/* CUSTOM.CSS */
#field > div:not(:first-child) {
    border-top: 1px solid #f4b949;
    display: inline-block;
    padding: 20px 0;
    margin: 0 auto 20px;
    width: 100%;
}

#add-more:focus {
    background-color: #1A75A4;
}

.form__group input {
    color: #000;
}

.error {
    color: red;
}

label:not(.error):after {
    content: ' *';
    color: red;
    font-size: 18px;
}

#loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    margin: 0 auto;
    display: none;
}

#ty { display: none; }

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
//SCRIPT.HTM
{{ prependScripts([
    '../common/javascripts/vendor/jquery/jquery-1.11.1.min.js',
]) }}

{{ appendScripts([
    '../common/javascripts/vendor/sticky/jquery.sticky.js',
    '../common/javascripts/vendor/iframeresizer/iframeResizer.contentWindow.js',
    '../common/javascripts/smb/jquery.responsive-helper.js',
    '../common/javascripts/smb/navigation-more-button.js',
    '../common/javascripts/vendor/fancybox/jquery.fancybox.js',
    '../common/javascripts/vendor/js-cookie/js.cookie.js',
    '../common/javascripts/smb/frame_selector.js',
    '../common/javascripts/smb/global.js',
    'assets/js/jquery.easing.1.3.js',
    'assets/js/jquery.lavalamp.min.js',
    'assets/js/theme.js',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js',
    'http://malsup.github.com/jquery.form.js',
    'assets/client/js/custom.js'
]) }}

{% scripts %}
</script>
<script>
// CUSTOM.JS
function resetForm(){
    var form = $("#referralForm"),
    validator = form.validate();
    //validator.resetForm();
    form.find("label.error").remove();
    //form.find(".error").removeClass("error");
}

var max_fields  = 3; //maximum input boxes allowed
var wrapper     = $("#field"); //Fields wrapper
var add_button  = $("#add-more"); //Add button ID

var count = 1; //initlal text box count
var html = '<div id="field{0}" name="field{0}"><div class="form__group form-input-frnd-name hasLabel"><div class="label_container"><label for="frnd{0}-name">Friend&#39;s Name</label></div><div class="input_container"><input id="frnd{0}-name" name="frnd_name[]" data-ref-name="frnd{0}_name" class="form__control frnd_name" placeholder="Enter your friend&#39;s name" type="text"></div></div><div class="form__group form-input-frnd-email hasLabel"><div class="label_container"><label for="frnd{0}-email">Friend&#39;s Email</label></div><div class="input_container"><input id="frnd{0}-email" name="frnd_email[]" data-ref-name="frnd{0}_email" class="form__control frnd_email" placeholder="Enter friend&#39;s email address" type="email"></div></div><button id="remove{0}" class="btn btn-danger remove-me">Remove</button></div>';

var template = jQuery.validator.format($.trim(html));
$(add_button).click(function (e) {
    
    
if(count <= max_fields){

    $(template(count++)).appendTo(wrapper).hide().slideDown("slow");

    $('#field input.frnd_name').each(function () {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Please enter a valid friend's name",
            }
        });

        //$(this).addClass("error required").prop('required', true);

    });
    $('#field input.frnd_email').each(function () {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Please enter a valid friend's email",
            }
        });
        $(this).parent().parent().siblings('.form-input-frnd-name').find('.input_container input:not(:focus)').focus();
    });

    e.preventDefault();

    } else {
        // $('#add-more').prop('disabled', true);
        $(add_button).attr('disabled','disable');
    }

});

$(function() {

    var ruleSet = {
        required: true,
        number: false
    };

   var options = {
        rules: {
            first_name: ruleSet,
            last_name: ruleSet,
            email: ruleSet,
            'frnd_name[]': ruleSet,
            'frnd_email[]': ruleSet
        },
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            email: "Please enter a valid email address",
            'frnd_name[]': "Please enter a valid friend's name",
            'frnd_email[]': "Please enter a valid friend's email"
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                beforeSubmit: function (arr, $form, options) {
                    $('#referralForm').fadeOut('fast');
                    $('#loader').fadeIn('slow');
                    // return false;
                },
                success: function (responseText, status) {
                    $('#loader').fadeOut(function() {
                        $('#ty').fadeIn();
                    });
                },
                error: function (xhr, status) {
                    alert("Error! Please contact Martin Ofilanda's CEO, John Alex Ladra.");
                }
            }); 
            return false;
        }
    };

    //Validation
    $('#referralForm').validate(options);
    $('#ty').hide();
});

$(wrapper).on("click",".remove-me", function(e){ // user click on remove text
    e.preventDefault();      
    $(this).parent('div').siblings('div').find('.form-input-frnd-email .input_container input').focus();
    $(this).parent('div').slideUp("slow", function(){ $(this).remove(); });
    count--;
    $('#add-more').removeAttr('disabled');
});

</script>
<?php
/* CODE */
function onHandleForm()
{
    //$this['lastValue'] = post('first_name'); {{ lastValue }} display this in markup :twig:

    /* send to friend's emails */
    $recipients = array_combine(post('frnd_name'), post('frnd_email'));
    foreach($recipients as $name => $email) {
        $to = $email;
        $from = post('email');
        $fromF_name = post('first_name');
        $fromL_name = post('last_name');
        $subject_1 = "Welcome to Paws and Co Veterinary Clinic";
        $message_1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Referal message</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            </head>
            <body style="margin: 0; padding: 0;">
                <table style="table-layout: fixed;min-width: 320px;background-color: rgb(80, 181, 235);border-radius: 5px;margin-top: 10px;margin-right: 10px;margin-bottom: 10px;margin-left: 10px;;box-shadow: 1px 0px 23px #9E9E9E;" cellpadding="0" cellspacing="0" role="presentation">
                    <tbody>
                        <tr>
                            <td>
                                <div role="banner">
                                    <div>
                                        <div align="center" style="margin-top: 6px; margin-bottom: 20px;">
                                            <div align="center" default-align="center" style="font-size: 0px; line-height: 0px;">
                                                <div>
                                                    <div>
                                                        <div style="position:relative">
                                                            <div replace="true" cs-dragover="dragOver(event)" cs-dragleave="dragLeave()">
                                                                <div>
                                                                    <div>
                                                                        <div>
                                                                            <div ng-if="hasImage">
                                                                                <img emb-disable-drag="" unselectable="on" draggable="false" src="http://my.vetmatrix.com/0006724/storage/app/media/assetshtmlmailer2017/erika-edited-2-logo.png" style="max-width: 540px;"><br><img emb-disable-drag="" unselectable="on" draggable="false" src="http://gallery.vetmatrix.com/wp-content/uploads/2017/05/vetmatrix_gallery.png" style="max-width: 292px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="section">
                                    <div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                                        <div style="border-collapse: collapse;display: table;width: 100%;background-color: #fefefe;">
                                            <div style="text-align: left;color: #353638;font-size: 14px;line-height: 21px;font-family: Merriweather,Georgia,serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
                                                    <h1 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #353638;font-size: 26px;line-height: 34px;text-align: center;">Welcome to Paws and Co Wellness Clinic</h1>
                                                    <h2 style="Margin-top: 20px;Margin-bottom: 16px;font-style: normal;font-weight: normal;color: #353638;font-size: 17px;line-height: 26px;text-align: center; text-transform: capitalize;"> Hi! ' . ucwords($name) . '</h2>
                                                    <h2 style="Margin-top: 20px;Margin-bottom: 16px;font-style: normal;font-weight: normal;color: #353638;font-size: 17px;line-height: 26px;text-align: center;">' . ucwords($fromF_name) . '' . ucwords($fromL_name) . ' wanted you to know about Paws and Co Wellness Clinic, a new type of veterinary clinic that offers high quality and affordable wellness care for your pet. We are so honored that (Referring person’s name imported from the form) thinks so highly of us to refer you our way. 
        We can’t wait to meet you and provide great wellness care for your pet(s) at family friendly prices. Here is a link to our website for more information on Paws and Co, including our phone number and even a link to request an appointment online (include link). Or you can simply call us directly at 920-471-0643. 
        <br>
        Thanks and we look forward to meeting you and your fur babies! </h2>
                                                </div>
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
                                                    <div style="text-align:center;">
                                                        <a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #70717d;font-family: Merriweather, Georgia, serif;" href="' . $_SERVER['HTTP_HOST'] . '" target="_blank">Visit Our Site To Learn More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="line-height:20px;font-size:20px;">&nbsp;</div>
                                    <div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                                        <div style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" emb-background-style="">
                                            <div style="text-align: left;color: #353638;font-size: 14px;line-height: 21px;font-family: Merriweather,Georgia,serif;Float: left;max-width: 320px;min-width: 300px; width: 320px;width: calc(12300px - 2000%);">
                                                <div style="font-size: 12px;font-style: normal;font-weight: normal;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;padding-left: 5px;" align="center">
                                                    <img style="border: 0;display: block;height: auto;width: 100%;max-width: 480px;" alt="" width="300" src="http://my.vetmatrix.com/0006724/storage/app/media/assetshtmlmailer2017/featuredblocks_1.jpg">
                                                </div>
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 20px;">
                                                    <h3 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #353638;font-size: 16px;line-height: 24px;"><strong><em>Our Services</em></strong></h3>
                                                    <p style="Margin-top: 12px;Margin-bottom: 41px;">We strive to provide complete care for our patients. Learn more about all the services we provide.&nbsp;</p>
                                                </div>
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
                                                    <div style="text-align:left;">
                                                        <a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #70717d;font-family: Merriweather, Georgia, serif;" href="' . $_SERVER['HTTP_HOST'] . '" target="_blank">See our Services</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="text-align: left;color: #353638;font-size: 14px;line-height: 21px;font-family: Merriweather,Georgia,serif;Float: left;max-width: 320px;min-width: 300px; width: 320px;width: calc(12300px - 2000%);">
                                                <div style="font-size: 12px;font-style: normal;font-weight: normal;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;padding-left: 5px;" align="center">
                                                    <img style="border: 0;display: block;height: auto;width: 100%;max-width: 480px;" alt="" width="300" src="http://my.vetmatrix.com/0006724/storage/app/media/assetshtmlmailer2017/featuredblocks_4.jpg">
                                                </div>
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 20px;">
                                                    <h3 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #353638;font-size: 16px;line-height: 24px;"><em><strong>About Us</strong></em></h3>
                                                    <p style="Margin-top: 12px;Margin-bottom: 20px;">Our team is committed to educating our clients in how to keep your pets healthy year round, with good nutrition and exercise. &nbsp;</p>
                                                </div>
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
                                                    <div style="text-align:left;">
                                                        <a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #70717d;font-family: Merriweather, Georgia, serif;" href="' . $_SERVER['HTTP_HOST'] . '" target="_blank">About Us</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="line-height:20px;font-size:20px;">&nbsp;</div>
                                <div style="line-height:20px;font-size:20px;">&nbsp;</div>
                                <div role="contentinfo">
                                    <div style="Margin: 0 auto;min-width: 320px;width: 100%;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                                        <div style="border-collapse: collapse;display: table;width: 100%;">
                                            <div style="text-align: right;font-size: 12px;line-height: 19px;color: #f6f7ff;font-family: Merriweather,Georgia,serif;Float: left;min-width: 320px;width: 100%;background-color: rgb(199, 149, 41);height: 70px;">
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
                                                    <div style="font-size: 12px;line-height: 19px;">
                                                        <p style="Margin-top: 12px;Margin-bottom: 20px;">Follow us on: &nbsp;<a href="https://www.facebook.com/pawsandcoclinics" target="_blank"><img src="http://my.vetmatrix.com/0006724/storage/app/media/assetshtmlmailer2017/fb-icon.png" alt="Facebook" style="
                                                            width: 40px;
                                                        "></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                                        <div style="border-collapse: collapse;display: table;width: 100%;">
                                            <div style="text-align: left;font-size: 12px;line-height: 19px;color: #f6f7ff;font-family: Merriweather,Georgia,serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                                                <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
                                                    <div style="font-size: 12px;line-height: 19px;">
                                                        <p style="Margin-top: 12px;Margin-bottom: 20px;">Please do not reply to this email. This is just an auto-generated message, you will not get a response from here. &nbsp;</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="line-height:40px;font-size:40px;">&nbsp;</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>';

        $headers_1 = "From: " . post('first_name') . post('last_name') . "<" . $from . ">\n";
        $headers_1 .= "MIME-Version: 1.0" . "\n";
        $headers_1 .= "Content-type:text/html;charset=utf-8" . "\n";

        mail($to, $subject_1, $message_1, $headers_1);
    }

    /* send to client's email */
    //$to_2 = "martin.cr54rep@gmail.com";
    $to_2 = "john.cr54rep@gmail.com";
    //$to_2 = "ar.pawsandco@gmail.com";
    $from = post('email');
    $subject_2 = "New Referral Notification";
    
    $message_2 =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Referal message</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            </head>
            <body style="margin: 0; padding: 0;"><table style="table-layout: fixed;min-width: 320px;background-color: rgb(80, 181, 235);border-radius: 5px;margin-top: 10px;margin-right: 10px;margin-bottom: 10px;margin-left: 10px;;box-shadow: 1px 0px 23px #9E9E9E;" cellpadding="0" cellspacing="0" role="presentation">
   <tbody>
      <tr>
         <td>
            <div role="banner">
               <div>
                  <div align="center" style="margin-top: 6px; margin-bottom: 20px;">
                     <div align="center" default-align="center" style="font-size: 0px; line-height: 0px;">
                        <div>
                           <div>
                              <div style="position:relative">
                                 <div replace="true" cs-dragover="dragOver(event)" cs-dragleave="dragLeave()">
                                    <div>
                                       <div>
                                          <div>
                                             <div ng-if="hasImage">
                                                <img emb-disable-drag="" unselectable="on" draggable="false" src="http://my.vetmatrix.com/0006724/storage/app/media/assetshtmlmailer2017/erika-edited-2-logo.png" style="max-width: 540px;height: auto;"><br><img emb-disable-drag="" unselectable="on" draggable="false" src="http://gallery.vetmatrix.com/wp-content/uploads/2017/05/vetmatrix_gallery.png" style="max-width: 100%;height: 19px;"><br>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div role="section">
               <div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div style="border-collapse: collapse;display: table;width: 100%;background-color: #fefefe;">
                     <div style="text-align: left;color: #353638;font-size: 14px;line-height: 21px;font-family: Merriweather,Georgia,serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                        <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
                           <h1 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #353638;font-size: 26px;line-height: 34px;text-align: center;">You have new referals sent to:</h1>
                           <table name="contact_seller" style="width:100%;border-collapse:collapse;border: 1px solid black;"> 
                <thead>
                    <tr>
                        <th style="border-collapse:collapse;border: 1px solid rgba(0, 0, 0, 0.13);text-align: left;padding: 8px;width: 50%; background-color: rgba(0, 46, 70, 0.26);">Name</th>
                        <th style="border-collapse:collapse;border: 1px solid rgba(0, 0, 0, 0.13);text-align: left;padding: 8px;width: 50%; background-color: rgba(0, 46, 70, 0.26);">Email Address</th>
                    </tr>    
                </thead>
                <tbody style="border-collapse: collapse;border: 1px solid rgba(0, 0, 0, 0.13); width: 50%; width:100%; text-decoration: none!important">';
           foreach($recipients as $name => $email) {
               if(!empty($name) && !empty($email)){
                $message_2 .='<tr><td style="border-collapse:collapse;border: 1px solid rgba(0, 0, 0, 0.13);text-align: left;padding: 8px;width: 50%;">' . ucwords($name) . '</td><td style="border-collapse:collapse;border: 1px solid rgba(0, 0, 0, 0.13);text-align: left;padding: 8px;width: 50%; ">' . $email . '</td></tr>';   
               }
                
           }
            $message_2 .= '</tbody></table><br><h2 style="Margin-top: 20px;Margin-bottom: 16px;font-style: normal;font-weight: normal;color: #353638;font-size: 17px;line-height: 26px;text-align: center;">If you need further assistance with your website, you may call us at <a href="tel:18004628749">1-800-462-8749</a> or click <a href="http://new.imatrix.com/veterinary/" target="_blank">here to</a> visit our vetmatrix website.
                           </h2>
                        </div>
                        <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
                           <div style="text-align:center;">
                              <a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #70717d;font-family: Merriweather, Georgia, serif;" href="' . $_SERVER['HTTP_HOST'] . '" target="_blank">Visit Your Site Now</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div role="contentinfo">
               <div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div style="border-collapse: collapse;display: table;width: 100%;">
                     <div style="text-align: left;font-size: 12px;line-height: 19px;color: #f6f7ff;font-family: Merriweather,Georgia,serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                        <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
                           <div style="font-size: 12px;line-height: 19px;">
                              <p style="Margin-top: 12px;Margin-bottom: 20px;">Please do not reply to this email. This is just an auto-generated message, you will not get a response from here. &nbsp;</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </td>
      </tr>
   </tbody>
</table>';
    
    $headers_2 = 'From: ' . $from . "\r\n";
    $headers_2 .= "MIME-Version: 1.0" . "\r\n";
    $headers_2 .= "Content-type:text/html;charset=utf-8" . "\r\n";
    
    mail($to_2, $subject_2, $message_2, $headers_2);
}
?>
<html>
<!-- MARKUP -->
<div class="wrap__form refer-a-friend">
    <div class="wrap__form--inner">
        <div class="wrap__editable">
            {% component "editable" file="refer-a-friend.htm" %}
        </div>
        {#% component "form_refer_a_friend" %#}
        {{ form_open({ request: 'onHandleForm', id: 'referralForm' }) }}
        <div class="form ">
            <div class="leadForm_Lnw1eFDfD7HrJ0W-nECLRvjx">
               <div class="leadForm">
                  <form id="referralFrom" action="" method="POST">
                     <div class="form__group form-input-first_name hasLabel">
                        <div class="label_container"><label for="first_name-1502314001026">First Name</label></div>
                        <div class="input_container"><input id="first_name-1502314001026" name="first_name" data-ref-name="first_name" class="form__control" placeholder="Enter your first name" type="text"></div>
                     </div>
                     <div class="form__group form-input-last_name hasLabel">
                        <div class="label_container"><label for="last_name-1502314001028">Last Name</label></div>
                        <div class="input_container"><input id="last_name-1502314001028" name="last_name" data-ref-name="last_name" class="form__control" placeholder="Enter your last name" type="text"></div>
                     </div>
                     <div class="form__group form-input-email hasLabel">
                        <div class="label_container"><label for="email-1502314001028">Email</label></div>
                        <div class="input_container"><input id="email-1502314001028" name="email" data-ref-name="email" class="form__control" placeholder="Enter your email address" type="email"></div>
                     </div>
                     <div id="field">
                         <div id="field0" name="field0">
                             <div class="form__group form-input-frnd-name hasLabel">
                                <div class="label_container"><label for="frnd0-name">Friend's Name</label></div>
{#                                  <div class="input_container"><input id="name-frnd-0" name="frnd0_name" data-ref-name="frnd0_name" class="form__control" placeholder="Enter your friend's name (required)" type="text"></div>#}
                                <div class="input_container"><input id="frnd0-name" name="frnd_name[]" data-ref-name="frnd0_name" class="form__control" placeholder="Enter friend's name" type="text"></div>
                             </div>
                             <div class="form__group form-input-frnd-email hasLabel">
                                <div class="label_container"><label for="frnd0-email">Friend's Email</label></div>
{#                                  <div class="input_container"><input id="email-frnd-0" name="frnd0_email" data-ref-name="frnd0_email" class="form__control" placeholder="Enter friend's primary email address" type="email"></div>#}
                                <div class="input_container"><input id="frnd0-email" name="frnd_email[]" data-ref-name="frnd0_email" class="form__control" placeholder="Enter friend's email address" type="email"></div>
                             </div>
                         </div>
                     </div>
                     <span class="form-wrap__submit"><input id="add-more" class="btn submit" name="add-more" value="Add Referral" type="button"></span>
        
                     <span class="form-wrap__submit"><input class="btn submit" name="submit_to_email" value="Submit" type="submit"></span>
                     <div aria-hidden="true"><input name="__lf__ref_contact_field" aria-label="__lf__ref_contact_field" tabindex="-1" type="hidden"></div>
                  </form>
               </div>
            </div>
        </div>
        {{ form_close() }}
        <div style="overflow: hidden; margin-bottom: 30px;">
            <div id="ty"><h2>Thank you for sending your referral.</h2><br><br><a href="{{ this.page.url }}">Go back.</a> | <a href="/refer-a-friend">Refer again.</a></div>
            <div id="loader"></div>
        </div>
    </div>
</div>
</html>
