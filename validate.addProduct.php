<?php
require_once("includes/init.php");

$response = array(
    'status' => 0,
    'message' => array("submission"=>'Form Submission Failed'),
    );

    $product=new Product();
    $product_entry=new Product_entry();

    $product_name=$_POST['product_name'];
    $sku=$_POST['sku'];
    $product_price=$_POST['product_price'];
    $product_type=$_POST['product_type'];


if (isset($product_name) && isset($sku) && isset($product_price) && isset($product_type)){
   
    $response['message']=array();

    if (empty($product_name)){
        $response['message']['product_name']="Please enter product name.";
    }

    if (empty($sku)){
        $response['message']['sku']="Please enter product sku.";
    }

    if (empty($product_price)){
        $response['message']['product_price']="Please enter product price.";
    }

    if ($product_type=="all"){
        $response['message']["product_type"]="Please select product type.";
            }else {
                $type_id=Product_type::get_id($product_type);

                $product_attributes=Product_attribute::get_all_type_attributes($type_id);

                foreach ($product_attributes as $attribute) {
                    if (empty($_POST[$attribute->attribute_name])){
                    $response['message'][$attribute->attribute_name]="{$attribute->attribute_name} cannot be empty!";    
                    }
                }

            }


    if (!($response ['message'])){
        $response['status']=1;

        $product=Product::instantiate_product($_POST);
        $product->set_type_code($_POST['product_type']);
          
      if ($product->create()){
        //last inserted id
        $product->id = $database->connection->insert_id;
        $product_entry->set_product_id($product->id);
      }
  
      $added_product_entries=Product_entry::create_product_entries($_POST, $product);
    }


}


    
    echo json_encode($response);


   
    

    
   
