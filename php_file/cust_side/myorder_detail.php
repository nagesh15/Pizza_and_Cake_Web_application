<?php
    require('cust_header.php');

    $uid = $_SESSION['USER_ID'];
    $order_id = get_safe_value($con,$_GET['id']);
    $total =0;
    $ship= 20;

    $order = mysqli_query($con, "SELECT * FROM orders_detail INNER JOIN products on orders_detail.product_id = products.id WHERE order_id='$order_id'");
?>

<div class="order">
    <a href="account.php?type=myorder"><button class="back-btn"> < </button></a>
    <table>
        <tr>
            <th colspan="5" class="center-heading">My orders</th>
        </tr>
        <tr>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total Price</th>
        </tr>
        <?php
        while($row= mysqli_fetch_assoc($order)){
        ?>
        <tr>
            <td><img class="small-img" src="../../media/product-img/<?php echo $row['image']?>"></td>
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
            <td colspan="4" style="font-weight: bold; text-align: right;">Extra Charge</td>
            <td style="font-weight: bold;">₹<?php echo $ship;?></td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold; text-align: right;">Total Price</td>
            <td style="font-weight: bold;">₹<?php echo $total + $ship;?></td>
        </tr>
    </table>
</div>