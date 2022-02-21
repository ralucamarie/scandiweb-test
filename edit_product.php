<?php
require_once 'includes/init.php';

  if (isset($_GET['id'])) {
     $id=$_GET['id'];
     $product=Product::find_by_id($id);
     $product_name=$product->product_name;
     $sku=$product->sku;
     $product_price=$product->product_price;
     $type_id=$product->type_id;

     $product_entries=Product_entry::get_all_by_product_id($id);
     while($entry=array_shift($product_entries)) {
     }

     $type=Product_type::find_by_id($type_id);
     $types=Product_type::find_all();


     $type_attributes=Product_attribute::get_all_type_attributes($type_id);
     

     if (isset ($_POST['btnSave'])){
      //TODO: validate fields
      var_dump($_POST);
      $product_entry=new Product_entry();
      global $database;
      
      $product_to_update=Product::instantiate_product($_POST);
      $product_to_update->id=$id;
      $product_to_update->type_id=$type_id;

      

      if ($product->update_product($product_to_update)){
        
        $product_entry->set_product_id($product->id);

      }
  
      $added_product_entries=Product_entry::update_product_entries($_POST, $product);


      // redirect("index.php");
    }




    } else {
      echo "smth wrong, id not sent";
    }


    
    
  

?>

<?php require_once('includes/header.php'); ?>


<div class="page-body">
  <div class="container">
    <div class="subnav">
        <div class="subnav-title">Edit Product</div>
        <div class="subnav-buttons">
              
            <form method="" action="" target="" enctype="multipart/form-data">
                <button type="button" name=cancel class="btn btn-outline-success my-2 my-sm-0"><a href="index.php">CANCEL</a></button>
            </form>
         </div>
    </div>
  </div>

    <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  
                  <div class="card-body">
                      
                      <form id="submit-form" method="post" action="" role="form">
                                <div class="row">
                                      <div id ="error" class="col-md-12 alert alert-danger d-none"> </div>
                                </div>
                            <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group"><label for="product_sku">Product SKU:</label>
                                            <input class="form-control" name="product_sku" type="text" placeholder="" value="<?php echo $sku ?>" disabled>

                                        </div>
                                      </div>
                                  </div>
                            <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group"><label for="product_name">Product Name:</label>
                                        <input class="form-control" name="product_name" type="text" placeholder="" value="<?php echo $product_name ?>">
                                    </div>
                                  </div>
                              </div>
                      
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group"><label for="product_price">Product Price:</label>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                          </div>
                                          <input type="text" placeholder="" class="form-control" name="product_price" aria-label="Amount (to the nearest dollar)" value="<?php echo $product_price ?>">
                                          <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                          </div>
                                        </div>
                                  </div>
                              </div>
                              </div>

                      
                            <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group"><label for="product_type">Select product type:</label> 
                                  <select id="product_type" name="product_type" class="form-control" disabled>
                                          <option value="<?php echo $type->tname; ?>" selected><?php echo ucfirst($type->tname); ?></option>
                                  
                                  </select>
                                </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <?php foreach ($types as $type): ?>
 
                                      <div id="<?php echo $type->tname; ?>">
                                        <?php $attributes=Product_attribute::get_all_type_attributes($type->id); 
                                        foreach ($type_attributes as $attribute): ?>
                                        
                                          <!-- echo $attribute->attribute_name; -->
                                          <label for="<?php echo $attribute->attribute_name;?>"><?php echo ucfirst($attribute->attribute_name); ?>(<?php echo $attribute->um; ?>)

                                          <input class="form-control" id="<?php echo $attribute->attribute_name;?>" name="<?php echo $attribute->attribute_name;?>" type="text" placeholder="" value="<?php 
                                           $entry=Product_entry::get_entry_by_attribute_id($attribute->id); 
                                            echo $entry->value;
                                          ?>">
                                        
                                          <?php endforeach ?>

                                      </div>

                                    <?php endforeach  ?>

                                  </div>
                              </div>
                          </div>

                          <div class="row">
                          <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="submit" name="btnSave" class="btn btn-outline-success my-2 my-sm-0">
                                  </div>
                              </div>                          
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function () {
    toggleInput();
    $("#product_type").change(function () {
        toggleInput();
    });
});

function toggleInput() {
    if ($("#product_type").val() === "dvd-disc") {
        $("#dvd-disc").show();
    } else {
        $("#dvd-disc").hide();
    }
    if ($("#product_type").val() === "book") {
        $("#book").show();
    } else {
        $("#book").hide();
    }
    if ($("#product_type").val() === "furniture") {
        $("#furniture").show();
    } else {
        $("#furniture").hide();
    }
    
}
</script>




</body>
</html>