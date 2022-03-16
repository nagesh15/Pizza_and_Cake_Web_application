<?php
    require("../connection.php");
    require("../functions.php");
    $msg =' ';
    if(isset($_POST['submit1'])) {
        $username = get_safe_value($con,$_POST['username']);
        $password = get_safe_value($con,$_POST['password']);

        $check_user = "SELECT * FROM admin_db where username='$username' and password='$password'";
        $res = mysqli_query($con,$check_user);

        $count = mysqli_num_rows($res);

        if($count>0) {
            $_SESSION['ADMIN_LOGIN']='yes';
            $_SESSION['ADMIN_USERNAME']=$username;
            header('location:admin.php');
            die();
        } else {
            $msg = "Please enter correct login details";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log in</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
		<div class="container">
			<div class="card">
				<div class="button-box">
					<div id="btn"></div>
						<button type="button" class="toggle-btn">Login</button>
				</div>
				<form id="login" class="input-group" method="POST">
					<input type="text" name="username" class="input-field" placeholder="User Id" required>
					<input type="password" name="password" class="input-field" placeholder="Enter Password" required>
					<button type="submit" name="submit1" class="submit-btn">Log In</button>
                    <div class="field-error">
                        <?php echo $msg; ?>
                    </div>
				</form>
			</div>
		</div>

</body>
</html>