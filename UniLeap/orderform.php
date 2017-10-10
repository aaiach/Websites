<?php

include('include/init.php');

$productdata = $bdd->prepare("SELECT productid, product_name, product_price FROM Products");
$productdata -> execute();

?>

<!-- Start: Features Section 1
        ====================================== -->

<!DOCTYPE html>
<html lang="en">
    
    <?php include('include/head.php'); ?>

    <body>

        <?php include('include/navbar.php'); ?>

<html>
    <body>
        <section class="features-section-1 relative background-semi-dark" id="features">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">Products</h2>
                        <ul class="text-left">
                            <p>After paying for the service you will: </p>
                            <p>1. Be contacted by a superviser within 24h
                            <p>2. Give information to the supervisor to build a framework
                            <p>3. Be given a working plan where you and/or your superviser will have deadlines
                            <p>4. Recieve feedback from two other supervisers after the completion of the work
                        </ul>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                    <div class="col-xs-12 features-item">
                        <div class="row">
                            <?php while ($donnees = $productdata->fetch()){ ?>
                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">
                                    <h6 class="title"><?php echo $donnees['product_name']?></h6>
                                    <div class="detail">
                                        <p><?php echo $donnees['product_price']?> £</p>
                                            <div class="btn-form btn-scroll">
                                                <form action="secure-payment/payment.php" method="post">
                                                <input type="hidden" name="desired_productid" value="<?php echo $donnees['productid']?>" />
                                                <input type="hidden" name="desired_productname" value="<?php echo $donnees['product_name']?>" />
                                                <input type="hidden" name="desired_productprice" value="<?php echo $donnees['product_price']?>" />
                                                <button type="submit"class="btn btn-custom buy"></button>
                                                </form>
                                            </div>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->
                            <?php } ?>
                        
                        </div>
                    </div>

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>

        <!-- Custom Script 
        ==========================================-->
        <script src="js/single-nav.js"></script>

    </body>
</html>
        <!-- End: Features Section 1
        ======================================-->