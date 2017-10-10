
<?php

require_once("braintree.php");

Braintree_Configuration::environment('public');
Braintree_Configuration::merchantId('public');
Braintree_Configuration::publicKey('public');
Braintree_Configuration::privateKey('public');

if(isset($_POST['desired_productid'])){
    $product = $_POST['desired_productid'];
}

$amount = $_POST["amount"];
$nonce = $_POST["payment_method_nonce"];
$result = Braintree\Transaction::sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonce,
    'options' => [
        'submitForSettlement' => true
    ]
]);
if ($result->success || !is_null($result->transaction)) {
    echo "Success";
    $transaction = $result->transaction; ?>

    <script type="text/javascript">
                window.location.href = 'transaction.php?id=<?php echo $transaction->id?>&product=<?php echo $product ?>'; 
    </script>
<?php } else {
    echo "Error...";
    $errorString = "";
    foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }
    $_SESSION["errors"] = $errorString; ?>
    <script type="text/javascript">
                window.location.href = 'index.php'; 
    </script>
<?php } ?>

