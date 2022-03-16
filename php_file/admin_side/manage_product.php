<?php 
    require('admin_header.php');
    $cat_id='';
    $cat_type='';
    $product ='';
    $image='';
    $mrp='';
    $price='';
    $desc='';
    $msg='';
    $required = 'required';

    if(isset($_GET['id']) && $_GET['id']!= '') {
        $required='';//to avoid requires=d validation during edit
        $id = get_safe_value($con, $_GET['id']);
        $select_prod = "select * from products where id='$id'";
        $res = mysqli_query($con, $select_prod);
        $check = mysqli_num_rows($res);
        if($check>0){
            $row = mysqli_fetch_assoc($res);
            $cat_id = $row['category_id'];
            $cat_type= $row['category_type'];
            $product = $row['product_name'];
            $mrp = $row['mrp'];
            $price = $row['price'];  
            $desc = $row['description'];
        } else {
            //if no rows exists redirect to category
            header('location:product.php');
            die();
        }
    }

    if(isset($_POST['submit'])) {
        $cat_id = get_safe_value($con, $_POST['category_id']);
        $cat_type = get_safe_value($con,$_POST['cat_type']);
        $product = get_safe_value($con, $_POST['product']);
        $mrp = get_safe_value($con, $_POST['mrp']);
        $price = get_safe_value($con, $_POST['price']);
        $desc = get_safe_value($con, $_POST['desc']);

        //to check if category already exist during add category
        $select_cat = "select * from products where product_name='$product'";
        $res = mysqli_query($con, $select_cat);
        $check = mysqli_num_rows($res);
        
        if($check>0){
            //if the same name given during edit process
            if(isset($_GET['id']) && $_GET['id']!= '') {
                $id_exist = mysqli_fetch_assoc($res);
                if($id!=$id_exist['id']){
                    $msg= "Product already exists";
                }
            }else {
                $msg= "Product already exists";
            }
        }

        //to accept only png,jpg, jpeg format image
        if($_FILES['image']['type'] !='' && $_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg'&&
        $_FILES['image']['type']!='image/jpeg' ){
                $msg="Please enter only png,jpg or jpeg image format";
        }

        if($msg=='') {
            //editing product
            if(isset($_GET['id']) && $_GET['id']!= '') {
                if($_FILES['image']['name'] == '') {
                    $update_prod = "update products set category_id='$cat_id',category_type = '$cat_type',product_name='$product',
                                    mrp='$mrp',price='$price',description='$desc' where id='$id'";
                }else {
                    //if there is image update
                    $image=$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'],'../../media/product-img/'.$image);
                    $update_prod = "update products set category_id='$cat_id',category_type = '$cat_type',product_name='$product',
                                    mrp='$mrp',price='$price',image='$image',description='$desc' where id='$id'";
                }
                mysqli_query($con,$update_prod);
            } else {
                //adding product
                $image=$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],'../../media/product-img/'.$image);
                $add_prod = "insert into products(category_id,category_type,product_name,mrp,price,image,description,status) 
                            values('$cat_id', '$cat_type','$product','$mrp','$price','$image','$desc','1')";
                mysqli_query($con,$add_prod);
            }
            header('location:product.php');
            die();
        }
    }
?>
<div class="box">
    <form method="POST" enctype="multipart/form-data">
    <label>Category Type</label><br>
        <select name="cat_type" class="form-input">
            <option>Select Category Type</option>
            <?php
                $cat_ty = "select DISTINCT type from categories";
                $res = mysqli_query($con,$cat_ty);
                while($row = mysqli_fetch_assoc($res)) {
                    //for editing
                    if($row['type']==$cat_type){
                        echo "<option selected value=".$row['type'].">".$row['type']."</option>";
                    }else {
                        //for adding
                        echo "<option value=".$row['type'].">".$row['type']."</option>";
                    }
                }
            ?>
        </select><br>
        <label>Category</label><br>
        <select name="category_id" class="form-input">
            <option>Select Category</option>
            <?php
                $cat = "select id,category from categories order by category asc";
                $res = mysqli_query($con,$cat);
                while($row = mysqli_fetch_assoc($res)) {
                    //for editing
                    if($row['id']==$cat_id){
                        echo "<option selected value=".$row['id'].">".$row['category']."</option>";
                    }else {
                        //for adding
                        echo "<option value=".$row['id'].">".$row['category']."</option>";
                    }
                }
            ?>
        </select><br>
        <label>Product Name</label><br>
        <input class="form-input" type="text" name="product" placeholder="Enter your Product name" required pattern="[a-zA-Z0-9\s\-]{1,25}" title="Enter valid product name" value="<?php echo $product ?>"><br>
        <label>Image</label><br>
        <input class="form-input" type="file" name="image" <?php echo $required?>><br>
        <label>MRP</label><br>
        <input class="form-input" type="text" name="mrp" placeholder="Enter MRP" required pattern="[1-9]{1}[0-9]{0,3}" title="Enter valid MRP between 1-9999" value="<?php echo $mrp ?>"><br>
        <label>Price</label><br>
        <input class="form-input" type="text" name="price" placeholder="Enter Price" required  pattern="[1-9]{1}[0-9]{0,3}" title="Enter valid Price between 1-9999" value="<?php echo $price ?>"><br>
       <label>Description</label><br>
        <textarea class="form-input" name="desc" placeholder="Enter descripton" required><?php echo $desc ?></textarea><br>        
        <button class="submit-button" name="submit" type="submit">Submit</button>
        <div class="error-msg">
            <?php echo $msg; ?>
        </div>
    </form>
</div>