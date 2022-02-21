<?php
require_once 'includes/init.php';

   
    global $database;
    $types=Product_type::find_all();

?>

<?php require_once('includes/header.php');?>
<div class="page-body">
  <div class="container">
    <div class="subnav">
        <div class="subnav-title">Add Product</div>
        <div class="subnav-buttons">
              
            <form method="post" action="" target="" enctype="multipart/form-data">
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
                      
                      <form id="product_form" method="post" action="" role="form" enctype="multipart/form-data">
                                <div class="row">
                                      <div id ="error" class="col-md-12 alert alert-danger d-none"> </div>
                                </div>
                            <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group"><label for="sku">Product SKU:</label>
                                            <input class="form-control" id="sku" name="sku" type="text" placeholder="SKU">
                                            <div id ="error_sku" class="col-md-12 d-none"> </div>
                                        </div>
                                      </div>
                                  </div>
                            <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group"><label for="product_name">Product Name:</label>
                                        <input class="form-control" id="name" name="product_name" type="text" placeholder="Name">
                                        <div id ="error_product_name" class="col-md-12 d-none"> </div>
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
                                          <input type="text" id="price" placeholder="Price" class="form-control" name="product_price" aria-label="Amount (to the nearest dollar)">
                                          <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                          </div>
                                        </div>
                                        <div id ="error_product_price" class="col-md-12 d-none"> </div>
                                  </div>
                              </div>
                              </div>


                      
                            <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group"><label for="product_type">Select product type:</label> 
                                  <select id="product_type" name="product_type" class="form-control">

                                      <?php foreach ($types as $type): ?>
                                          
                                          <option name="<?php echo $type->tname; ?>" value="<?php echo $type->tname; ?>"><?php echo ucfirst($type->tname); ?></option>
                                     
                                      <?php endforeach; ?>
                                        
                                      <option value="all" selected>All</option>
                                  </select>
                                </div>
                              </div>
                          </div>





                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <?php 
                                    
                                    foreach ($types as $type): ?>
 
                                      <div id="<?php echo $type->tname; ?>">
                                      
                                        <?php 
                                          $type_attributes=Product_attribute::get_all_type_attributes($type->id); 
                                          foreach ($type_attributes as $attribute): 
                                          ?>
                                          
                                          <label for="<?php echo $attribute->attribute_name;?>"><?php echo ucfirst($attribute->attribute_name); ?>(<?php echo $attribute->um; ?>)
                                            <p>Please, provide <?php echo $attribute->attribute_name;?></p>
                                          <input class="form-control" id="<?php echo $attribute->attribute_name; ?>" name="<?php echo $attribute->attribute_name; ?>" type="text" placeholder="" value="">
                                          <div id ="error_".<?php echo $attribute->attribute_name; ?> class="col-md-12 d-none"> </div>      
                                          <br>         
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





<script type="text/javascript">
  $(document).ready(function(){
    $('#product_form').on ('submit',  function(e){
      e.preventDefault();
      //alert("Button was submitted");
      //let $error=$('#error');

      $.ajax({
        type:'POST',
        url: 'validate.addProduct.php',
        data: new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
      }).then(function(response){
        let data = response;

        if (data.status==0){
          // alert(data['message']);
          $messages=data['message'];
          for (var [key, value] of Object.entries($messages)) {
            console.log(`${key}: ${value}`);
            
           
            $('input[name$='+key+']').addClass('input-error');
            $('select[name$='+key+']').addClass('input-error');

            $('#error_'+key).removeClass('d-none').html(value).addClass('error');
            
            // $('input[name$="product_name"]').addClass('input-error');
          }


          // $('#error').removeClass(d-none).html(data['message']);
          return;
        }         
        location.href='index.php';
      }).fail(function(res){
        $('#error').removeClass('d-none').html('Error');
      })
    })
  })
  </script> 


</body>
</html>