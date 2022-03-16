<?php
    require('admin_header.php');

    $uid = $_SESSION['USER_ID'];
    $order_id = get_safe_value($con,$_GET['id']);
    $total =0;
    $ship= 20;

    $order = mysqli_query($con, "select DISTINCT orders_detail.*, products.product_name from orders_detail,products,orders
    where orders_detail.order_id = '$order_id' and orders.user_id='$uid' AND products.id = orders_detail.product_id");
?>
<style>
.space {
    margin: 100px;
}
</style>

<div class="space"></div>
<div class="order">
<a href="order.php"><button class="back-btn"> < </button></a>
    <table>
        <tr>
            <th colspan="5" class="center-heading">Order detail</th>
        </tr>
        <tr>
            <th>Order Id</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total Price</th>
        </tr>
        <?php
        while($row= mysqli_fetch_assoc($order)){
        ?>
        <tr>
            <td><?php echo $order_id?></td>
            <td><?php echo $row['product_name'];?></td>
            <td><?php echo $row['qty'];?></td>
            <td>₹<?php echo $row['price'];?></td>
            <td>₹<?php echo $row['price'] * $row['qty'];?></td>
        </tr>
    <?php
            $total += $row['price'] * $row['qty'];
        }
    ?>
        <tr>
            <td colspan="4" style="font-weight: bold; text-align: right;">Total price</td>
            <td style="font-weight: bold;">₹<?php echo $total;?></td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold; text-align: right;">Extra Charge</td>
            <td style="font-weight: bold;">₹<?php echo $ship;?></td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold; text-align: right;">Total Amount</td>
            <td style="font-weight: bold;">₹<?php echo $total + $ship;?></td>
        </tr>
    </table>
</div>

