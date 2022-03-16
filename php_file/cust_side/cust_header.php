<?php
    require('../connection.php');
    require('../functions.php');
    require('add_to_cart.php');

    $obj = new add_to_cart();
    $totalproduct = $obj->totalProduct();

?>
<!doctype html>
    <head>
        <title>NS Pizza and Cake shop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style1.css"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <script src="../../jsfile.js"></script>
    </head>
    <body>
        <header class="main-header">
            <div class="container">
                <div class="logo">
                    <img src="../../img/logo.png">
                </div>
                <div class="nav">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="pizza.php">Pizza</a></li>
                        <li><a href="cake.php">Cake</a></li>
                        <li><a href="cart.php"><i class="fa fa-shopping-cart" style="font-size: 24px; color: #f89602;">
                                <sup class="cart-number">
                                    <?php echo $totalproduct;?>
                                </sup></i>
                            </a>
                        </li>
                        <?php if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes') { ?>
                            <li><a href="order.php">Order</a></li>
                            <li><a href="account.php">Account</a></li>
                            <li><a href="cust_logout.php">Logout</a></li>
                        <?php }else { ?>
                            <li><a href="../login.php">login/Register</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </header>
    </body>
</html>