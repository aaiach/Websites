<?php session_start();

require_once("braintree.php");

Braintree_Configuration::environment('public');
Braintree_Configuration::merchantId('public');
Braintree_Configuration::publicKey('public');
Braintree_Configuration::privateKey('public');

    try{
        $bdd = new PDO('mysql:host=localhost;dbname=Messages;charset=utf8', 'root', 'root');
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

if(isset($_SESSION['username'])){
    $userdata1 = $bdd->prepare("SELECT id, Username FROM USERS WHERE Username = ? ");
    $userdata1 -> execute(array($_SESSION['username']));
    $userid1 = $userdata1->fetch();
   
    if(isset($_POST['desired_productid'])){
      $product = $_POST['desired_productid'];
    }
}
?>

<!DOCTYPE html>

<html>
  
  <head>
    <meta charset="UTF-8">
    <link rel=stylesheet type=text/css href="css/app.css">
    <link rel=stylesheet type=text/css href="css/overrides.css">
  </head>

  <?php if(isset($_POST['desired_productid']) AND isset($userid1['id'])){ ?>
	<div class="wrapper">
        <div class="checkout container">
            <header>
                <h1>Checkout for: <?php echo $_POST['desired_productname']?></h1>
                <p>
                    Please enter your card details
                </p>

                <?php if(isset($_SESSION["errors"])){
            		echo $_SESSION["errors"];
            	} ?>

            </header>

            <form method="post" id="payment-form" action="checkout.php">
                <section>
                    <input id="amount" name="amount" type="hidden" value="<?php echo $_POST['desired_productprice'] ?>" />
                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <input type="hidden" name="desired_productid" value="<?php echo $product; ?>" />
                
                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.7.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "<?php echo(Braintree_ClientToken::generate()); ?>";
        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();
            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Error', err);
                return;
              }
              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
        
    </script>
    <?php }else{ ?>
      <script type="text/javascript">
          window.location.href = '../index.php';
      </script>
    <?php } ?>

</html>