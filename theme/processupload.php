<?php
    include_once(substr(dirname(__FILE__), 0, -5).'config.php');
    mysql_connect(DBHOST, DBUSER, DBPASS) or die("Error establishing in Database Connection");
    mysql_select_db(DBNAME) or die('Database is not found');
    require_once(substr(dirname(__FILE__), 0, -5).'include/allFunctions.php');
    $table_prefix = PREFIX;

    if(isset($_POST)) {
        /*$Destination = 'uploads';
        if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name']))     {
            die('Something went wrong with Upload!');
        }
     
        $RandomNum   = rand(0, 9999999999);

        $ImageName      = str_replace(' ','-',strtolower($_FILES['ImageFile']['name']));
        $ImageType      = $_FILES['ImageFile']['type']; //"image/png", image/jpeg etc.
     
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt = str_replace('.','',$ImageExt);
     
        $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
     
        //Create new image name (with random number added).
        $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
     
        move_uploaded_file($_FILES['ImageFile']['tmp_name'], "$Destination/$NewImageName");*/
        if($_POST['formmode'] == 'inserttime'){
            
            $slugName = strtolower( preg_replace("/[\s_]/", "-", $_POST['inventoryname']) );
            $prdctno = postcountbyslug($slugName);
            if( empty($prdctno) ) {
                $slug = $slugName;
            } else {
                $prdctno = $prdctno + 1;
                $slug = $slugName.$prdctno;
              }
            $postExcerpt = substr($_POST['inventorydesc'], 0, 52).'...';
            // var_dump($_POST);
            
            // die();

            $prdct_details_array = array(
                                        'post_author' => $_POST['userlogin'],
                                        'post_date' => date("Y-m-d H:i:s"),
                                        'post_date_gmt' => date("Y-m-d H:i:s"),
                                        'post_content' => $_POST['inventorydesc'],
                                        'post_title' => $_POST['inventoryname'],
                                        'post_excerpt' => $postExcerpt,
                                        'post_status' => 'publish',
                                        'post_name' => $slug,
                                        'post_parent' => $_POST['openprdct'],
                                        'post_type' => 'inventory-product'
                                   );
            add_inventory_product($prdct_details_array); //add inventory product
            $invProduct = get_postbyslug($slug); //post details by slug
            if( empty($_POST['quantity']) ) //quantity
                $qty = 1;
            else
                $qty = $_POST['quantity'];

            $parentProductPrice = get_post_meta($_POST['openprdct'], 'price'); //parent price
            $parentProductShipping = get_post_meta($_POST['openprdct'], 'shipping_cost'); //parent shipping cost

            $images = $_POST['uploadedimg'];
            foreach ($images as $key => $value) {
                $ks = 'post_image_url_'.$key;
                add_post_meta($invProduct->ID, $ks, $value);
            }
            add_post_meta($invProduct->ID, 'qty', $qty);
            add_post_meta($invProduct->ID, 'price', $parentProductPrice);
            add_post_meta($invProduct->ID, 'shipping_cost', $parentProductShipping);

        }else if($_POST['formmode'] == 'updatetime'){
            
            $postExcerpt = substr($_POST['inventorydesc'], 0, 52).'...';
            $postid = $_POST['inventoryID'];
            $my_post = array(
                    'ID'            => $postid,
                    'post_date'     => date("Y-m-d H:i:s"),
                    'post_date_gmt' => date("Y-m-d H:i:s"),
                    'post_content'  => $_POST['inventorydesc'],
                    'post_title'    => $_POST['inventoryname'],
                    'post_excerpt'  => $postExcerpt,
                    'post_status'   => 'publish',
              );
            if( empty($_POST['quantity']) ) //quantity
                $qty = 1;
            else
                $qty = $_POST['quantity'];

            
            if(isset($_POST['uploadedimg'])){
                $images = $_POST['uploadedimg'];
                foreach ($images as $key => $value) {
                    $gnumber = getLastPostImageNo($postid);
                    $number = $gnumber+$key;
                    $meta_key = 'post_image_url_'.$number;
                    add_post_meta($postid, $meta_key, $value);
                }
            }
            $allimages = getPostImage($postid,true);
            if($allimages){
                update_post_meta($_POST['inventoryID'],'qty',$qty);
                wp_update_post( $my_post );
            }else{
                echo 'notupdate';
            }
        }
    }
?>