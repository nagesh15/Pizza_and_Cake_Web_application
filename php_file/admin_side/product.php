<?php 
    require('admin_header.php');

    if(isset($_GET['type']) && $_GET['type'] !='') {
      $type =get_safe_value($con,$_GET['type']);
      $id = get_safe_value( $con,$_GET['id']);
      if($type=='status') {
         $operation = get_safe_value($con,$_GET['operation']);
         if($operation=='active') {
            $status = '1';
         } else {
            $status = '0';
         }
         $update_status = "update products set status='$status' where id='$id'";
         mysqli_query($con,$update_status);
      }

      if($type=='delete') {
        $delete_prod = "delete from products where id='$id'";
        mysqli_query($con,$delete_prod);
      }
    }

    $product = "select products.*,categories.category from products,categories where
             products.category_id=categories.id order by products.id asc";
    $res = mysqli_query($con,$product); 
?>
<div class="main">
  <table>
    <tr>
      <th colspan="9" class="center-heading">Products<span class="side"><a href="manage_product.php">Add Product</a></span></th>
    </tr>
    <tr>
      <th>No.</th>
      <th>ID</th>
      <th>Category</th>
      <th>Product</th>
      <th>Image</th>
      <th>MRP</th>
      <th>Price</th>
      <th>Status</th>
      </tr>
      <?php
        $i=1;
        while($row = mysqli_fetch_assoc($res)) { ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><img class="small-img" src="../../media/product-img/<?php echo $row['image']?>"></td>
        <td><?php echo $row['mrp']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td>
          <?php 
              if($row['status']== 1) {
                echo "<button class='btn-active'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></button>&nbsp;";
              } else {
                echo "<button class='btn-deactive'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></button>&nbsp;";
              }
              echo "<button class='btn-edit'><a href='manage_product.php?id=".$row['id']."'>Edit</a></button>&nbsp;";
              echo "<button class='btn-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></button>&nbsp;";
          ?>
        </td>
      </tr>
      <?php $i++; } ?>
</table>  
</div>