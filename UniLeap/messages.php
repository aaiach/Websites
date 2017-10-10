<?php

include("include/init.php");

if(isset($_POST['usr_to'])){

    $userdata2 = $bdd->prepare("SELECT id, Username FROM USERS WHERE Username = ? ");
    $userdata2 -> execute(array($_POST['usr_to']));
    $userid2 = $userdata2->fetch();

    if(isset($_POST['content']) AND $_POST['content'] != "" ){
      $req = $bdd->prepare("INSERT INTO MP(user1, user2, message) VALUES(:u1, :u2, :pm)");

      $req->execute(array(
        'u1' => $userid['id'], 
        'u2' => $userid2['id'],
        'pm' => $_POST['content']
        ));
    }

    $messagedata = $bdd->prepare("SELECT MP.timeofmp, U1.username AS n1, U1.id as i1, U2.username n2, U2.id as i2, MP.message, MP.seen as seen, MP.messageid
    FROM MP INNER JOIN Users U1
         ON MP.user1 = U1.id 
         INNER JOIN Users U2 
         ON MP.user2 = U2.id
    WHERE
      (U1.username = :U1 AND U2.username = :U2) OR
      (U2.username = :U1 AND U1.username = :U2)
    ORDER BY 
      MP.timeofmp");

    $messagedata -> execute(array(':U1' => $_SESSION['username'], ':U2' => $_POST['usr_to']));
  } 

  ?>

<!DOCTYPE html>
<html lang="en">
    
    <?php include('include/head.php'); ?>
    <link rel="stylesheet" href="css/messages.css" />

    <body>
    
      <?php include('include/navbar.php'); ?>

		<div class="wrapper">
		  <div class="page">
		    <div class="scroll">
		      <div class="messages">

			      	<?php if(isset($userid['id']) AND isset($userid2['id']) AND ($userid['id'] != $userid2['id'])){ ?>

			    		 <!-- Start: Section Header -->
	                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

	                        <h2 class="section-heading">My orders</h2>
	                        <p class="sub-heading">Messages with <?php echo $userid2['Username']?></p>

	                    </div>

			    		<?php while ($donnees = $messagedata->fetch()){ 

			    			if(($donnees['i2'] == $userid['id']) AND ($donnees['seen'] == 0)){
			    				$seenquery = $bdd->prepare("UPDATE MP SET seen = 1 WHERE messageid = :pm");
			    				$seenquery -> execute(array(':pm' => $donnees['messageid']));
			    			}

			    			$seen = "";
			    			if(($donnees['i1'] == $userid['id']) AND ($donnees['seen'] == 1))
			    				$seen = "  -  seen";
			    			
			    			if($donnees['i1'] == $userid['id']){

			    			?>
			    			<div class="message message--my">
						       	<div class="text">
						       		<?php $messagedate = new DateTime($donnees['timeofmp']); ?>
						          	<?php echo $messagedate->format('j/m/y - G:i'); ?> <br>
					    			<?php echo $donnees['message']; ?>

						        </div>
						    </div>

			    			<?php
			    			}else{
			    			?>	
			    			<div class="message">
						       	<div class="text">
						       		<?php $messagedate = new DateTime($donnees['timeofmp']); ?>
						          	<?php echo $messagedate->format('j/m/y - G:i'); ?><br>
					    			<strong><?php echo $userid2['Username'] ?></strong> : <?php echo $donnees['message']; ?>

						        </div>
						    </div>
			    			<?php }

			    			?>


			   			<?php } ?>
					
			    	<?php }else{ ?> 
			    		<script type="text/javascript">
		                window.location.href = 'my-orders.php';
		            	</script>

			    	<?php } ?>
		       
		       	<div class = "row" >
		       		<div class="col-lg-offset-8 col-md-offset-7 col-sm-offset-6 col-lg-4 col-md-5 col-sm-6 col-xs-12">
					    <form class="sendmsg" action="messages.php" method="post">
				            <input type="text" class="form-control" placeholder="Write a message" name="content"/>
				            <input type="hidden" name="usr_to" value=<?php echo $userid2['Username']; ?> />
				            <input type="submit" style="display: none" value="valider" />
			        	</form>
			        </div>
	        	</div>
		  </div>
		</div>

        <!-- Custom Script 
        ==========================================-->
        <script src="js/single-nav.js"></script>
    </body>
</html>
        