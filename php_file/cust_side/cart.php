<?php 
    require('cust_header.php');
    $sub = 0;
    $ship_charge = 20;
    $total = 0;
    $i=1;

?>
<div class="cart-section">
        <?php 
         if(isset($_SESSION['cart'])) {
            if(count($_SESSION['cart'])) {
        ?>
            <table class="cart">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php 
                    foreach($_SESSION['cart'] as $key => $val){ 
                        $get_prod = get_product($con,$key);
                        $pname = $get_prod[0]['product_name'];
                        $price = (float)$get_prod[0]['price'];
                        $image = $get_prod[0]['image'];
                        $qty = (float)$val['qty'];
                        $type= $val['type'];
                        $sub += $price*$qty;
                ?>
                    <tr id="cart1">
                        <td>
                            <div class="cart-prod-info">
                                <img src="../../media/product-img/<?php echo $image;?>" class="small-img">
                                <div class="prod-info">
                                    <h1><?php echo $pname;?></h1>
                                    <p>Product Price : ₹<span id="price1"><?php echo $price?></span></p>
                                </div>    
                            </div>
                        </td>
                        <td>
                        <?php if($type=='cake') {?>
                            <div class="qty-change">
                                <button onclick="decrementNum('<?php echo 'qty'.$i; ?>'); 
                                        manage_cart('<?php echo $key ?>','<?php echo 'qty'.$i; ?>','update','<?php echo $type ?>')">
                                        <i class="fa fa-minus"></i>
                                </button>

                                <input type="text" name="qty" value="<?php echo $qty;?>kg" id="<?php echo 'qty'.$i; ?>" readonly>

                                <button onclick="incrementNum('<?php echo 'qty'.$i; ?>');
                                        manage_cart('<?php echo $key ?>','<?php echo 'qty'.$i; ?>','update','<?php echo $type ?>')">
                                        <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        <?php } elseif($type=='pizza') {?>
                            <div class="qty-change">
                                <button onclick="decrementNum('<?php echo 'qty'.$i; ?>'); 
                                        manage_cart('<?php echo $key ?>','<?php echo 'qty'.$i; ?>','update','<?php echo $type ?>')">
                                        <i class="fa fa-minus"></i>
                                </button>

                                <input type="text" name="qty" value="<?php echo $qty;?>" id="<?php echo 'qty'.$i; ?>" readonly>

                                <button onclick="incrementNum('<?php echo 'qty'.$i; ?>');
                                        manage_cart('<?php echo $key ?>','<?php echo 'qty'.$i; ?>','update','<?php echo $type ?>')">
                                        <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <?php } ?>
                        </td>
                        <td>₹<span id="itemprice1"><?php echo $price*$qty; ?></span></td>
                        <td>
                            <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','<?php echo 'qty'.$i; ?>','remove','<?php echo $type ?>')">
                                <i class="fa fa-trash" style="font-size: 24px;"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                    $i += 1;
                }
                $total = $sub + $ship_charge;
                ?>
            </table>
            <div class="total-price">
                <table>
                    <tr>
                        <td>Subtotal :</td>
                        <td>₹<span id="subtotal"><?php echo $sub ?></span></td>
                        <td>&emsp;&emsp;&emsp;</td>
                    </tr>
                    <tr>
                        <td>Extra charge :</td>
                        <td>₹<span id="shipcharge"><?php echo $ship_charge;?></span></td>
                    </tr>
                    <tr>
                        <td>Total :</td>
                        <td>₹<span id="totalamt"><?php echo $total ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="3" ><a href="order.php"><button class="order-button">Order Now</button></a></td>
                    </tr>
                </table>
            </div>
            <?php } else {
                     echo "<h1 class='noprod'>No food in the cart<br> <a href='home.php' class='link'>Click here to add food to the cart</a></h1>";
                  } 
                } else {
                    echo "<h1 class='noprod'>No food in the cart<br> <a href='home.php' class='link'>Click here to add food to the cart</a></h1>";
                 }  
            ?>
</div>


<script>
var subtotal = document.getElementById('subtotal');
var shipcharge = document.getElementById('shipcharge');
var totalamt = document.getElementById('totalamt');

</script>