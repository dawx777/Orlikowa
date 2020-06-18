<?php
  require_once 'header.php';

echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>  
_END;
     $error = $user = $pass = "";



  if (isset($_POST['login']))
  {
  

    $user = sanitizeString($_POST['login']);

     $email = sanitizeString($_POST['email']);
      $imie = sanitizeString($_POST['imie']);
      $nazwisko = sanitizeString($_POST['nazwisko']);
        $date = sanitizeString($_POST['dataurodzenia']);
      $miasto = sanitizeString($_POST['miasto']);
      	$haslo1 = sanitizeString($_POST['haslo1']);
		$haslo2 = sanitizeString($_POST['haslo2']);
        $adres = sanitizeString($_POST['adres']);
		$kod = sanitizeString($_POST['kod']);
      
      
      if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo =  md5($haslo1);
    if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $user;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "header.php";
 
    if ($user == "" || $haslo1 == "" || $haslo2 == "" || $email == "" || $imie == "" || $nazwisko == "" || $date == "" || $miasto == ""  || $adres == "" || $kod == ""){
     $_SESSION['pola']="Nie wszystkie pola zostały wypełnione";
    }
      
      
    
    else
    {
      $result=queryMysql("SELECT login FROM konto_logowania WHERE login='$user'");

      if ($result->num_rows)
       $_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
        
    $result=queryMysql("SELECT email FROM konto_logowania WHERE email='$email'");

      if ($result->num_rows)
      $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
            
      else 
      {  
       
queryMysql("INSERT INTO konto_logowania values (null, '$user', '$haslo', '$email', NULL)"); 
         
  queryMysql("INSERT INTO klient values (null, '$imie', '$nazwisko', '$date','$miasto','$adres','$kod',(select konto_logowania.id from konto_logowania where login='$user'))");  
die("Konto utworzone  </h4>Proszę się zalogować.  <div class='center'>
         <a data-transition='slide' href='index.php'>Kliknij tutaj</a>,
         aby odświeżyć stronę.</div>");
        
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
<body>

    

    <div class="row">
        <div class=" col-md-auto col2">
             <?php
			if (isset($_SESSION['pola']))
			{ ?>
				<div class="alert alert-warning"><?php echo $_SESSION['pola']?></div>
                        <?php
				unset($_SESSION['pola']);
			}
		?>
            <h1>Zarejestruj swoje konto</h1>
            <form method="post" action="sign.php">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="przykladowyEmail">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
        ?>">
                        <?php
			if (isset($_SESSION['e_email']))
			{ ?>
				<div class="alert alert-primary"><?php echo $_SESSION['e_email']?></div>
                        <?php
				unset($_SESSION['e_email']);
			}
		?>
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label for="przykladoweHaslo">Hasło</label>
                        <input type="password" class="form-control" name="haslo1"  placeholder="Hasło" value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
        ?>">
                         <?php
			if (isset($_SESSION['e_haslo']))
			{ ?>
				<div class="alert alert-danger"><?php echo $_SESSION['e_haslo']?></div>
                        <?php
				unset($_SESSION['e_haslo']);
			}
		?>
                    </div>
                     <div class="form-group col-md-6">
                        <label for="przykladoweHaslo">Hasło</label>
                        <input type="password" class="form-control" name="haslo2"  placeholder="Powtórz Hasło" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
        ?>" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="przykladowyLogin">Login</label>
                        <input type="text" class="form-control" name="login"  placeholder="Podaj Login" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
        ?>">
                        
              <?php
			if (isset($_SESSION['e_nick']))
			{ ?>
				<div class="alert alert-warning"><?php echo $_SESSION['e_nick']?></div>
                        <?php
				unset($_SESSION['e_nick']);
			}
		?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="przykladoweImie">Imię</label>
                    <input type="text" class="form-control" name="imie"   placeholder="Podaj Imię">
                </div>
                <div class="form-group col-md-6">
                    <label for="przykladoweNazwisko">Nazwisko</label>
                    <input type="text" class="form-control" name="nazwisko" placeholder="Podaj Nazwisko">
                </div>
                <div class="form-group col-md-6">
                    <label for="przykladowadata">Data urodzenia</label>
                    <input type="date" class="form-control" name="dataurodzenia"  placeholder="Podaj datę urodzenia">
                </div>

                <div class="form-group col-md-6 ">
                    <label for="przykladoweMiasto">Miasto</label>
                    <input type="text" class="form-control" name="miasto" placeholder="Podaj miejscowość">
                </div>
                  <div class="form-group col-md-6">
                    <label for="przykladowadata">Adres zamieszkania</label>
                    <input type="text" class="form-control" name="adres"  placeholder="Podaj adres">
                </div>

                <div class="form-group col-md-6 ">
                    <label for="przykladoweMiasto">Kod pocztowy</label>
                    <input type="text" class="form-control" name="kod" placeholder="Podaj kod pocztowy">
                </div>
               
                  <div id="lower">
	<input type="checkbox" name="regulamin" <?php
			if (isset($_SESSION['fr_regulamin']))
			{
				echo "checked";
				unset($_SESSION['fr_regulamin']);
			}
                ?>/><label class="check" for="checkbox">Akceptuje polityke prywatności!</label>
                
          <?php
			if (isset($_SESSION['e_regulamin']))
			{ ?>
				<div class="alert alert-warning"><?php echo $_SESSION['e_regulamin']?></div>
                        <?php
				unset($_SESSION['e_regulamin']);
			}
		?>
            
	

	</div>
                    <button type="submit" class="btn btn-primary">Utwórz konto</button>
            </form>
        </div>
        </div>


            <script src="Scripts/jquery-3.0.0.js"></script>
            <script src="Scripts/bootstrap.js"></script>
</body>
</html>


