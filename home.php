<?php
  require_once 'header.php';

  if (!$loggedin) die("</div></body></html>");
?>

       
    
    <!doctype html>
<html lang="pl">
<head>
	<meta charset="uft-8">
	<title>ORLIKOWA</title>
	<link rel="stylesheet" href="home.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

</head>
<body>

<div id="container">
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
    
    
  
                            
	
	<div id="blok_glowny">
        
        
        
	 <div class="col ">
                
                    <div class="jumbotron-fluid" style="text-align:center;">
                        <h1 class="display-8">Witaj Graczu <?php echo $_SESSION['login'] ?> !</h1>
                        <p class="lead">To jest twoja aplikacja orlikowa</p>
                        <hr class="my-4">
                        <p>Jeśli chcesz załóż konto lub zarejestruj ZESPÓŁ</p>
                          <form method="get" action='sign.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle; width:150px; background-color:green;"><span>Zarejstruj konto!</span></button>
                        </form>
                     
                          <form method="get" action='signclub.php' style='display: inline-block;'>
                <button class="button" style="vertical-align:middle; width:150px; background-color:green;"><span>Zarejstruj klub!</span></button>          
                                   
                </form>   
                              
                  </div>   
                             
                </div>
 
    </div>
</div>
        

	
	<div id="stopka">
		 <p>© 2020 Copyright:<a href="https://zawislandawid.com/"> zawislandawid.com</a></p>
	</div>	
	</div>
	
   
  
</body>
</html>
    
    
    
    
    