<?php 
  
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=Messages;charset=utf8', 'root', 'root');
    }
    catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
    }

    if(isset($_SESSION['username'])){
        $userdata1 = $bdd->prepare("SELECT id, Username, isAdmin FROM USERS WHERE Username = ? ");
        $userdata1 -> execute(array($_SESSION['username']));
        $userid = $userdata1->fetch();
    }else if($_SERVER['PHP_SELF'] != "/index.php"){ ?>
    <script type="text/javascript">
        window.location.href = 'login.php';
    </script>   
    <?php } ?>

<header id="header" class="okayNav-header navbar-fixed-top main-navbar-top">
    <div class="container">
        <div class="row">  
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                <a class="okayNav-header__logo navbar-brand" href="index.php">
                    <img src="images/logo.png" alt="" class="logo-1 img-responsive">
                    <img src="images/logo-dark.png" alt="" class="logo-2 img-responsive">
                </a>

            </div> <!-- End: .col-xs-3 -->
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-6">

                <nav role="navigation" class="okayNav pull-right" id="js-navbar-menu">
                    <ul id="navbar-nav" class="navbar-nav">

                        <?php if($userid['isAdmin'] == 1){ ?>
                        
                        <li><a href="pending-orders.php" class="btn-nav" id="loginlink2">Pending Orders</a></li>

                        <?php }else{ ?>

                        <li><a href="orderform.php" class="btn-nav" id="loginlink2">Make an Order</a></li>

                        <?php } ?>

                        <li><a href="my-orders.php" class="btn-nav" id="loginlink2">My Orders</a></li>
                        <li><a href="logout.php" class="btn-nav" id="loginlink2">Logout</a></li>

                    </ul>
                </nav>

            </div> <!-- End: .col-xs-9 -->
        </div> <!-- End: .row -->
    </div> <!-- End: .container -->
</header><!-- /header -->
