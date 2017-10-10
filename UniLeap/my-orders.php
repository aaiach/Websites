<?php
    
    include('include/init.php');

    $claimdata = $bdd->prepare("SELECT orderid, ordertime, Products.product_name as product, Users.username as client, Users.id as client_id, status FROM Orders INNER JOIN Products on (Orders.productid = Products.productid) INNER JOIN Users on (Orders.clientid = Users.id)WHERE status = 1 AND adminid = :admin ORDER BY ordertime");
    $claimdata -> execute(array('admin' => $userid['id']));

    $orderdata = $bdd -> prepare("SELECT orderid, ordertime, adminid, status, Products.product_name as product, Users.username as client FROM Orders INNER JOIN Products on (Orders.productid = Products.productid) INNER JOIN Users on (Orders.clientid = Users.id)WHERE clientid = :client ORDER BY status, ordertime");
    $orderdata -> execute(array('client' => $userid['id']));


?>

<!-- Start: Features Section 1
        ====================================== -->

<!DOCTYPE html>
<html lang="en">
    
    <?php include('include/head.php'); ?>

    <body>

        <?php
        if(isset($_POST['orderid1'])){
            $req = $bdd->prepare("UPDATE Orders SET adminid = NULL, status = 0 WHERE orderid = :ordr");
            $req -> execute(array('ordr' => $_POST['orderid1']));
            echo "<meta http-equiv='refresh' content='0'>";
        }

        if(isset($_POST['orderid2'])){
            $req = $bdd->prepare("UPDATE Orders SET status = 2 WHERE orderid = :ordr");
            $req -> execute(array('ordr' => $_POST['orderid2']));
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

                        <h2 class="section-heading">My orders</h2>
                        <p class="sub-heading"></p>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                    <div class="col-xs-12 features-item">
                        <div class="row">
                        <?php if($userid['isAdmin'] == 1){ ?>

                                    <div class="panel panel-default">
                                        <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Product</th>
                                            <th>Order date</th>
                                        </tr>
                                        </thead>

                                    <? while ($donnees = $claimdata->fetch()){

                                            $seendata = $bdd->prepare("SELECT user1, user2, seen FROM MP WHERE (user1 = :him AND user2 = :me) ORDER BY timeofmp DESC LIMIT 1");
                                            $seendata -> execute(array(
                                                'me' => $userid['id'], 
                                                'him' => $donnees['client_id']));
                                            $seen = $seendata -> fetch();

                                            $orderdate = new DateTime($donnees['ordertime']); ?>

                                            <tbody>
                                              <tr>
                                                <td><?php echo $donnees['client']; ?></td>
                                                <td><?php echo $donnees['product'] ?></td>
                                                <td><?php echo $orderdate->format('F j, Y'); ?></td>
                                                <td>
                                                    <form action="my-orders.php" method="post">
                                                        <input type= "hidden" name="orderid1" value = <?php echo $donnees['orderid']; ?> />
                                                        <input class="btn-admin" type="submit" value="Unclaim" />
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="my-orders.php" method="post">
                                                        <input type= "hidden" name="orderid2" value = <?php echo $donnees['orderid']; ?> />
                                                        <input class="btn-admin" type="submit" value="Completed" />
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="messages.php" method="post">
                                                        <input type="hidden" value=<?php echo $donnees['client']?> name="usr_to"/>
                                                        <input class="sub" type="submit" value="<?php 
                                                        if($seen['seen'] == 1){
                                                            echo '📝';
                                                            }else{
                                                            echo '📩';
                                                            }  ?>" />
                                                    </form>
                                                </td>
                                              </tr>      
                                            </tbody>

                                    <?php } ?>
                                </table>
                            </div>
                            </div>

                            <?php } else {?>

                            <div class="panel panel-default">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th>Product</th>
                                        <th>Admin</th>
                                        <th>Order date</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                <? while ($donnees = $orderdata->fetch()){ ?>
                                        <?php
                                        $admindata = $bdd->prepare("SELECT username FROM USERS WHERE ID = ? ");
                                        $admindata -> execute(array($donnees['adminid']));
                                        $adminid = $admindata->fetch();
                                        
                                        $orderdate = new DateTime($donnees['ordertime']);
                                        $status = "";
                                        
                                        $ongoing = false;

                                        $seendata = $bdd->prepare("SELECT user1, user2, seen FROM MP WHERE (user1 = :him AND user2 = :me) ORDER BY timeofmp DESC LIMIT 1");
                                        $seendata -> execute(array(
                                        'me' => $userid['id'], 
                                        'him' => $donnees['adminid']));
                                        $seen = $seendata -> fetch();

                                        if($donnees['status'] == 0){
                                            $status = "<span class=\"label label-warning\">Pending</span>";
                                        }else if($donnees['status'] == 1){
                                            $status = "<span class=\"label label-info\">Ongoing</span>";
                                            $ongoing = true;
                                        }else if($donnees['status']== 2){
                                            $status = "<span class=\"label label-success\">Processed</span>";
                                        }
                                        ?>                                    
                                    
                                    <tbody>
                                      <tr>
                                        <td><?php echo $donnees['product']; ?></td>
                                        <td><?php echo $adminid['username'] ?></td>
                                        <td><?php echo $orderdate->format('F j, Y'); ?></td>
                                        <td><?php echo $status ?></td>
                                        
                                        <td>
                                            <?php if($ongoing){ ?>
                                            <form action="messages.php" method="post">
                                                <input type="hidden" value=<?php echo $adminid['username']?> name="usr_to"/>
                                                <input class="sub" type="submit" value="<?php 
                                                if($seen['seen'] == 1){
                                                    echo '📝';
                                                    }else{
                                                    echo '📩';
                                                    }  ?>" />
                                            </form>
                                             <?php } ?>
                                        </td>
                                       
                                      </tr>      
                                    </tbody>

                                <?php } ?>
                                </table>
                            </div>

                            <?php } ?>                        
                            

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
    </body>
</html>
        <!-- End: Features Section 1
        ======================================-->