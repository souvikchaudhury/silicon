$(document).ready(function(){  
    window.dataid = '';
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
        window.dataid = dataid;
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
                $('.inventoryOrder').click(function(){
                    if(this.checked){
                        // alert('checked');
                        var checkedValues = $('input:checkbox:checked').map(function() { return this.value; }).get();

                        $.ajax({
                            type: "post",
                            url: themeAjaxVar,
                            data: {action: 'changeinventoryordercosts','allcheckedpostid': checkedValues },
                            success:function(data){
                                alert(data);
                            }
                        });
                    }else{
                        // alert('Unchecked');
                        var checkedValues = $('input:checkbox:checked').map(function() { return this.value; }).get();
                        $.ajax({
                            type: "post",
                            url: themeAjaxVar,
                            data: {action: 'changeinventoryordercosts','allcheckedpostid': checkedValues },
                            success:function(data){
                                alert(data);
                            }
                        });
                    }
                });
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
        $('#artworktitle,#updateInventory,#deleteInventory').hide();
        $('#formmode').val('inserttime');
        // $('#browseInventory').hide();
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
    var uploadcontainer = $("#uploadcontainer");
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
            if(response.responseText == 'notupdate'){
                output.html('Not Updated Please Give One Product Image'); //update element with received data
                submitbutton.removeAttr('disabled'); //enable submit button
                progressbox.slideUp(); // hide progressbar
                $('#artworktitle').fadeOut();
            }else{
                $('#artworktitle').html('');
                $('#artworktitle,#updateInventory,#deleteInventory').hide();
                $('#formmode').val('inserttime');
                $('.artWorkPreview').hide();
                $('#addInventory').show();
                output.html(response.responseText); //update element with received data
                myform.resetForm();  // reset form
                submitbutton.removeAttr('disabled'); //enable submit button
                progressbox.slideUp(); // hide progressbar
                uploadcontainer.html('<div class="uploadmain"><div id="progress_status1"><div id="progressbar1" class="progress"></div><div id="status1"></div></div><div id="complete1"></div><div id="thumb1"></div><div id="error1"></div><input type="file" name="uploadimg[]" class="uploadimg" data-count="1" onchange="fileread(this)" ></div>');   
                $.ajax({
                    type: "post",
                    url: themeAjaxVar,
                    data: {
                        action: 'inventoryprdctshowfunc','parentprdctid': window.dataid
                    },
                    success: function(data) {
                        // alert(data);
                        if(data != '') {
                            $('#inventoryProductImgul').show();
                            $('.inventoryProductImgulcls').html(data);
                        }
                    }
                });    
            }
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
                // alert(data);
                artWorkImgPreview = '';
                imageresponse = '';
                if(data != '') {
                    data = JSON.parse(data);
                    for( var i in data['post_image_url'] ){
                        // alert(data['post_image_url'][i]);
                        artWorkImgPreview += "<img id='artWorkImgPreview_"+i+"' class='artWorkImgPreview' data-metakey='"+data['post_image_url'][i]['meta_key']+"' src='"+data['post_image_url'][i]['meta_value']+"' height='223' width='347'/><div data-counter = '"+i+"' class='updateimgdelete'>Delete</div>";
                        // imageresponse = imageresponse + data['post_image_url'][i]['meta_value'] + '<*>';
                    }
                    /*imageresponse = imageresponse.trim();
                    lnth = imageresponse.length-3;
                    lnthlst = lnth-3;
                    imageresponse = imageresponse.substring(0,lnth);*/
                    $('#inventoryprdctID').val(data['ID']);
                    $('#inventoryprdctname').val(data['post_title']);
                    $('#inventoryprdctdesc').val(data['post_content']);
                    $('#artWorkImgPreviewdiv').html(artWorkImgPreview);
                    $('#inventoryquantity').val(data['qty']);
                    $('#addInventory').hide();
                    $('#artworktitle').html(data['post_title']+'.pdf');
                    $('#artworktitle,#updateInventory,#deleteInventory,#browseInventory,.artWorkPreview').show();
                    $('#formmode').val('updatetime');

                    $('.updateimgdelete').click(function(){
                        var r = confirm("Are you sure you want to delete this Image?")
                        if(r == true)
                        {
                            thisobj = $(this);
                            indx = $(this).attr('data-counter');
                            imgsrcid = $('#artWorkImgPreview_'+indx);
                            imgmetakey = imgsrcid.attr('data-metakey');
                            imgsrc = imgsrcid.attr('src');
                            imgsplitarr = imgsrc.split('/');
                            imgsplitarr = imgsplitarr.reverse();
                            file_name = relativepath+'/upload/'+imgsplitarr[0];
                            $.ajax({
                                type: "post",
                                url: themeAjaxVar,
                                data: {action:'updatedeletefunc','file':file_name,'meta_key':imgmetakey,'inventoryImgID':inventoryImgID},
                                success: function (response) {
                                    $('#artWorkImgPreview_'+indx).remove();
                                    thisobj.remove();
                                }
                            });
                        }
                    });



                    $('.artWorkImgPreview').click(function(){
                        imageresponse = $(this).attr('src')
                        $.cookie('inventoryartworkimgurl', imageresponse);
                        $.cookie('inventoryartworkimgtitle', data['post_title']);
                        location.href = 'pdf.php';
                    });
                }
            }
        });

    });
    function getPath() {
        var path = "";
        nodes = window.location. pathname. split('/');
        for (var index = 0; index < nodes.length - 3; index++) {
            path += "../";
        }
        return path;
    }
    

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



