<?php
    require('../connection.php');
    require('../functions.php');
    require('add_to_cart.php');

    $pid = get_safe_value($con, $_POST['pid']);
    $qty = get_safe_value($con, $_POST['qty']);
    $type = get_safe_value($con, $_POST['type']);
    $prod_type = get_safe_value($con,$_POST['prod_type']);

    $obj = new add_to_cart();

    if($type == 'add'){
        $obj->addProduct($pid, $qty,$prod_type);
    }

    if($type == 'update'){
        $obj->updateProduct($pid, $qty);
    }

    if($type == 'remove'){
        $obj->removeProduct($pid);
    }

    echo $obj->totalProduct();
?>