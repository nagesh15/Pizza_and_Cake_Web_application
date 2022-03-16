<?php 
    header( "refresh:10;url=order.php" );
    require('admin_header.php');
    $addr='';

    $order = "select * from orders inner join user_db on orders.user_id= user_db.id  order by added_on desc";
    $res = mysqli_query($con,$order);
    
    if(isset($_GET['type']) && $_GET['type']){
      $type = get_safe_value($con,$_GET['type']);
      $oid = get_safe_value($con,$_GET['id']);

      if($type =='accept') {
        $up= mysqli_query($con, "update orders set order_status='success' where o_id='$oid'");
        header("location:order.php");
      }
      if($type =='cancel') {
        $up= mysqli_query($con, "update orders set order_status='Cancelled' where o_id='$oid'");
        header("location:order.php");
      }
    }
    
?>
<div class="main">
  <!-- <div class="sort">Filter : 
    <select name="orderfilter" id="orderfilter" onchange="clickDel()">
      <option>Select</option>
      <option value="success">Successful Order</option>
      <option value="cancelled">Cancelled Order</option>
      <option value="pending">Pending Order</option>
    </select>
  </div> -->
  <table>
    <tr>
      <th colspan="11" class="center-heading">Order Detail</th>
    </tr>
    <tr>
      <th>No.</th>
      <th>Order ID</th>
      <th>User Name</th>
      <th>Address</th>
      <th>Total</th>
      <th>Order Type</th>
      <th>Order Status</th>
      <th>Payment Type</th>
      <th>Payment Status</th>
      <th>Added On</th>
      <th></th>
      </tr>
      <?php
        $i=1;
        while($row = mysqli_fetch_assoc($res)) {
            $addr = $row['address']."\nPincode:".$row['pincode']."\nPhone number:".$row['phone_no'];
     ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['o_id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php
        if($row['order_type']=='delivery'){
          echo '<pre>'.$addr.'</pre>';
        }else {
         echo $row['addr'];
        }?>
        </td>
        <td><?php echo $row['total']; ?></td>
        <td><?php echo $row['order_type']; ?></td>
        <td><?php echo $row['order_status']; ?></td>
        <td><?php echo $row['payment_type']; ?></td>
        <td><?php echo $row['payment_status']; ?></td>
        <td><?php echo $row['added_on']; ?></td>
        <td>
          <button class='btn-active'><a href="order_detail.php?id=<?php echo $row['o_id'];?>">View Detail</a></button>&nbsp;
          <?php if($row['order_status'] == 'pending') { ?>
          <button class='btn-edit'><a href="?type=accept&id=<?php echo $row['o_id']?>">Accept</a></button>&nbsp;
          <button class='btn-delete'><a href="?type=cancel&id=<?php echo $row['o_id']?>">Cancel</a></button>&nbsp;
          <?php } ?>
        </td>
      </tr>
      <?php $i++; } ?>
</table>  
</div>
