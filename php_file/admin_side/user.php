<?php 
    require('admin_header.php');

    $type =get_safe_value($con,$_GET['type']);
    $id = get_safe_value( $con,$_GET['id']);
    if($type=='delete') {
        $delete_user = "delete from user_db where id='$id'";
        mysqli_query($con,$delete_user);
    }  

    $user = "select * from user_db order by name asc";
    $res = mysqli_query($con,$user); 
?>
<div class="main">
  <table>
    <tr>
      <th colspan="5" class="center-heading">User Detail</th>
    </tr>
    <tr>
      <th>No.</th>
      <th>ID</th>
      <th>Name</th>
      <th>Email Id</th>
      </tr>
      <?php
        $i=1;
        while($row = mysqli_fetch_assoc($res)) { ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php
              echo "<button class='btn-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></button>&nbsp;";
          ?>
        </td>
      </tr>
      <?php $i++; } ?>
</table>  
</div>