<?php    
    function pr($arr) {
        echo '<pre>';
        print_r($arr);
    } 

    function prx($arr) {
        echo '<pre>';
        print_r($arr);
        die();
    } 

    function get_safe_value($con,$str) {
        if($str != '') {
            $str =trim($str);     //to avoid spaces
            return mysqli_real_escape_string($con,$str);
        }
    }

    function get_pizza($con, $cat) {
        $prod = "SELECT *, products.id as pid FROM products INNER JOIN categories on products.category_id=categories.id where products.status=1 and categories.stat=1 and category_type ='pizza'";
        
        if($cat != '') {
            $prod .= " and category_id =$cat";
        }
        $res = mysqli_query($con,$prod);
        $data = array();
        while($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;  
    }

    function get_cake($con, $cat) {
        $prod = "SELECT *, products.id as pid FROM products INNER JOIN categories on products.category_id=categories.id where products.status=1 and categories.stat=1 and category_type ='cake'";
        
        if($cat != '') {
            $prod .= " and category_id =$cat";
        }
        $res = mysqli_query($con,$prod);
        $data = array();
        while($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
//for cart
    function get_product($con,$pid) {
        $prod = "select * from products where id =$pid";
        $res = mysqli_query($con,$prod);
        $data = array();
        while($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
?>