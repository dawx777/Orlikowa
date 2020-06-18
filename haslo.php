<?php

require_once 'header.php';

  if (!$loggedin) die("</div></body></html>");
if((isset($_POST['haslo']))&&isset($_POST['haslo1'])&&isset($_POST['haslo2']))
{                                                                                                                           
$walidacja=true;    

$starehaslo = sanitizeString(md5($_POST['haslo']));
$nowehaslo1 = sanitizeString($_POST['haslo1']);
$nowehaslo2 = sanitizeString($_POST['haslo2']);
    
    
    $result = queryMysql("select login,hasło from konto_logowania WHERE login='$user' AND hasło='$starehaslo'");

      if ($result->num_rows)
      { 
    
    
    if (strlen($starehaslo)<1)
    {
        $walidacja=false;
        $_SESSION['e_starehaslo']= "Proszę podać aktualne hasło.<br>";
        $_SESSION['e_div']= true;
    }
     
     
     
    if (strlen($nowehaslo1)<8)
    {
        $walidacja=false;
        $_SESSION['e_haslo1']= "Nowe hasło powinno mieć co najmniej 8 znaków.<br>";
        $_SESSION['e_div']= true;
    }
    if ($nowehaslo1 !=$nowehaslo2)
    {
        $walidacja=false;
        $_SESSION['e_haslo1']= "Podane hasła nie są takie same.<br>";
        $_SESSION['e_div']= true;
    }
     $haslo= md5($nowehaslo1);
      
       
$_SESSION['fr_haslos'] = $starehaslo;
		$_SESSION['fr_haslo11'] = $nowehaslo1;
		$_SESSION['fr_haslo22'] = $nowehaslo2;
                          
    if($walidacja==true)
    {
        queryMysql("update konto_logowania set hasło='$haslo' WHERE login='$user'");
                                                                                                                                                                     
       $_SESSION['pola1']="Hasło zostało zmienione pomyślnie";                                            
                               
                             }  
      }
}
?>






        
      <!doctype html>
<html lang="pl">
<head>
	<meta charset="uft-8">
	<title>ORLIKOWA</title>
	<link rel="stylesheet" href="home.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Content/bootstrap.css">
    <link rel="stylesheet" href="Content/style.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div id="container" style="height:1400px; background-color:#E7FBE9 ">
<div id="kontener">
	<div id="baner">
	<img src="logo.png"  style="margin-top:5px; margin-left:28%;" />
		
	</div>
	<div class="menu" style="height:auto;">
                <form method="get" action='home.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Strona główna</span></button>
                </form>
                <form method="get" action='members.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Członkowie</span></button>
                </form>
                  <form method="get" action='friends.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Przyjaciele</span></button>
                </form>
          <form method="get" action='profile.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Edytuj Profil</span></button>
                </form>
        <form method="get" action='messages.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Wiadomość</span></button>
                </form>
          <form method="get" action='zespol.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Dołącz do zespołu</span></button>
                </form>
        
          <form method="get" action='orlik.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Rezerwuj termin</span></button>
                </form>
          <form method="get" action='mecz.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Zaproś do gry</span></button>
                </form>
    
                <form method="get" action='logout.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle"><span>Wyloguj się</span></button>
                </form>   
            </div>
	
	<div id="blok_glowny" style="color:blue; background-color:#E7FBE9 "> 
    <div class="row">
        <div class=" col-md-auto col2">
             <?php
			if (isset($_SESSION['pola1']))
			{ ?>
				<div class="alert alert-success"><?php echo $_SESSION['pola1']?></div>
                        <?php
				unset($_SESSION['pola1']);
			}
		?>
            <h1>Zmiana hasła</h1>
            <form method="post" action="haslo.php" style="width: 100%;
    margin: 50px auto;
    text-align: left;
    padding: 20px; 
    border: 1px solid #bbbbbb; 
    border-radius: 5px;">
                <div class="form-row">
           
                    <div class="form-group col-md-6">
                        <label for="przykladoweHaslo">Stare Hasło</label>
                        <input type="password" class="form-control" name="haslo"  placeholder=" Stare Hasło" value="<?php
			if (isset($_SESSION['fr_haslos']))
			{
				echo $_SESSION['fr_haslos']; 
				unset($_SESSION['fr_haslos']);
			}
        ?>">
                         <?php
			if (isset($_SESSION['e_starehaslo']))
			{ ?>
				<div class="alert alert-danger"><?php echo $_SESSION['e_starehaslo']?></div>
                        <?php
				unset($_SESSION['e_starehaslo']);
			}
		?>
                    </div>
                     <div class="form-group col-md-6">
                        <label for="przykladoweHaslo">Nowe hasło</label>
                        <input type="password" class="form-control" name="haslo1"  placeholder="Nowe Hasło" value="<?php
			if (isset($_SESSION['fr_haslo11']))
			{
				echo $_SESSION['fr_haslo11'];
				unset($_SESSION['fr_haslo11']);
			}
        ?>" >
                    </div>
                        <div class="form-group col-md-6">
                        <label for="przykladoweHaslo">Nowe Hasło</label>
                        <input type="password" class="form-control" name="haslo2"  placeholder="Powtórz Hasło" value="<?php
			if (isset($_SESSION['fr_haslo22']))
			{
				echo $_SESSION['fr_haslo22'];
				unset($_SESSION['fr_haslo22']);
			}
        ?>" >
                             <?php
			if (isset($_SESSION['e_haslo1']))
			{ ?>
				<div class="alert alert-danger"><?php echo $_SESSION['e_haslo1']?></div>
                        <?php
				unset($_SESSION['e_haslo1']);
			}
		?>
                    </div>
                    
                </div>
                    <button type="submit" class="btn btn-primary">Zmień hasło</button>
            </form>
        </div>
        </div>

 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>

      

