<?php 
    require('cust_header.php');
    $veg_id=0;
    $nonveg_id = 0;
    $v_name = '';
    $n_name = '';
    $cat_id = '';
    $type ='';

    $veg_pizza = mysqli_query($con,"select * from categories where stat = 1 and category='Veg Pizza'");
    while($row1=mysqli_fetch_assoc($veg_pizza)) {
        $veg_id = $row1['id'];
        $v_name = $row1['category'];
    }

    $nonveg_pizza = mysqli_query($con,"select * from categories where stat = 1 and category='Non-veg Pizza'");
    while($row2=mysqli_fetch_assoc($nonveg_pizza)) {
        $nonveg_id = $row2['id'];
        $n_name = $row2['category'];
    }

    $pizza = mysqli_query($con,"select * from categories where stat = 1 and type= 'pizza'");
    $check = mysqli_num_rows($pizza);
    if($check>0){
        $type='pizza';
    }

    if(isset($_GET['id']) && $_GET['id'] !='') {
        $cat_id = get_safe_value( $con,$_GET['id']);
    }

    $get_prod = get_pizza($con, $cat_id,$type);

?>

<?php
    echo "<div class='toggle-button'>";
    echo "<a class='btn-veg' href='?&id=".$veg_id."'>Veg Pizza</a>";
    echo "<a class='btn-nonveg' href='?&id=".$nonveg_id."'>Non-Veg Pizza</a>";
    echo "</div>";
?>
<?php

    if(count($get_prod)) {
?>
<div class="product">
<?php 
    $i=1;
    foreach($get_prod as $list) {
        $prod_type = $list['type'];
?>

        <div class="card">
            <h1 class="product-name"><?php echo $list['product_name']; ?></h1>
            <div class="prod-flex">
                <img src="../../media/product-img/<?php echo $list['image']?>" class="prod-img">
                <div class="flex-col">
                    <p class="prod-desc"><?php echo $list['description'];?></p>
                    <h1><span class="mrp"><?php echo $list['mrp'];?></span><span class="price"><?php echo $list['price']; ?></span></h1>
                    <span class="prod-desc">Qty:</span>
                    <select name="qty" class="qty-drop" id="<?php echo 'qty'.$i; ?>">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>

                    </select>
                    <!-- javascript:void(0) is used to stay in the same page -->
                    <a href="javascript:void(0)"><button class="cart-button" onclick="manage_cart('<?php echo $list['pid']; ?>','<?php echo 'qty'.$i; ?>','add','<?php echo $prod_type; ?>')">Add to Cart</button></a>
                </div>
            </div>
        </div>  

<?php 
    $i += 1;
} ?>
</div> 
<?php } else {
    echo "<h1 class='noprod'>Sorry No Food available</h1>";
}
?>