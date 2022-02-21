<?php 
class Product_attribute extends Db_object{
    
    public $id;
    public $attribute_name;
    public $um;
    
    public static $db_table = "attributes";
    public static $db_table_fields = array('id','attribute_name','um');    



    
    public static function find_by_name($name){
        global $database;
        $sql="SELECT * FROM attributes WHERE attribute_name='".$name."' LIMIT 1";
        //echo $sql;
        $result_array=Product_entry::find_by_query($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function get_all_type_attributes ($searched_id){
        global $database;
        $sql="SELECT attribute_id as id, attribute_name, um FROM type_property T INNER JOIN attributes A where T.attribute_id=A.id AND T.type_id=".$searched_id;
        
        $result=Product_attribute::find_by_query($sql);
        
        return($result ? $result : false);

    }

}