$(document).ready(function(){    
    //logout section
    $('.signOut').click(function() {
        $.ajax({
            type: "post",
            url: themeAjaxVar,
            data: {
                action: 'themelogoutfunc'
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    //registration section
	$('#CustomerCreateaccountSubmit').click(function(){
		var CustomerName = $('#CustomerName').val(),
		    CustomerEmail = $('#CustomerEmail').val(),
		    CustomerPassword = $('#CustomerPassword').val(),
		    CustomerBusinessname = $('#CustomerBusinessname').val(),
		    CustomerMobileno = $('#CustomerMobileno').val(),
		    CustomerPhoneno = $('#CustomerPhoneno').val();
        var themeregistermailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //email format
        var themeRegCheck = 0;
        $('#theme_error_registration').hide();
        if(CustomerName == '') {
            $('#theme_error_registration').show();
            $('#theme_error_registration').text('Name field can not be blank');
            themeRegCheck = 1;
        } else if( !CustomerEmail.match(themeregistermailformat) ) {
            $('#theme_error_registration').show();
            $('#theme_error_registration').text('Please give correct email id');
            themeRegCheck = 1;
          } else if(CustomerPassword == '') {
                $('#theme_error_registration').show();
                $('#theme_error_registration').text('Password field can not be blank');
                themeRegCheck = 1;
            } else if(CustomerBusinessname == '') {
                $('#theme_error_registration').show();
                $('#theme_error_registration').text('Business name field can not be blank');
                themeRegCheck = 1;
              } else if( (CustomerMobileno=='') || isNaN(CustomerMobileno) ) {
                    $('#theme_error_registration').show();
                    $('#theme_error_registration').text('Please give correct Mobile no');
                    themeRegCheck = 1;
                } else if( (CustomerPhoneno=='') || isNaN(CustomerPhoneno) ) {
                    $('#theme_error_registration').show();
                    $('#theme_error_registration').text('Please give correct Phone no');
                    themeRegCheck = 1;
                  }
        if(themeRegCheck != 1) {
    		$.ajax({
                type: "post",
                url: themeAjaxVar,
                data: {
                    action: 'userregisterfunc',
                    'CustomerName': CustomerName,
                    'CustomerEmail': CustomerEmail,
                    'CustomerPassword': CustomerPassword,
                    'CustomerBusinessname': CustomerBusinessname,
                    'CustomerMobileno': CustomerMobileno,
                    'CustomerPhoneno': CustomerPhoneno
                },
                success: function(data) {
                    if(data == 'You have already registered. Please try by another details') {
                        $('#theme_error_registration').show();
                        $('#theme_error_registration').text(data);
                    } else {
                        window.location.reload();
                      }
                }
            });
        }
	});

    //sign in section
    $('.Themelogin_button').click(function(){
        var Themesignin_email = $('#Themesignin_email').val(),
            Themesignin_password = $('#Themesignin_password').val(),
            check = 0;
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //email format
        $('#theme_error').hide();
        if( !Themesignin_email.match(mailformat) ){
            $('#theme_error').show();
            $('#theme_error').text('Please give correct email id');
            check = 1;
        } else if( Themesignin_password == '' ) {
            $('#theme_error').show();
            $('#theme_error').text('Password field can not be blank');
            check = 1;
          }
        if(check != 1) {
            $.ajax({
                type: "post",
                url: themeAjaxVar,
                data: {
                    action: 'usersigninfunc',
                    'Themesignin_email': Themesignin_email,
                    'Themesignin_password': Themesignin_password
                },
                success: function(data) {
                    if(data == 'All Good')
                        window.location.reload();
                    else {
                        $('#theme_error').show();
                        $('#theme_error').text(data);
                    }
                }
            });
        }
    });

    //apps page inevntory section
    $('#appspageoption1inventory, #appspageoption2inventory').click(function(){
        $('#appspageinventoryimg').fadeIn('800');
    });

    //inventory close section
    $('.closeBtn').click(function(){
        $(this).parent('.popUpBox').fadeOut('800');
    });

    //home page popup section
    $('.homepagepopupBox').click(function(){
        var src = $(this).attr('data-image');
        var title = $(this).attr('data-title');
        var dataid = $(this).attr('data-id');
        $('.conBoxPopUp').show('slow');
        $('#homepagepopup').show('slow');
        $('#inventorymainprdct_img').attr('src', src);
        $('#inventorymainprdct_title').text(title);
        $('#openprdctid').val(dataid);
        $('#inventoryProductImgul').html('');
        $.ajax({
            type: "post",
            url: themeAjaxVar,
            data: {
                action: 'inventoryprdctshowfunc',
                'parentprdctid': dataid
            },
            success: function(data) {
                // alert(data);
                if(data != '') {
                    $('#inventoryProductImgul').append(data);
                    $('#inventoryProductImgul').show();
                }
            }
        });
    });
    $('#homepagepopup .closeBtn').click(function(){
        $(this).parent().parent('.conBoxPopUp').fadeOut('800');
        $('.conBoxPopUp').hide('slow');
        $('#inventoryprdctname').val('');
        $('#inventoryprdctdesc').val('');
        $('#artWorkImgPreview').attr('src', '');
        $('#inventoryquantity').val('');
        $('#addInventory').show();
        $('#artworktitle').empty();
        $('#artworktitle').hide();
        $('#updateInventory').hide();
        $('#deleteInventory').hide();
        $('#browseInventory').hide();
        $('.artWorkPreview').hide();
        $.removeCookie("inventoryartworkimgurl");
        $.removeCookie("inventoryartworkimgtitle");
    });

    $('#addInventory').click(function(){
        var inventoryquantity = $('#inventoryquantity').val();
        if( !isNaN(inventoryquantity) ||(inventoryquantity<0) )
            $('#inventoryquantity').attr('placeholder', 'Please use number');
        $('#browseInventory').show();
    });

    //inventory product image upload section
    var progressbox     = $('#progressbox');
    var progressbar     = $('#progressbar');
    var statustxt       = $('#statustxt');
    var submitbutton    = $("#SubmitButton");
    var myform          = $("#UploadForm");
    var output          = $("#output");
    var completed       = '0%';
    $(myform).ajaxForm({
        beforeSend: function() { //brfore sending form
            submitbutton.attr('disabled', ''); // disable upload button
            statustxt.empty();
            progressbox.slideDown(); //show progressbar
            progressbar.width(completed); //initial value 0% of progressbar
            statustxt.html(completed); //set status text
            statustxt.css('color','#000'); //initial color of status text
        },
        uploadProgress: function(event, position, total, percentComplete) { //on progress
            progressbar.width(percentComplete + '%') //update progressbar percent complete
            statustxt.html(percentComplete + '%'); //update status text
            if(percentComplete>50) {
                    statustxt.css('color','#fff'); //change status text to white after 50%
            }
        },
        complete: function(response) { // on complete
            output.html(response.responseText); //update element with received data
            myform.resetForm();  // reset form
            submitbutton.removeAttr('disabled'); //enable submit button
            progressbox.slideUp(); // hide progressbar
        }
    });

    //inventory product edit section
    $('body').on('click', '.inventoryImgClass', function(){
        var inventoryImgID = $(this).attr('id');
        $.ajax({
            type: "post",
            url: themeAjaxVar,
            data: {
                action: 'inventoryprdcteditfunc',
                'inventoryImgID': inventoryImgID
            },
            success: function(data) {
                if(data != '') {
                    data = JSON.parse(data);
                    $('#inventoryprdctname').val(data['post_title']);
                    $('#inventoryprdctdesc').val(data['post_content']);
                    $('#artWorkImgPreview').attr('src', data['post_image_url']);
                    $('#inventoryquantity').val(data['qty']);
                    $('#addInventory').hide();
                    $('#artworktitle').html(data['post_title']+'.pdf');
                    $('#artworktitle').show();
                    $('#updateInventory').show();
                    $('#deleteInventory').show();
                    $('#browseInventory').show();
                    $('.artWorkPreview').show();
                    $('#artWorkImgPreview').click(function(){
                        $.cookie('inventoryartworkimgurl', data['post_image_url']);
                        $.cookie('inventoryartworkimgtitle', data['post_title']);
                        location.href = 'pdf.php';
                    });
                }
            }
        });

    });

    //inventory product update section start //
    // $('#updateInventory').click(function(){

    // });
    //inventory product update section end //

    //home page user menu section
    $('.showEdit').click(function() {
        $(this).next(".editBox").fadeToggle();
        $(this).toggleClass('active');
    });
    $('.userMenu ul li a').click(function() {
        $(this).toggleClass('active').next().fadeIn('800');
    });
    $('.userMenuOptions .closeBtn').click(function() {
        $(this).parent().fadeOut('800').prev().removeClass('active');
    });


    /*********** This portion has to be check **********/
            $("input[type='radio']").click(function()
                {
              var previousValue = $(this).attr('previousValue');
              var name = $(this).attr('name');

              if (previousValue == 'checked')
              {
                $(this).removeAttr('checked');
                $(this).attr('previousValue', false);
              }
              else
              {
                $("input[name="+name+"]:radio").attr('previousValue', false);
                $(this).attr('previousValue', 'checked');
              }
            });

            //
            
            $('.accountInfo').click(function(){
                $(this).parent('.createAccount').next('.popupMode').fadeIn('800');
            });

            // $('.accountInfo').click(function(){
            //     $(this).parent().parent('.inventory').find('.popupMode2').fadeIn('800');
            // });

            //
            

            $('.box').click(function() {
                $(this).parent('.orderInfo').find('.popUpBox').fadeIn('800');
            });
            
            // $('.closeBtn').click(function(){
            //     $(this).parent('.popUpBox').fadeOut('800');
            // });

            // $('.showEdit').click(function() {
            //     $(this).next(".editBox").fadeToggle();
            //     $(this).toggleClass('active');
            // });

            // $('.userMenu ul li a').click(function() {
            //     $(this).toggleClass('active').next().fadeIn('800');
            // });

            // $('.userMenuOptions .closeBtn').click(function() {
            //     $(this).parent().fadeOut('800').prev().removeClass('active');
            // });

    /**************************************************/

});