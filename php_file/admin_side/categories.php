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
         $update_status = "update categories set stat='$status' where id='$id'";
         mysqli_query($con,$update_status);
      }
    }

    $cat = "select * from categories order by category asc";
    $res = mysqli_query($con,$cat); 
?>9
<div class="main">
  <table>
    <tr>
      <th colspan="5" class="center-heading">Category</th>
    </tr>
    <tr>
      <th>No.</th>
      <th>ID</th>
      <th>Category</th>
      <th>Category type</th>
      <th>Status</th>
      </tr>
      <?php
        $i=1;
        while($row = mysqli_fetch_assoc($res)) { ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['type']; ?></td>
        <td>
          <?php 
              if($row['stat']== 1) {
                echo "<button class='btn-active'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></button>&nbsp;";
              } else {
                echo "<button class='btn-deactive'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></button>&nbsp;";
              }
          ?>
        </td>
      </tr>
      <?php $i++; } ?>
</table>  
</div>