<?php
    include('include/init.php');
?>


<!DOCTYPE html>
<html lang="en">
    
    <?php include('include/head.php'); ?>

    <body>

        <!-- Start: Navbar Area -->

        <header id="header" class="okayNav-header navbar-fixed-top main-navbar-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                        <a class="okayNav-header__logo navbar-brand" href="#">
                            <img src="images/logo.png" alt="" class="logo-1 img-responsive">
                            <img src="images/logo-dark.png" alt="" class="logo-2 img-responsive">
                        </a>

                    </div> <!-- End: .col-xs-3 -->

                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-6">

                        <nav role="navigation" class="okayNav pull-right" id="js-navbar-menu">
                            <ul id="navbar-nav" class="navbar-nav">
                                
                                <?php if(!isset($userid['id'])){ ?>
                                <li><a class="btn-nav" href="#features">Features</a></li>
                                <li><a class="btn-nav" href="#pricing">pricing</a></li>
                                <li><a class="btn-nav" id="loginlink1" href="">Login</a></li>

                                <script type="text/javascript">
                                    document.getElementById("loginlink1").onclick = function () {
                                        location.href = "login.php";
                                    };
                                </script>
                                <?php } else if($userid['isAdmin'] == 1 ){ ?>
                                <li><a href="pending-orders.php" class="btn-nav" id="loginlink2">Pending Orders</a></li>
                                <li><a href="my-orders.php" class="btn-nav" id="loginlink3">My Orders</a></li>
                                <li><a href="logout.php" class="btn-nav" id="loginlink4">Logout</a></li>

                                <script type="text/javascript">
                                    document.getElementById("loginlink2").onclick = function () {
                                        location.href = "pending-orders.php";
                                    };
                                </script>
                                <?php }else{ ?>
                                <li><a href="orderform.php" class="btn-nav" id="loginlink5">Make an Order</a></li>
                                <li><a href="my-orders.php" class="btn-nav" id="loginlink3">My Orders</a></li>
                                <li><a href="logout.php" class="btn-nav" id="loginlink4">Logout</a></li>

                                <script type="text/javascript">
                                    document.getElementById("loginlink5").onclick = function () {
                                        location.href = "orderform.php";
                                    };
                                </script>


                                <?php } ?>

                                <script type="text/javascript">
                                    document.getElementById("loginlink3").onclick = function () {
                                        location.href = "my-orders.php";
                                    };
                                    document.getElementById("loginlink4").onclick = function () {
                                        location.href = "logout.php";
                                    };
                                </script>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- End: Navbar Area -->


        
        <!-- Start: Header Section -->

        <section class="header-section-1 bg-image-1 header-js" id="header" >
            <div class="overlay-color">
                <div class="container">
                    <div class="row section-separator">
                        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                            <div class="part-inner text-center">

                                <!--  Header SubTitle Goes here -->
                                <h1 class="title">Don't miss out on the world's leading Universities</h1> 

                                <div class="detail">
                                    <p>We offer full support on all academic work which contribute to your admissions</p>
                                </div>

                                <!-- Button Area -->
                                <div class="btn-scroll">
                                    <a href="#features" class="right-icon"><img src="images/down-arrow.png" alt="" class="logo-3 logo-1 img-responsive"></a>
                                </div>

                            </div>
                        </div> <!-- End: .part-1 -->
                    </div> <!-- End: .row -->
                </div> <!-- End: .container -->
            </div> <!-- End: .overlay-color -->
        </section>
        <!-- End: Header Section -->

        <!-- Start: Features Section 7 -->
        <section class="features-section-7 content-half background-light" >

            <div class="container-half container-half-left background-light"></div>
            <div class="container-half container-half-right cover" style="background-image: url(images/background-4.jpg);"></div>

            <div class="container">
                <div class="row section-separator text-left">

                    <div class="col-md-6">
                        <div class="inner">

                            <h2 class="section-heading">Reach leading institutions in France, UK, Canada and the US</h2>
                            <div class="detail">
                                <p>We will help you write and personalise your statements, prepare you for interviews, help you achieve top marks in your internal assesments.</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End: Features Section 7 -->


        <!-- Start: Features Section 1 -->
        <section class="features-section-1 relative background-semi-dark" id="features">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">Our Features</h2>
                        <p class="sub-heading"></p>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                    <div class="col-xs-12 features-item">
                        <div class="row">
                            
                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">
                            
                                    <img src="images/watch.png" alt="" class="logo-3 logo-1 img-responsive">
                                    <h6 class="title">Quick Reponse</h6>
                                    <div class="detail">
                                        <p>Order and one of our supervisers will get in touch and givey ou first feedback with you within the same day</p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">
                            
                                    <img src="images/suit.png" alt="" class="logo-3 logo-1 img-responsive">
                                    <h6 class="title">Services tailored to you</h6>
                                    <div class="detail">
                                        <p>Work with a superviser specialised in your domain, and get feedback from 2 other specialists</p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">
                            
                                    <img src="images/list.png" alt="" class="logo-3 logo-1 img-responsive">

                                    <h6 class="title">Simple</h6>
                                    <div class="detail">
                                        <p>Order, get in touch, and complete your work without complete support from our team.</p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features --> 
                        </div>
                    </div>

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 1 -->


        <!-- Start: Features Section 4 -->
        <section class="features-section-4 relative background-semi-dark" id="pricing">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">What we offer</h2>
                        <p class="sub-heading">For the piece of work you choose, a specialised supervisor will provide plans, guidelines and complete support during the process of completing the task.</p>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>
                    
                    <div class="pricing-table col-xs-12">
                        <div class="row">
                            
                            <div class="each-table col-md-offset-1 col-md-4 col-sm-12">
                                <div class="inner text-left background-light">

                                    <p class="meta-price">£200</p>

                                    <div class="category">
                                        <span>University</span>
                                        <span>Statements</span>
                                    </div>

                                    <ul class="nav rule-list">
                                        <li>UCAS Personal Statement</li>
                                        <li>Canada Letter of intent</li>
                                        <li>USA Admission Essays</li>
                                    </ul>
                                    <div class="">
                                        <a href="orderform.php" class="btn btn-custom purchase buy"></a>
                                    </div>
                                </div> <!-- End: .table-single -->
                            </div> <!-- End: .each-table -->

                            

                            <div class="each-table col-md-offset-2 col-md-4 col-sm-12">
                                <div class="inner text-left background-light">

                                    <p class="meta-price">£300</p>

                                    <div class="category">
                                        <span>IB</span>
                                        <span>Diploma</span>
                                    </div>

                                    <ul class="nav rule-list">
                                        <li>Internal Assesments</li>
                                        <li>Extended Essay</li>
                                        <li>TOK Essay & Presentation</li>
                                    </ul>
                                    <div class="">
                                        <a href="orderform.php" class="btn btn-custom purchase buy"></a>
                                    </div>
                                </div> <!-- End: .table-single -->
                            </div> <!-- End: .each-table -->

                        </div> <!-- End: .row -->
                    </div> <!-- End: .pricing-table -->

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 4 -->


        <!-- Start: Footer Section 1-->

        <footer class="footer-section background-dark">
            <div class="container">
                <div class="row section-separator text-center">

                    <div class="copyright">
                        <p>Lemon ©</p>
                    </div>

                </div><!-- End: .section-separator  -->
            </div> <!-- End: .container  -->
        </footer>
        <!-- End: Footer Section 1 -->


        <script src="js/custom-scripts.js"></script>

    </body>

</html>