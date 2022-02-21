<?php 
class Product extends Db_object{
    public $id;
    public $product_name;
    public $sku;
    public $product_price;
    public $type_id;
    public $product_attributes=array();

    protected static $db_table = "products";
    protected static $db_table_fields = array('id','product_name','sku','product_price','type_id');    

    

    public static function instantiate_product($array_of_post){
        $product=new Product();
        foreach ($array_of_post as $property => $value) {
            if (property_exists($product, $property)){
              $product->$property=$value;
            } 
          }
          return $product;
    }

    public function set_type_code($type_name){
      $ptype=Product_type::find_by_name($type_name);

      if ($ptype){
          $this->type_id = $ptype[0]->id;
        }

    }

    public function update_product($new_product){
         $this->product_name=$new_product->product_name;
         //$this->sku=$new_product->sku;
         $this->product_price=$new_product->product_price;
         //$this->type_id=$new_product->type_id;
         $this->update();
    }


public function delete_entries(){

  $product_entries=Product_entry::get_all_by_product_id ($this->id);
  foreach ($product_entries as $entry) {
    $entry->delete();
  }

}


}