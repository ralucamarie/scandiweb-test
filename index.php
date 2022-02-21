<?php
session_start();
require_once 'includes/init.php';
?>




<?php require_once('includes/header.php');
$products=Product::find_all();

if (isset($_POST['btnMassDelete'])){
  foreach ($_POST as $key => $value) {
    echo $key."-> ".$value;
    if ( is_numeric($key)){
      if($selected_product=Product::find_by_id($key)){
        // echo "<br> $selected_product->product_name";
        $selected_product->delete_entries();
        $selected_product->delete();
        redirect('index.php');
      }
    }

    
  }
}


?>

<div class="page-body">


<form method="post" action="" target="" enctype="multipart/form-data">
<div class="container">
    <div class="subnav">
        <div class="subnav-title">Products</div>
        <div class="subnav-buttons">
            <div class="form-group">
            <button type="button"  name=btnAdd class="btn btn-outline-success my-2 my-sm-0"><a href="add-product.php">ADD PRODUCT</a></button>
                <input type="submit" id="delete-product-btn" name="btnMassDelete" class="btn btn-outline-success my-2 my-sm-0" value="DELETE SELECTED">
            </div>
            
              
         </div>
    </div>
</div>

    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

        <?php foreach ($products as $product):?> 
          <div class="col mb-4">
            <div class="card" >
               <img src="https://dummyimage.com/600x400/c7c7c7/0d0d0d" class="card-img-top" alt="..."> 
                <div class="card-body">
                    
                    <div class="container">
                      <input class="delete-checkbox d-block" type="checkbox" id="checkboxNoLabel" name= "<?php echo $product->id ?>" value="" aria-label="...">
                    </div>
                      
                      <h5 class="card-title text-center text-capitalize"><?php echo $product->product_name; ?></h5>
                      
                        
                      <?php  
                        $product_entries=Product_entry::get_all_by_product_id($product->id);

                        foreach ($product_entries as $product_entry): ?>
                            <?php $attribute=Product_attribute::find_by_id($product_entry->attribute_id); ?>
                            <h6 class="card-subtitle mb-2 text-center text-capitalize"><?php echo $attribute->attribute_name.": ".$product_entry->value."<br>"; ?></h6>

                      <?php endforeach ?>
                      <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                      <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                      <p class=" text-center"><a href="edit_product.php?id=<?php echo $product->id ?>" class="card-link">edit</a></p>
                

                </div> 
            </div>
          </div>

          <?php endforeach ?>
        
        
        
        
        
            
      </div> 
    </div>


    </form>
</div>
<!-- end page body -->
 

  
      
  
 


</body>
</html>