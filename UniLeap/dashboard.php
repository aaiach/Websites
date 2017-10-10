<?php
  
    include('include/init.php');

?>

<!DOCTYPE html>
<html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="css/dashboard.css">
        </head>

        <body>

        <?php if($userid['isAdmin'] == 1){ ?>
            
        <div class="container">
            <div class="head">
                <h1>Welcome <?php echo $_SESSION['username'] ?></h1>
                <span class="admin">Admin panel</span>
            </div>
            <div class="foot">
                <a href="pending-orders.php" class="footItem1">Pending Orders</a><a href="my-orders.php" class="footItem2">My orders</a><a href="logout.php" class="footItem3">Logout</a>
            </div>
        </div>

        <a href="/pending-orders.php"></a>

        <?php }else{?>
            
        <div class="container">
            <div class="head">
                <h1>Welcome <?php echo $_SESSION['username'] ?></h1>
            </div>
            <div class="foot">
                <a href="logout.php" class="footItem1">Logout</a><a href="my-orders.php" class="footItem2">My orders</a><a href="orderform.php" class="footItem3">Make an order</a>
            </div>
        </div>

        <?php } ?>

    
    </body>
</html>