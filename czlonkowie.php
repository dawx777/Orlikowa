

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
	
	<div id="blok_glowny" style="color:blue; background-color:#E7FBE9  "> 
        <?php
   if (isset($_GET['view']))
  {
       $zespol = sanitizeString($_GET['view']);
$result = queryMysql("SELECT Nazwa FROM zespół where Nazwa='$zespol'");
  $num    = $result->num_rows;
$row = $result->fetch_array(MYSQLI_ASSOC);
  echo "<h1>Zespół: </h1>";
         echo "<h3>".$row['Nazwa']."</h3>";

   
    $zespol = sanitizeString($_GET['view']);
     $result = queryMysql("SELECT zespół.Data_zalożenia,zespół.Miejscowość,koszulki.kolor from zespół inner join koszulki on koszulki.zespol_id=zespół.id where Nazwa='$zespol'");
           

  $num    = $result->num_rows;
 $row = $result->fetch_array(MYSQLI_ASSOC);
  echo "<h5>Informacje ogólne</h5><ul>";

   
    
    echo"Data założenia:"." ".$row['Data_zalożenia']."<br/>" ;
       
       echo "<br/>";
       
       echo"Miejscowość:"." ".$row['Miejscowość']." <br/>";
       
       echo "<br/>";
      
       echo"Kolor koszulek:". " ".$row['kolor'];
   
      
       
       
       
         $zespol = sanitizeString($_GET['view']);
     $result = queryMysql("SELECT login from czlonkowie where zespol='$zespol'");
         $result1=queryMysql("Select imie,nazwisko,dataurodzenia,miasto from klient inner join konto_logowania on klient.konto_logowania_id=konto_logowania.id inner join czlonkowie on konto_logowania.id=czlonkowie.konto_logowania_id where czlonkowie.login=konto_logowania.login");    

  $num    = $result->num_rows;
       $num1=$result1->num_rows;
    

  echo "<h3>Czlonkowie</h3><ul>";
       
       ?>
         <table border=1 style='background-color:silver; float:center; border:3px solid blue;' >
        <?php
             echo "<tr>";
   echo "<td>";
    echo "Login"."</td>";
      echo "<td>";
    echo "Imię"."</td>";
    echo "<td>";
    echo "Nazwisko"."</td>";
    echo "<td>";
    echo "Data urodzenia"."</td>";
    echo "<td>";
    echo "Miasto"."</td>";
   
    
        
        
   echo "</tr>";
for ($j = 0 ; $j < $num ; ++$j)
  {
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
   
     $row1 = $result1->fetch_array(MYSQLI_ASSOC);
    
 echo "<tr>";
    echo "<td>";
  echo "<a data-transition='slide' href='members.php?view=" .
      $row['login'] . "'> ". $row['login'] ."</td>" ."</a>";
    
    echo "<td>";
    echo  $row1['imie']."</td>";
    echo "<td>";
    echo  $row1['nazwisko']."</td>";
    echo "<td>";
    echo  $row1['dataurodzenia']."</td>";
    echo "<td>";
    echo  $row1['miasto']."</td>";
    
   
      

       
   }
     
      echo "</tr>";
echo "</table>"; 
       
   
       
        $result = queryMysql("SELECT mecz.zespol,mecz.rywal,wynik.wynik from mecz inner join wynik on wynik.mecz_id=mecz.id where mecz.zespol='$zespol' or mecz.rywal='$zespol'");
       
        $num    = $result->num_rows;
    
 echo "<h3>Przeprowadzone mecze</h3>";
       for ($j = 0 ; $j < $num ; ++$j)
  {
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
   
    
    echo "<br/>";
    echo "Zespół: "." ". $row['zespol']."<br/>";
    echo "<br/>";
    echo "Rywal: "." ". $row['rywal']."<br/>";
    echo "<br/>";
    echo "Wynik: "." ". $row['wynik']."<br/>";
    echo "<br/>";
    
   
       
       
   }
   }
        

      ?>

 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>

      
