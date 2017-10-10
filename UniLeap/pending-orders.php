<?php
    
    include('include/init.php');

    $pendingdata = $bdd->prepare("SELECT orderid, ordertime, Products.product_name as product, Users.username as client, status FROM Orders INNER JOIN Products on (Orders.productid = Products.productid) INNER JOIN Users on (Orders.clientid = Users.id)WHERE status = 0 ORDER BY ordertime");
    $pendingdata -> execute();
?>

<!-- Start: Features Section 1
        ====================================== -->

<!DOCTYPE html>
<html lang="en">
    
    <?php include('include/head.php'); ?>

    <body>

        <?php if($userid['isAdmin'] == 1){ 

            if(isset($_POST['orderid'])){
                $req = $bdd->prepare("UPDATE Orders SET adminid = 1, status = 1 WHERE orderid = :ordr");
                $req -> execute(array('ordr' => $_POST['orderid']));
                echo "<meta http-equiv='refresh' content='0'>";
            }

        ?>


        <?php include('include/navbar.php'); ?>

        <!-- Start: Features Section 1
        ====================================== -->
        <section class="features-section-1 relative background-semi-dark" id="features">
            <div class="container">
                <div class="row section-separator">
                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">Pending Orders</h2>
                        <p class="sub-heading"></p>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>
                        <div class="col-xs-12 features-item">
                            <div class="row">
                                <div class="panel panel-default">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Product</th>
                                                <th>Order date</th>
                                                <th>Claim</th>
                                            </tr>
                                        </thead>

                                        <? while ($donnees = $pendingdata->fetch()){ ?>

                                            <?php $orderdate = new DateTime($donnees['ordertime']); ?>
                                            
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $donnees['client']; ?></td>
                                                    <td><?php echo $donnees['product']; ?></td>
                                                    <td><?php echo $orderdate->format('F j, Y'); ?></td>
                                                    <td>
                                                        <form action="pending-orders.php" method="post">
                                                            <input type= "hidden" name="orderid" value = <?php echo $donnees['orderid']; ?> />
                                                            <input class="btn-admin" type="submit" value="Claim" />
                                                        </form>
                                                    </td>
                                            </tr>
                                            <tbody>

                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 1
        ======================================-->

        <!-- Custom Script 
        ==========================================-->
        <script src="js/single-nav.js"></script>

        <?php }else{ ?> 
                        <script type="text/javascript">
                        window.location.href = 'dashboard.php';
                        </script>

        <?php } ?>
    </body>
</html>
        <!-- End: Features Section 1
        ======================================-->