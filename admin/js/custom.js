$(document).ready(function() {
    //logout section
    $('.session_logout').click(function() {
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'logoutfunc'
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    //category section
    $('.addCategory').click(function() {
        $('#category_name').val('');
        $('#category_rightPannelOption').show();
    });
    $('#save_cat').click(function() {
        var categoryName = $('#category_name').val();
        var errorBlank = 0;
        var data_catid = $('#category_name').attr('data-catid');
        if (categoryName == '') {
            $('#category_errormsg').show();
            $('#category_errormsg').text('Category Name can not be blank');
            errorBlank = 1;
        }
        if (errorBlank != 1) {
            $.ajax({
                type: "post",
                url: adminAjaxVar,
                data: {
                    action: 'categoryaddfunc',
                    'cat_name': categoryName,
                    'datacatid': data_catid
                },
                success: function(data) {
                    if (data_catid != '') {
                        window.location.reload();
                    } else {
                        $('.leftPannelOption .selection').html('');
                        $('.leftPannelOption .selection').append('<li><label for="business">' + data + '</label></li>');
                        $('#category_rightPannelOption').hide();
                    }
                }
            });
        }
    });
    $('.business_cat_class').click(function() {
        var catid = $(this).attr('id');
        var catname = $(this).text();
        $('#category_rightPannelOption').show();
        $('#category_name').attr('data-catid', catid);
        $('#category_name').val(catname);
    });

    //product section
    $('.addProduct').click(function() {
        $('#product_details_section').show();
    });
    $('#quantity_button').click(function() {
        var quantityval = $('#Quantity').val();
        if ((quantityval == '') || (quantityval <= 0)) {
            $('.quantity_msg').show();
        } else {
            $('.quantity_msg').hide();
            $.ajax({
                type: "post",
                url: adminAjaxVar,
                data: {
                    action: 'productquantityaddfunc',
                    'quantityno': quantityval
                },
                success: function(data) {
                    $('#product_add_quan').append(data);
                    $('.saveProduct').show();
                    $('#Quantity').val('');
                }
            });
        }
    });
    $('.showProduct').click(function(){
        var showProductId = $(this).attr('id');
        $('#product_details_section').show();
        $('.popColWrap p:nth-child(3), .popColWrap p:nth-child(4)').remove();
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'showproductfunc',
                'showProductId': showProductId
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#blah').attr('src', data['post_image_url']);
                $('#Item').val(data['itemname']);
                $('#Description').val(data['itemdesc']);
                $('#product_add_quan').append('<p class="smlVer"><span>'+data['qty']+'</span><span>Price $</span><input type="text" value="'+data['price']+'" name="price_arr" required="required" /><span class="lastOne">Shipping $</span><input type="text" value="'+data['shipping_cost']+'" name="shipping_arr" required="required" /></p>');
                $('.saveProduct').show();
                $('#saveProductButton').after('<a href="javascript:void(0)" class="productDeleteButton" id="'+showProductId+'">DELETE PRODUCT</a>');
            }
        });
    });
    $(document).on('click', '.productDeleteButton', function(){
        var deleteProductid = $(this).attr('id');
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'deleteproductfunc',
                'deleteProductid': deleteProductid
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    //customer section
    $('#save_customer_button').click(function() {
        var customer_full_name = $('.CustomerfullName').val();
        var customer_business_name = $('.CustomerBusinessName').val();
        var customer_user_email = $('.CustomerUserEmail').val();
        var customer_user_mobile = $('.CustomerUserMobile').val();
        var customer_user_phone = $('.CustomerUserPhone').val();
        var customer_user_password = $('.CustomerUserPassword').val();
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //email format
        var datacusid = $(this).attr('data-cusid');
        var check = 0;
        $('#custmererrormsg').remove();
        if (customer_full_name == '') {
            $('.CustomerfullName').after('<span id="custmererrormsg">Name field can not be blank</span>');
            check = 1;
        } else if (customer_business_name == '') {
            $('.CustomerBusinessName').after('<span id="custmererrormsg">Business name field can not be blank</span>');
            check = 1;
        } else if (!customer_user_email.match(mailformat)) {
            $('.CustomerUserEmail').after('<span id="custmererrormsg">Please insert correct mail id</span>');
            check = 1;
        } else if (isNaN(customer_user_mobile) || (customer_user_mobile == '')) {
            $('.CustomerUserMobile').after('<span id="custmererrormsg">Please insert number in Mobile number field</span>');
            check = 1;
        } else if (isNaN(customer_user_phone) || (customer_user_phone == '')) {
            $('.CustomerUserPhone').after('<span id="custmererrormsg">Please insert number in Phone number field</span>');
            check = 1;
        } else if (customer_user_password == '') {
            $('.CustomerUserPassword').after('<span id="custmererrormsg">Password field can not be blank</span>');
            check = 1;
        }
        if (check != 1) {
            $.ajax({
                type: "post",
                url: adminAjaxVar,
                data: {
                    action: 'customeraddfunc',
                    'customer_full_name': customer_full_name,
                    'customer_business_name': customer_business_name,
                    'customer_user_email': customer_user_email,
                    'customer_user_mobile': customer_user_mobile,
                    'customer_user_phone': customer_user_phone,
                    'customer_user_password': customer_user_password,
                    'datacusid': datacusid
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    });
    $('.customerNames').click(function() {
        var customerid = $(this).attr('id');
        $('.delete_customer_button').show();
        $('.delete_customer_button').attr('id', customerid);
        $('#save_customer_button').attr('data-cusid', customerid);
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'customershowfunc',
                'customerid': customerid
            },
            success: function(data) {
                data = JSON.parse(data);
                $('.CustomerfullName').val(data['display_name']);
                $('.CustomerBusinessName').val(data['business_name']);
                $('.CustomerUserEmail').val(data['user_email']);
                $('.CustomerUserMobile').val(data['mobile_number']);
                $('.CustomerUserPhone').val(data['phone_number']);
                $('.CustomerUserPassword').val(data['account_password']);
            }
        });
    });
    $('.delete_customer_button').click(function() {
        var deleteuserid = $(this).attr('id');
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'customerdeletefunc',
                'deleteuserid': deleteuserid
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    //inventory product section
    $('#inventoryquantity_button').click(function() {
        var quantityval = $('#inventoryQuantity').val();
        if ((quantityval == '') || (quantityval == 0)) {
            $('.quantity_msg').show();
        } else {
            $('.quantity_msg').hide();
            $.ajax({
                type: "post",
                url: adminAjaxVar,
                data: {
                    action: 'inventoryproductquantityaddfunc',
                    'inventoryquantityno': quantityval
                },
                success: function(data) {
                    $('#inventoryproduct_add_quan').append(data);
                    $('.saveProduct').show();
                    $('#inventoryQuantity').val('');
                }
            });
        }
    });
    $('.inventoryShowBox').click(function() {
        var inventoryProductid = $(this).attr('id');
        $('.inventoryDeleteButton').remove();
        $('.inventorypopColWrap p:nth-child(3), .inventorypopColWrap p:nth-child(4)').remove();
        $('.inventorypopColWrap').append('<p>Quantity<input type="number" value="" name="invenQuan" class="invenquan" />Price<input type="number" value="" name="invenPrice" class="invenprice" />Shipping<input type="number" value="" name="invenShipp" class="invenshipp" /></p>');
        $('#inventorysaveProductButton').after('<a href="javascript:void(0)" class="inventoryDeleteButton" onclick="inventoryDelete(' + inventoryProductid + ')">DELETE PRODUCT</a>');
        $('.saveProduct').show();
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'inventoryproductshowfunc',
                'inventoryProductid': inventoryProductid
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#inventory_img').attr('src', data['inventory_img']);
                $('#inventoryItem').val(data['inventoryItem']);
                $('#inventoryDescription').val(data['inventoryDescription']);
                $('.invenquan').val(data['inventoryQuantity']);
                $('.invenprice').val(data['inventoryPrice']);
                $('.invenshipp').val(data['inventoryShipping']);
            }
        });
    });

    /* checking inventory section start from here */
    $('.inventory_customer').click(function(){
        var inventory_Customer_ID = $(this).attr('id');
        $.ajax({
            type: "post",
            url: adminAjaxVar,
            data: {
                action: 'inventorycustomershowfunc',
                'inventory_Customer_ID': inventory_Customer_ID
            },
            success: function(data) {
                //alert(data);
                // data = JSON.parse(data);
                // $('#CustomerCustomInventory').attr('data-customerID', data[0]);
                // $('#CustomerCustomInventory').val(data[1]);
                // $('#inventoryquantity_button').css({
                //     'display': 'block',
                //     'background-color': '#f07a78',
                //     'color': '#ffffff',
                //     'display': 'table',
                //     'font-size': '14px',
                //     'padding': '10px 20px',
                //     'text-transform': 'uppercase'
                // });
                window.location.reload();
            }
        });
    });
    /* checking inventory section end here */


    //forget password section
    $('.forgetPass').click(function() {
        $('.passwordContainer').fadeIn('slow');
    });
    $('#close_button').click(function() {
        $('.passwordContainer').fadeOut('slow');
    });

    responsivepopup();

    $('#forgetpassSubmit').click(function() {
        var forgetpassEmail = $('#forgetpassEmail').val();
        var forgetpass_mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //email format
        var forgetCheck = 0;
        $('#forgetpassmsg').remove();
        if (!forgetpassEmail.match(forgetpass_mailformat)) {
            $('#forgetpassEmail').after('<span id="forgetpassmsg">Please provide correct mail format</span>');
            forgetCheck = 1;
        }
        if (forgetCheck != 1) {
            $.ajax({
                type: "post",
                url: adminAjaxVar,
                data: {
                    action: 'forgetPasssubmitfunc',
                    'forgetpassEmail': forgetpassEmail
                },
                success: function(data) {
                    $('#forgetpassmsg').remove();
                    if (data == 'The given email id is not registered for administrator') {
                        $('#forgetpassEmail').after('<span id="forgetpassmsg">' + data + '</span>');
                    } else {
                        $('.passReset').text('A password has sent to your mail id');
                        $('.passwordContainer').fadeOut('slow');
                    }
                    //alert(data);
                }
            });
        }
    });
});



function category_errorfunc() {
    //$('#category_errormsg').text('');
    $('#category_errormsg').hide();
}

function responsivepopup() {
    width = $(window).width();
    height = $(window).height();

    leftposition = parseFloat((width * 35) / 100).toFixed(2);
    topposition = parseFloat((height * 50) / 100).toFixed(2);
    width = parseFloat((width * 28) / 100).toFixed(2);
    height = parseFloat((height * 30) / 100).toFixed(2);

    // leftposition = parseInt(width-400);
    $('.passReset').css({
        'width': width + 'px',
        'height': height + 'px',
        'left': leftposition + 'px',
        'top': topposition + 'px'
    });
}