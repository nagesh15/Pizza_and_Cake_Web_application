 <?php
    require("connection.php");
    require("functions.php");
    $msg1 =' ';
    $msg2 =' ';
    $_SESSION['USER_LOGIN']='no';

    if(isset($_POST['submit1'])) {
        $email = get_safe_value($con,$_POST['email']);
        $password = get_safe_value($con,$_POST['password']);

        $check_user = "SELECT * FROM user_db where email='$email' and password='$password'";

        $res = mysqli_query($con,$check_user
    );

        $count = mysqli_num_rows($res);

        while($row = mysqli_fetch_assoc($res)){
            $id = $row['id'];
        }

        if($count>0) {
            $_SESSION['USER_LOGIN']='yes';
            $_SESSION['USER_USERNAME']=$username;
            $_SESSION['USER_ID']= $id;
            header('location:cust_side/home.php');
            die();
        } else {
            $msg1 = "Please enter correct login details";
        }
    }
?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log in/Register</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script src="../jsfile.js"></script>
</head>
<body>
		<div class="container">
			<div class="card">
				<div class="button-box">
					<div id="btn"></div>
						<button type="button" class="toggle-btn" onclick="login()">Login</button>
						<button type="button" class="toggle-btn" id="btn-reg" onclick="register()">Register</button>
				</div>
				<form id="login" class="input-group" method="POST">
					<input type="text" name="email" class="input-field" placeholder="Email" required>
					<input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                    <h3><a href="../extra/forgot_password.php">forgot password</a></h3>
					<button type="submit" name="submit1" class="submit-btn">Log In</button>
                    <div class="field-error">
                        <?php echo $msg1; ?>
                    </div>
				</form>
				<form id="register" class="input-group" method="POST">
					<input type="text" name="username" class="input-field" placeholder="User Name" pattern="[a-zA-Z\s]{1,25}" title="Enter correct name eg.John Smith" required>
                    <textarea name="address" id="address" class="input-field" cols="30" rows="3" placeholder="Enter Address" required></textarea>
                    <input type="text" name="pincode" class="input-field" placeholder="Pincode" pattern="[5]{1}[6-9]{1}[0-9]{4}" title="Enter correct Pincode" required>
                    <input type="text" name="pno" id="pno" class="input-field" placeholder="Phone Number" pattern="[6-9]{1}[0-9]{9}" title="Enter correct phone number eg.9876543210" required>
					<input type="email" name="email" class="input-field" placeholder="Email ID" required>
					<input type="password" name="pass" class="input-field" placeholder="Enter Password" pattern=".{8,}" title="Eight or more characters" required>
					<input type="password" name="cpass" class="input-field" placeholder="Confirm Password" pattern=".{8,}" title="Eight or more characters" required>
					<button type="submit" id="submit" name="submit2" class="submit-btn">Register</button>
					<div class="field-error">
                        <p id="error"></p>
                    </div>
				</form>
			</div>
		</div>
</body>
</html>
<script>
			var x = document.getElementById("login");
			var y = document.getElementById("register");
			var z = document.getElementById("btn");
            var pno= document.getElementById("pno");

			function register() {
				x.style.left = "-400px";
				y.style.left = "50px";
				z.style.left = "110px";
			}

			function login() {
				x.style.left = "50px";
				y.style.left = "450px";
				z.style.left = "0";
			}  
		</script>
<?php 
 
 if(isset($_POST['submit2'])) {
    $username = get_safe_value($con,$_POST['username']);
    $addr = get_safe_value($con,$_POST['address']);
    $pin= get_safe_value($con,$_POST['pincode']);
    $pno= get_safe_value($con,$_POST['pno']);
    $email= get_safe_value($con,$_POST['email']);
    $password= get_safe_value($con,$_POST['pass']);
    $cpassword= get_safe_value($con,$_POST['cpass']);

    $check_user = "select * from user_db where email='$email'";
    $res = mysqli_query($con,$check_user);
    $count = mysqli_num_rows($res);
    if($count>0) {
            echo '<script type="text/javascript">
                    register();
                    var er = document.getElementById("error");
                    er.innerHTML ="Email already present";
                </script>';
        
    } else {
       if($password == $cpassword) {
           $user = mysqli_query($con,"insert into user_db (name,address,pincode,phone_no,email,password) values ('$username','$addr','$pin','$pno','$email','$password')");
           $_SESSION['USER_LOGIN']='yes';
           $_SESSION['USER_USERNAME']=$userid;
           $id = mysqli_insert_id($con);
           $_SESSION['USER_ID']= $id;
           header('location:cust_side/home.php');
           die();
       }else {
           echo '<script type="text/javascript">
                    register();
                    var er = document.getElementById("error");
                    er.innerHTML ="Password and confirm password do not match";
                </script>';
           
       }
    }
}
?>