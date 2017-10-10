<?php
require_once("braintree.php");

Braintree_Configuration::environment('public');
Braintree_Configuration::merchantId('public');
Braintree_Configuration::publicKey('public');
Braintree_Configuration::privateKey('public');

session_start();
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
}


if (isset($_GET["id"])) {
        $transaction = Braintree\Transaction::find($_GET["id"]);
        $transactionSuccessStatuses = [
            Braintree\Transaction::AUTHORIZED,
            Braintree\Transaction::AUTHORIZING,
            Braintree\Transaction::SETTLED,
            Braintree\Transaction::SETTLING,
            Braintree\Transaction::SETTLEMENT_CONFIRMED,
            Braintree\Transaction::SETTLEMENT_PENDING,
            Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
        ];
        if (in_array($transaction->status, $transactionSuccessStatuses)) {
        	$product = "";
            $header = "Sweet Success!";
            $icon = "success";
            $message = "Your test transaction has been successfully processed. See the Braintree API response and try again.";
            if(isset($_GET['product'])){

            	$product = $_GET['product'];

            	$productdata = $bdd->prepare("SELECT product_price FROM Products WHERE productid = ?");
    			$productdata -> execute(array($product));
    			$selectedprice = $productdata -> fetch();
    			$date_now = new DateTime(null, new DateTimeZone("UTC"));
    			$date_trans = $transaction->createdAt;
    			$date_trans->add(new DateINterval('PT10S'));
    			
    			if($date_now < $transaction->createdAt){
	    			if($selectedprice['product_price'] == $transaction->amount){

			        $req = $bdd->prepare("INSERT INTO Orders(productid, clientid, status) VALUES(:pr, :cid, 0)");
			        $req->execute(array(
			            'pr' => $product,
			            'cid' => $userid1['id']
			            ));
			    	}else{
			    		$message = "You have attempted to rig the system, you are banned m8";
			    	}
		    	}else{
		    		$message = "transaction expired";
		    	}
		    }
        } else {
            $header = "Transaction Failed";
            $icon = "fail";
            $message = "Your test transaction has a status of " . $transaction->status . ". See the Braintree API response and try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
	<div class="wrapper">
	    <div class="response container">
	        <div class="content">
	            <div class="icon">
	            <img src="/images/<?php echo($icon)?>.svg" alt="">
	            </div>

	            <h1><?php echo($header)?></h1>
	            <section>
	                <p><?php echo($message)?></p>
	            </section>
	            
	        </div>
	    </div>
	</div>

	<aside class="drawer dark">

	    <article class="content compact">
	        <section>
	            <h5>Transaction</h5>
	            <table cellpadding="0" cellspacing="0">
	                <tbody>
	                	<tr>
	                        <td>product id</td>
	                        <td><?php echo($product)?></td>
	                    </tr>
	                    <tr>
	                        <td>id</td>
	                        <td><?php echo($transaction->id)?></td>
	                    </tr>
	                    <tr>
	                        <td>type</td>
	                        <td><?php echo($transaction->type)?></td>
	                    </tr>
	                    <tr>
	                        <td>amount</td>
	                        <td><?php echo($transaction->amount)?></td>
	                    </tr>
	                    <tr>
	                        <td>status</td>
	                        <td><?php echo($transaction->status)?></td>
	                    </tr>
	                    <tr>
	                        <td>created_at</td>
	                        <td><?php echo($transaction->createdAt->format('Y-m-d H:i:s'))?></td>
	                    </tr>
	                    <tr>
	                        <td>updated_at</td>
	                        <td><?php echo($transaction->updatedAt->format('Y-m-d H:i:s'))?></td>
	                    </tr>
	                </tbody>
	            </table>
	        </section>

	        <section>
	            <h5>Payment</h5>

	            <table cellpadding="0" cellspacing="0">
	                <tbody>
	                    <tr>
	                        <td>token</td>
	                        <td><?php echo($transaction->creditCardDetails->token)?></td>
	                    </tr>
	                    <tr>
	                        <td>bin</td>
	                        <td><?php echo($transaction->creditCardDetails->bin)?></td>
	                    </tr>
	                    <tr>
	                        <td>last_4</td>
	                        <td><?php echo($transaction->creditCardDetails->last4)?></td>
	                    </tr>
	                    <tr>
	                        <td>card_type</td>
	                        <td><?php echo($transaction->creditCardDetails->cardType)?></td>
	                    </tr>
	                    <tr>
	                        <td>expiration_date</td>
	                        <td><?php echo($transaction->creditCardDetails->expirationDate)?></td>
	                    </tr>
	                    <tr>
	                        <td>cardholder_name</td>
	                        <td><?php echo($transaction->creditCardDetails->cardholderName)?></td>
	                    </tr>
	                    <tr>
	                        <td>customer_location</td>
	                        <td><?php echo($transaction->creditCardDetails->customerLocation)?></td>
	                    </tr>
	                </tbody>
	            </table>
	        </section>

	        <?php if (!is_null($transaction->customerDetails->id)) : ?>
	        <section>
	            <h5>Customer Details</h5>
	            <table cellpadding="0" cellspacing="0">
	                <tbody>
	                    <tr>
	                        <td>id</td>
	                        <td><?php echo($transaction->customerDetails->id)?></td>
	                    </tr>
	                    <tr>
	                        <td>first_name</td>
	                        <td><?php echo($transaction->customerDetails->firstName)?></td>
	                    </tr>
	                    <tr>
	                        <td>last_name</td>
	                        <td><?php echo($transaction->customerDetails->lastName)?></td>
	                    </tr>
	                    <tr>
	                        <td>email</td>
	                        <td><?php echo($transaction->customerDetails->email)?></td>
	                    </tr>
	                    <tr>
	                        <td>company</td>
	                        <td><?php echo($transaction->customerDetails->company)?></td>
	                    </tr>
	                    <tr>
	                        <td>website</td>
	                        <td><?php echo($transaction->customerDetails->website)?></td>
	                    </tr>
	                    <tr>
	                        <td>phone</td>
	                        <td><?php echo($transaction->customerDetails->phone)?></td>
	                    </tr>
	                    <tr>
	                        <td>fax</td>
	                        <td><?php echo($transaction->customerDetails->fax)?></td>
	                    </tr>
	                </tbody>
	            </table>
	        </section>i
	        <?php endif; ?>

	    </article>
	</aside>
</html>