<?php
  session_start();
  require_once 'header.php';


  


  $error = $user = $pass = "";




  if (isset($_POST['login']))
  {
    $user = sanitizeString($_POST['login']);
    $pass = sanitizeString(md5($_POST['haslo']));
    
    if ($user == "" || $pass == "")
     $_SESSION['bladpol']= "Nie wszystkie pola zostały wypełnione";
    else
    {
      $result = queryMysql("select login,hasło from konto_logowania WHERE login='$user' AND hasło='$pass'");

      if ($result->num_rows == 0)
      {
        $_SESSION['bladlog']="Nieudana próba logowania";
      }
      else
      {
        $_SESSION['login'] = $user;
        $_SESSION['haslo'] = $pass;
        die("Jesteś zalogowany jako $user <div class='center'>
         <a data-transition='slide' href='home.php'>Kliknij tutaj</a>,
         aby odświeżyć stronę.</div>");
          
          header("Location: home.php" );
      }
    }
  }
?>
  
    <!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content=" width=device-width, initial-scale=1">

    <title>Strona orlikowa</title>
    <link rel="stylesheet" type="text/css" href="Content/bootstrap.css">
    <link rel="stylesheet" href="Content/style.css">
</head>
<body style="background-image: url('1.jpg');">

   <div class="view" style="border-style:solid; margin-top:150px; border-color:white; border-top-right-radius: 30px;border-top-left-radius: 30px;border-bottom-right-radius: 30px;border-bottom-left-radius: 30px; border-width:30px; ">
      
        <div class="row">
            <div class=" col-md-auto col2 bg-info">

                <h1 style="color:white; font-family:sans-serif;">Zaloguj sie</h1>
             
             
                <form method="post" action="index.php">
                       <?php
			if (isset($_SESSION['bladlog']))
			{
            ?>
				<div class="alert alert-danger"><?php echo $_SESSION['bladlog']?></div>
                    <?php
				unset($_SESSION['bladlog']);
                }
                ?>
                       <?php
			if (isset($_SESSION['bladpol']))
			{
            ?>
				<div class="alert alert-danger"><?php echo $_SESSION['bladpol']?></div>
                    <?php
				unset($_SESSION['bladpol']);
                }
                ?>
                    <div class="form-group">
                        <label style="color:white" for="przykladowyLogin">Login</label>
                        <input type="text" class="form-control" name="login" aria-describedby="podpowiedzLogin" placeholder="Wpisz Login" >
                        <small  style="color:white" id="podpowiedzLogin" class="form-text text-muted">W powyższym polu wpisujesz swój Login.</small>
                    </div>
                    <div class="form-group">
                        <label style="color:white" for="przykladoweHaslo">Hasło</label>
                        <input type="password" class="form-control" name="haslo" placeholder="Wpisz hasło"  >
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="przykladowyCheckbox">
                        <label style="color:white" class="form-check-label" for="przykladowyCheckbox">Zaznacz mnie!</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="logowanie">Wyślij</button>
                </form>
            </div>
            
            <div class="col col3 bg-primary">
                
                    <div class="jumbotron bg-primary">
                        <h1 class="display-4">Witaj sportowy świrze!</h1>
                        <p class="lead">Masz ochotę na trochę sportowego ruchu ??</p>
                        <hr class="my-4">
                        <p>Jeśli chcesz dołączyć do orlikowej rodziny kliknij jeden z poniższych przycisków i ZAPISZ SIĘ!!</p>
                        <a class="btn btn-info btn-lg" href="sign.php"  role="button">Zarejstruj konto!</a>
                        <a class="btn btn-info btn-lg" href="signclub.php" role="button">Zapisz swój klub!</a>
                        <a class="btn btn-info btn-lg" href="./admin/index.php" role="button">Panel Administracyjny!</a>
                    </div>
                    
                </div>

            </div>
 
        </div>
    
          
    

    <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>

</body>
</html>