var uploadmain, progress_status, progressbar, status, complete, thumb, error;

function fileread(file) {

    indx = file.getAttribute("data-count");
    
    // uploadmain = 'uploadmain'+indx;
    progress_status = 'progress_status'+indx;
    progressbar = 'progressbar'+indx;
    status = 'status'+indx;
    complete = 'complete'+indx;
    thumb = 'thumb'+indx;
    error = 'error'+indx;

    // console.log(indx);

    var fsize = file.files[0].size;
    var fname = file.files[0].name;
    var ftype = file.files[0].type;
    var fielArray = ["image/png", "image/jpeg", "image/gif", "image/jpg"];
    var fileTrue = fielArray.indexOf(ftype);
    if(fileTrue>=0){
        var reader = new FileReader();
        reader.element = $(file).parent().find(thumb);
        reader.onload = function(e) {
            var div = document.getElementById(thumb);
            div.innerHTML = "<img class='thumb' src='" + e.target.result + "'" +"title='" + fname + "'/>";

            var formData = new FormData();
            for (var i = 0; i < file.files.length; i++) {
                var fileup = file.files[i];
                // Check the file type.
                if (!fileup.type.match('image.*')) {
                    continue;
                }
                // Add the file to the request.
                formData.append('filename[]', fileup, fileup.name);
            }
            uploadajax(formData)
        };
        reader.onerror = function(e) {
            alert("error: " + e.target.error.code);
        };
        reader.readAsDataURL(file.files[0]);
    }else{
        document.getElementById(error).innerHTML = "Incorrect file format, Please select an image file format..";
    }
 }
 
 
function uploadajax(formData){ 
    // console.log('uploadajax', uploadmain,' == ', progress_status, ' == ',progressbar, ' == ',status, ' == ',complete, ' == ',thumb, ' == ',error);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // console.log(xhr.responseText);
        } else {
            alert('An error occurred!');
        }
    };

    xhr.upload.addEventListener("progress", imageprogress, false);
    xhr.addEventListener("load", Completed, false);
    xhr.addEventListener("error", failstatus, false);
    xhr.addEventListener("abort", Abortedstatus, false);
    xhr.send(formData);

}
 
function imageprogress(event){
    document.getElementById(complete).style.display = 'none';
    document.getElementById(progress_status).style.display = 'block'; 
    //document.getElementById("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    document.getElementById(status).value = Math.round(percent);
    // $("#"+progressbar).progressbar({value: document.getElementById(status).value});
    document.getElementById(status).innerHTML = Math.round(percent)+"%";
}
 
function Completed(event){
    document.getElementById(complete).style.display = 'block';
    document.getElementById(progress_status).style.display = 'none';
    document.getElementById(complete).innerHTML = event.target.responseText;
    document.getElementById(progressbar).value = 0;
}
function failstatus(event){
    document.getElementById(status).innerHTML = "Upload Failed";
}
function Abortedstatus(event){
    document.getElementById(status).innerHTML = "Upload Aborted";
}