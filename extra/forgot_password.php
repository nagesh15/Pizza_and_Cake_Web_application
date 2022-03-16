<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require('../extra/phpmailer/vendor/autoload.php');
require('../php_file/connection.php');
require('../php_file/functions.php');
$pass = '';
$msg =' ';


if(isset($_POST['submit'])) {
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$email = get_safe_value($con,$_POST['email']);
$user = mysqli_query($con,"select * from user_db where email='$email'");
while($row=mysqli_fetch_assoc($user)) {
$pass = $row['password'];
$name = $row['name'];
}
$check = mysqli_num_rows($user);
if($check > 0) {
try {
    //Server settings 
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'wipedevil@gmail.com';                     //SMTP username
    $mail->Password   = 'nagesh15new';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('wipedevil@gmail.com', 'NS SHOP');
    $mail->addAddress($email, $name);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your Password';
    $mail->Body    = 'This is your password: '.$pass;

    $mail->send();
    $msg ='<span style="color:green;">Password has been sent to your registered email<span> <a href="../php_file/login.php">Login</a>';
} catch (Exception $e) {
    $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} 
}else {
	$msg ="Sorry you are not registered <a href='../php_file/login.php'>Register</a>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script src="../jsfile.js"></script>
</head>
<body>

		<div class="container">
			<div class="card" style="height: 500px; margin:7% auto">
                <h1 style="color: #008cba; text-align:center;margin-top:30px;">Forgot Password</h1>
				<form id="login" class="input-group" method="POST">
					<input type="text" name="email" class="input-field" placeholder="Email" required>
					<button type="submit" name="submit" class="submit-btn">Submit</button>
                    <div class="field-error">
						<?php echo $msg ?>
                    </div>
				</form>
            </div>
		</div>
</body>
</html>