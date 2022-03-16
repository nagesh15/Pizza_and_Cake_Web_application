<?php
    require('cust_header.php');

    $type='';
    $name='';
    $add = '';
    $pin ='';
    $pno='';
    $opration='';
    $msg='';

    $uid = $_SESSION['USER_ID'];
//this is checking for which button user clicked on
    if(isset($_GET['type']) && $_GET['type'] !='') {
        $type = get_safe_value($con,$_GET['type']);
    }

    //cancel is clicked in myorder 
    if(isset($_GET['oper']) && $_GET['oper'] !='') {
        $oper = get_safe_value($con,$_GET['oper']);
        $oid = get_safe_value($con,$_GET['id']);
        if($oper =='cancel') {
            $up= mysqli_query($con, "update orders set order_status='Cancelled' where o_id='$oid'");
        }
    }

//this is for submit button for user edit
    if(isset($_POST['submit'])){
        $uid = $_SESSION['USER_ID'];
        $na = get_safe_value($con,$_POST['name']);
        $address = get_safe_value($con,$_POST['addr']);
        $pin = get_safe_value($con,$_POST['pin']);
        $pno = get_safe_value($con,$_POST['pno']);

        $update = mysqli_query($con,"update user_db set name='$na', address='$address', pincode='$pin', phone_no='$pno' where id='$uid'");
        header('location:?type=userdetail');
    }

?>
<?php
    echo "<div class='toggle-button'>";
    echo "<a class='btn-acc' href='?type=myorder'>My Order</a>";
    echo "<a class='btn-acc' href='?type=userdetail'>My Details</a>";
    echo "</div>";
?>

<?php 
if($type=='myorder') {

    $order = mysqli_query($con, "select * from orders where user_id = '$uid'");
    $check = mysqli_num_rows($order);
    $user = mysqli_query($con,"SELECT name, address, pincode, phone_no FROM user_db where id= '$uid'");

    while($list= mysqli_fetch_assoc($user)){
        $addr = $list['name']."\n".$list['address']."\nPincode:".$list['pincode']."\nPhone number:".$list['phone_no']; 
    }

    if($check > 0){
    ?>

    <div class="order">
            <table>
            <tr>
                <th colspan="8" class="center-heading">My orders</th>
            </tr>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Address</th>
                <th>Order Type</th>
                <th>Payment Type</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th></th>
            </tr>
<?php
    while($row= mysqli_fetch_assoc($order)){
?>
    <tr>
        <td><?php echo $row['o_id'];?></td>
        <td><?php echo $row['added_on'];?></td>
        <td><?php
        if($row['order_type']=='delivery'){
          echo '<pre>'.$addr.'</pre>';
        }else {
         echo $row['addr'].'<br><br><br>';
        }?>
        </td>
        <td><?php echo $row['order_type'];?></td>
        <td><?php echo $row['payment_type'];?></td>
        <td><?php echo $row['payment_status'];?></td>
        <td><?php echo $row['order_status'];?></td>
        <td><a class='btn-edit' href="myorder_detail.php?id=<?php echo $row['o_id'];?>">View Detail</a> &nbsp;
        <?php if($row['order_status'] =='pending') { ?>
            <a class='btn-delete' href="?type=myorder&oper=cancel&id=<?php echo $row['o_id'];?>">Cancel</a>
        <?php } ?>
        </td>
    </tr>
<?php
    } 
    echo '</table></div>';
}else {
    echo "<h1 class='noprod'>No Order Made from you</h1>";
}
    
} elseif ($type =='userdetail') {   //if user detail button is clicked

    $uid = $_SESSION['USER_ID'];
    $user = mysqli_query($con,"SELECT name, address, pincode, phone_no FROM user_db where id= '$uid'");
    while($row= mysqli_fetch_assoc($user)){
    ?>
    <div class="edit_detail">
        <div>Name : <?php echo $row['name'];?></div>
        <div>Address : <?php echo $row['address'];?></div> 
        <div>Pincode : <?php echo $row['pincode'];?></div>
        <div>Phone number : <?php echo $row['phone_no'];?></div> 
        <div><a href="?type=userdetail&op=edit">Edit</a></div>       
    </div>
    

    <?php } 
//editing user detail
    if(isset($_GET['op']) && $_GET['op'] != ''){
        $op=get_safe_value($con, $_GET['op']);

        if($op=='edit') { 
        $edit = mysqli_query($con,"SELECT name, address, pincode, phone_no FROM user_db where id= '$uid'");
        while($list= mysqli_fetch_assoc($edit)){        
    ?>  
            <div class="box">
            <form method="POST">
                <label>Name</label><br>
                <input class="form-input" type="text" name="name" placeholder="Enter name" pattern="[a-zA-Z\s]{,25}" title="Enter correct name eg.John Smith" required value="<?php echo $list['name']; ?>"><br>
                <label>Address</label><br>
                <textarea class="form-input" row="5" name="addr" placeholder="Enter Address" required><?php echo $list['address']; ?></textarea><br>
                <label>Pincode</label><br>
                <input class="form-input" type="text" name="pin" placeholder="Enter pincode" pattern="[5]{1}[6-9]{1}[0-9]{4}" title="Enter correct Pincode" required value="<?php echo $list['pincode']; ?>"><br>
                <label>Phone Number</label><br>
                <input class="form-input" type="text" name="pno" placeholder="Enter phone number" pattern="[6-9]{1}[0-9]{9}" title="Enter correct phone number eg.9876543210" required value="<?php echo $list['phone_no']; ?>"><br>        
                <button class="sub-button" name="submit" type="submit">Submit</button>
                <div class="error-msg">
                    <?php echo $msg; ?>
                </div>
            </form>
            </div>

       <?php }
       }
    }
}
?>