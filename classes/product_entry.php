<?php 
class Product_entry extends Db_object{
    public $id;
    public $product_id;
    public $attribute_id;
    public $value;

    public static $db_table = "product_entry";
    public static $db_table_fields = array('id','product_id','attribute_id','value');    

    //all product entries for a specific id
    
public static function get_all_by_product_id ($product_id){
    global $database;
    
    $sql="SELECT * FROM product_entry WHERE product_id=".$product_id;
    $result=Product_Entry::find_by_query($sql);
    
    return($result ? $result : false);
}

public static function get_entry_by_attribute_id ($attribute_id){
    global $database;
    
    $sql="SELECT * FROM product_entry WHERE attribute_id=".$attribute_id;
    $result=Product_Entry::find_by_query($sql);
    
    return($result ? array_shift($result) : false);
}

public function set_product_id($id){
    $this->product_id=$id;
}

public static function get_entry_id($product_id, $attribute_id){
    $result=false;
    
        $sql="SELECT * FROM product_entry WHERE $product_id=".$product_id." AND attribute_id=".$attribute_id;
        $result=Product_Entry::find_by_query($sql);

        $entry=array_shift($result);
        
 
 
    return($result ? $entry->id : false);
}

public static function create_product_entries($array_of_post, $product){
    $product_entry=new Product_entry();
    $product_entry->set_product_id($product->id);
    $product_attributes=Product_attribute::get_all_type_attributes($product->type_id);

    $att=new Product_attribute();

    while($att=array_shift($product_attributes)){
    
      foreach ($array_of_post as $property => $value) {
          if ($property==$att->attribute_name){
            $product_entry->attribute_id=$att->id;
            $product_entry->value=$value;
            
                $product_entry->create();
           
            $product_entry=new Product_entry();
            $product_entry->set_product_id($product->id);
          } 
        }
    }


}


public static function update_product_entries($array_of_post, $product){
    echo "in product entries update";
    $product_entry=new Product_entry();
    $product_entry->set_product_id($product->id);

    $product_attributes=Product_attribute::get_all_type_attributes($product->type_id);

    $att=new Product_attribute();

    while($att=array_shift($product_attributes)){
    
      foreach ($array_of_post as $property => $prop_value) {
          if ($property==$att->attribute_name){
            $product_entry->attribute_id=$att->id;
            $product_entry->value=$prop_value;
            
            $product_entry->id=Product_entry::get_entry_id($product_entry->product_id, $product_entry->attribute_id);
            var_dump($product_entry);
            $product_entry->update();
           
            $product_entry=new Product_entry();
            $product_entry->set_product_id($product->id);
          } 
        }
     }



}



}