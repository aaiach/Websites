<?php
 session_start();
  
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