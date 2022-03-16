<?php
    require("cust_header.php");
    if($_SESSION['USER_LOGIN'] != 'yes'){
        header('location:../login.php');
        die();
    }


    $sub =0;
    $total =0;
    $ship =0;
    $msg="";

    if(count($_SESSION['cart'])>0) {
        foreach($_SESSION['cart'] as $key => $val){ 
            $get_prod = get_product($con,$key);
            $qty = $val['qty'];
            $price = $get_prod[0]['price'];
            $sub += $price*$qty;
        }
        $ship = 20;
        $total = $sub + $ship;

        // to get user address from user-db
        $userid = $_SESSION['USER_ID'];
        $user = mysqli_query($con,"select * from user_db where id='$userid'");
        while($row=mysqli_fetch_assoc($user)) {
            $address = $row['name']."\n".$row['address']."\nPincode:".$row['pincode']."\nPhone number:".$row['phone_no'];
        }

    }else {
        header('location:cart.php');
        die();
    }


    if(isset($_POST['continue'])) {
        $userid = $_SESSION['USER_ID'];
        $pay_type = get_safe_value($con,$_POST['pay_method']);
        $order_type = get_safe_value($con,$_POST['order_type']);
        $shop = get_safe_value($con,$_POST['address']);
        //to store address
        if($shop=='manipal') {
            $address="NS SHOP,Manipal Branch";
        } else if($shop=='udupi') {
            $address="NS SHOP,Udupi Branch";
        } else {
            $a = mysqli_query($con,"select address from user_db where id='$userid'");
            while($list=mysqli_fetch_assoc($a)){
                $address = $list['address'];
            }
        }

        if($pay_type=='COD') {
            $payment_stat = 'pending';
        } else {
            $payment_stat = 'success';
        }
        $order_stat = 'pending';
        date_default_timezone_set('Asia/Kolkata');
        $added_on = date('Y-m-d H:i:s');
        
        $order = mysqli_query($con,"insert into orders (user_id,addr,total,order_type,payment_type,payment_status,order_status,added_on) 
                                   values ('$userid','$address','$total','$order_type','$pay_type','$payment_stat','$order_stat','$added_on')"); 

        // adding products into order detail

        $order_id = mysqli_insert_id($con);

        foreach($_SESSION['cart'] as $key => $val){ 
            $get_prod = get_product($con,$key);
            $qty = $val['qty'];
            $price = $get_prod[0]['price'];
            
            $order_detail = mysqli_query($con,"insert into orders_detail (order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");

        }

        $_SESSION['cart'] = array();
        header('location:thank_you.php');
        
    }
    
?>
<div id="thank-you">
<form method="post" class="order">
<div class="order">
    <div class="order-cont">
        <div class="order-left">
            <div class="order-type">
                <h1>Order Type</h1>
                <select name="order_type" id="otype" onchange="clickDel()" required>
                    <option value="">Select Order Type</option>
                    <?php 
                        if(isset($_GET['oty'])) {
                            $otype = get_safe_value($con,$_GET['oty']);
                        if($otype=='del'){
                            echo '<option value="delivery" selected>Delivery</option>
                                  <option value="takeaway">Takeaway</option>';
                        } else {
                            echo '<option value="delivery">Delivery</option>
                                  <option value="takeaway" selected>Takeaway</option>';
                        } }else {
                            echo '<option value="delivery">Delivery</option>
                                  <option value="takeaway">Takeaway</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="address-detail">
                <h1>Address Details</h1>
                
                <?php 
                    if(isset($_GET['oty'])) {
                        $otype = get_safe_value($con,$_GET['oty']);
                    if($otype=='del'){
                ?>
                    <div id="user_address">
                        <div class="add">
                            <label>Address :</label><br>
                            <textarea name="address" id="address" cols="30" rows="5" placeholder="Enter Address" required readonly><?php echo $address;?></textarea>
                        </div>
                        <div class="edit">
                            <a href="account.php?type=userdetail" class="edit">Edit</a>
                        </div>
                    </div>
                    <?php }else { ?>
                    <div class="pay-input">
                        <div>
                            <input type="radio" name="address" value="manipal" required>NS SHOP <br> Manipal branch 
                        </div>
                        <div>
                            <input type="radio" name="address" value="udupi" >NS SHOP <br> Udupi branch 
                        </div>
                    </div> 
                    <?php } } ?>                   
            </div>
            <div class="payment">
                <h1>Payment </h1>
                <div class="pay-input">
                    <div>
                        <input type="radio" name="pay_method" value="COD" required>COD 
                    </div>
                    <div>
                        <input type="radio" name="pay_method" value="UPI" disabled>Other payment method 
                    </div>
                </div>
            </div>
        </div>
        <div class="order-right">
            <div class="product-total">
                <h1 class="title">Order Summary</h1>
                <div class="summary">
                <h1>Subtotal : </h1>
                <h1>₹<?php echo $sub; ?> </h1>
                <h1>Extra Charge :</h1>
                <h1>₹<?php echo $ship; ?></h1>
                <h1>Total :</h1>
                <h1>₹<?php echo $total; ?></h1>
                </div>
            </div>
            <input type="submit" name="continue" class="cont">
        </div>
    </div>
</div>
</form>
</div>
