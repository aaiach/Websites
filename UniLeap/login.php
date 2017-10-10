<?php
    session_start();
    if(isset($_SESSION['username'])){
        $error= 'Bienvenue '.$_SESSION['username'];
    }else{
        $error = "";
    }
  
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=Messages;charset=utf8', 'root', 'root');
    }
    catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
    }


    if(isset($_POST['username']) AND isset($_POST['password']) AND isset($_POST['email']) AND isset($_POST['confirmation'])){
        if(($_POST['password'] == $_POST['confirmation']) AND (strlen($_POST['password']) >=8)){
            $password=$_POST['password'];
            $sql=$bdd->prepare("SELECT COUNT(*) FROM Users WHERE username=?");
            $sql->execute(array($_POST['username']));
            if($sql->fetchColumn() == 0){
           
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql=$bdd->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?);");
                $sql->execute(array($_POST['username'], $hashed_password, $_POST['email']));
         
                $error= "Bienvenue sur le site, connectez vous désormais";
            }else{
                $error= "Vous avez déjà un compte";
            }
        }else{
            $error= "Veuillez remplir le formulaire";
        }
    }

    if(isset($_POST['login_username']) AND isset($_POST['login_password'])){

        $input_username = $_POST['login_username'];
        $input_password=$_POST['login_password'];
        $count=$bdd->prepare("SELECT COUNT(*) FROM Users WHERE username=?");
        $count->execute(array($input_username));

        if($count->fetchColumn() != 0){
            
            $hashed_query = $bdd->prepare("SELECT password FROM Users WHERE username=?");
            $hashed_query -> execute(array($input_username));

            while($p = $hashed_query -> fetch()){
                $hashed_password = $p['password'];
            }

            $hashed_input = password_hash($input_password, PASSWORD_DEFAULT);

            if(password_verify($input_password, $hashed_password)){
                $_SESSION['username'] = $input_username;
                $error = "Succesful login";

                $userdata1 = $bdd->prepare("SELECT isAdmin FROM USERS WHERE Username = ? ");
                $userdata1 -> execute(array($_SESSION['username']));
                $userid1 = $userdata1->fetch(); 

                header("Location: index.php");

            }else{
                $error = "Mot de passe incorrect";
            }

        }else{
            $error =  "Vous n'avez pas de compte";
        }
    }       


?>

<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <title>Log in/Sign up screen animation</title>
  
      <link rel="stylesheet" href="css/login.css">
  
</head>

<body>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

<div class="container">
  <div class="frame">
    <div class="nav">
      <ul class"links">
        <li class="signin-active"><a class="btn">Sign in</a></li>
        <li class="signup-inactive"><a class="btn">Sign up </a></li>
      </ul>
    </div>

    <script language="JavaScript" type="text/javascript">
      function postform1( )
        {
              document.getElementById('form1').submit() ;

        }
      function postform2( )
        {
              document.getElementById('form2').submit() ;
        }
    </script>

    <div ng-app ng-init="checked = false">
			<form class="form-signin" action="" method="post" name="form1">
          <div class="signup-error"> <?php echo $error ?> </div>
          <label for="username">Username</label>
          <input class="form-styling" type="text" name="login_username" placeholder=""/>
          <label for="password">Password</label>
          <input class="form-styling" type="password" name="login_password" placeholder=""/>
          <input type="submit" value="Sign in" class="btn-signup"></a>
          
		  </form>
        
			<form class="form-signup" action="" method="post" name="form2">
          <label for="fullname">Username</label>
          <input class="form-styling" type="text" name="username" placeholder=""/>
          <label for="email">Email</label>
          <input class="form-styling" type="text" name="email" placeholder=""/>
          <label for="password">Password</label>
          <input class="form-styling" type="password" name="password" placeholder=""/>
          <label for="confirmpassword">Confirm password</label>
          <input class="form-styling" type="password" name="confirmation" placeholder=""/>
          <input type="submit" value="Sign up" class="btn-signup"></a>


			</form>
  
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js'></script>

  <script>

    $(function() {
      $(".btn").click(function() {
        $(".form-signin").toggleClass("form-signin-left"); <!-- I/O signin page -->
        $(".form-signup").toggleClass("form-signup-left"); <!-- I/O signup page -->
        $(".signup-inactive").toggleClass("signup-active"); <!-- I/O signup underline -->
        $(".signin-active").toggleClass("signin-inactive"); <!-- I/O signin underline -->
        $(this).removeClass("idle").addClass("active");
      });
    });
  </script>

</body>
</html>
