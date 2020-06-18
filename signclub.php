<?php
  require_once 'header.php';


if (!$loggedin) die("</div></body></html>");


 
  

    @$zespol = sanitizeString($_POST['zespol']);
     @$date = sanitizeString($_POST['datazalozenia']);
      @$kolor = sanitizeString($_POST['kolor']);
      @$miasto = sanitizeString($_POST['miasto']);
     
      
      

    
 
    if ($zespol == "" || $kolor == "" || $date == "" || $miasto == "" ){
     $_SESSION['n_pola']="Nie wszystkie pola zostały wypełnione ";
    }
    else
    {
      $result=queryMysql("SELECT Nazwa FROM zespół WHERE Nazwa='$zespol'");

      if ($result->num_rows){
        $_SESSION['n_zespol']="Zespół o takiej nazwie już istnieje";
      }
            
      else 
      {  
queryMysql("INSERT INTO zespół values (null, '$zespol', '$date', '$miasto')"); 
         
queryMysql("INSERT INTO koszulki values (null,'$kolor',(Select zespół.id from zespół where Nazwa='$zespol'))");  
$_SESSION['t_zespol']="Zespół utworzony pomyślnie";
          
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
    <link rel="stylesheet" href="home.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Content/bootstrap.css">
    <link rel="stylesheet" href="Content/style.css">
</head>
<body>
<div id="container" style="height:1200px; background-color:white;">
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
	
   
    <div class="row">
        <div class=" col-md-auto col2">
            <h1>Zarejestruj swój klub</h1>
             <?php
			if (isset($_SESSION['t_zespol']))
			{ ?>
				<div class="alert alert-success"><?php echo $_SESSION['t_zespol']?></div>
                        <?php
				unset($_SESSION['t_zespol']);
			}
		?>
             <?php
			if (isset($_SESSION['n_zespol']))
			{ ?>
				<div class="alert alert-warning"><?php echo $_SESSION['n_zespol']?></div>
                        <?php
				unset($_SESSION['n_zespol']);
			}
		?>
             <?php
			if (isset($_SESSION['n_pola']))
			{ ?>
				<div class="alert alert-warning"><?php echo $_SESSION['n_pola']?></div>
                        <?php
				unset($_SESSION['n_pola']);
			}
		?>
            <form method="post" action="signclub.php">

                <div class="form-group">
                    <label for="przykladoweKlub">NazwaKlubu</label>
                    <input type="text" class="form-control" name="zespol" placeholder="Podaj nazwę Klubu">
                </div>
                <div class="input-group">
                    
                </div>
                <div class="form-group">
                    <label for="przykladowadata">Data zalozenia</label>
                    <input type="date" class="form-control" name="datazalozenia" placeholder="Podaj datę założenia">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="przykladoweMiasto">Miasto</label>
                        <input type="text" class="form-control" name="miasto">
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kolor">Kolor</label>
                        <input type="text" class="form-control" name="kolor">
                    </div>

                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="przykladowyCheckbox">
                        <label class="form-check-label" for="przykladowyCheckbox">
                            Zaznacz mnie
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Wyślij</button>
            </form>
        </div>
    </div>
 </div>
    </div>

    <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>

