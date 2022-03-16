<?php 
    require('../connection.php');
    require('../functions.php');
?>
<!doctype html>
    <head>
        <title>Welcome|Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../style.css">
        
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <a href="admin.php"><h1 class="admin-h1">Welcome, Admin</h1></a>
                <div class="clear-float"></div>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="categories.php">Category</a></li>
					<li><a href="product.php">Product</a></li>
					<li><a href="order.php">Order Detail</a></li>
                    <li><a href="user.php">User Detail</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                </ul>
            </div>
        </div>