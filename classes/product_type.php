<?php 

class Product_type extends Db_object{
    
    public $id;
    public $tname;
    
    public static $db_table = "product_types";
    public static $db_table_fields = array('id','tname');    

    
    

    public static function find_by_name($typename){
        global $database;
        $sql="SELECT * FROM product_types WHERE tname='".$typename."' LIMIT 1";
        
        $result=Product_type::find_by_query($sql);
        
        return($result ? $result : false);
    }

    public static function get_id($typename){
        $type_array=Product_type::find_by_name($typename);
        $type=array_shift($type_array);

        return($type ? $type->id : false);
    }

    

    
}