

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
</head>
<body>

<div id="container" style="height:auto; background-color:#E7FBE9">
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
	
	<div id="blok_glowny" style="color:blue; height:auto; background-color:#E7FBE9 ">
        <?php
       if (isset($_GET['view']))
  {
       $orlik = sanitizeString($_GET['view']);
$result = queryMysql("SELECT nazwaorlika FROM orlik where nazwaorlika='$orlik'");
  $num    = $result->num_rows;
$row = $result->fetch_array(MYSQLI_ASSOC);
  echo "<h1>Orlik: </h1>";
         echo "<h3>".$row['nazwaorlika']."</h3>";
?>
<hr>
<?php        
   
    $orlik = sanitizeString($_GET['view']);
     $result = queryMysql("SELECT orlik.miejscowość, informacje_orlik.rok_zalożenia,informacje_orlik.	informacje_orlikcol,informacje_orlik.koszt_budowy,nawierzchnia.rodzaj from orlik inner join informacje_orlik on orlik.informacje_orlik_id=informacje_orlik.id inner join nawierzchnia on informacje_orlik.nawierzchnia_id=nawierzchnia.id where nazwaorlika='$orlik'");
       $result1=queryMysql("select oswietlenie.rodzaj from orlik inner join informacje_orlik on orlik.informacje_orlik_id=informacje_orlik.id inner join oswietlenie on informacje_orlik.oswietlenie_id=oswietlenie.id where nazwaorlika='$orlik' ");
           

  $num    = $result->num_rows;
 $row = $result->fetch_array(MYSQLI_ASSOC);
       $num1    = $result1->num_rows;
 $row1 = $result1->fetch_array(MYSQLI_ASSOC);
       
  echo "<h5>Informacje ogólne</h5><ul>";

   
    
    echo"Data założenia:"." ".$row['rok_zalożenia']."<br/>" ;
       
       echo "<br/>";
       
       echo"Miejscowość:"." ".$row['miejscowość']." <br/>";
       
       echo "<br/>";
      
       echo"Koszt_budowy:". " ".$row['koszt_budowy']." <br/>";
   
       echo "<br/>";
      
       echo"Informacje:". " ".$row['informacje_orlikcol']." <br/>";
       
         echo "<br/>";
      
       echo"Rodzaj nawierzchni:". " ".$row['rodzaj']." <br/>";
       
       echo "<br/>";
      
       echo"Rodzaj oswietlenia:". " ".$row1['rodzaj']." <br/>";
       
       ?>
        <hr>
        <?php
       
       
        $orlik = sanitizeString($_GET['view']);
       
        $result = queryMysql("SELECT organ.Nazwa_organu,organ.miejsce_zarządzania FROM orlik inner join organ on orlik.organ_id=organ.id where nazwaorlika='$orlik'");
       
         
       
  $num    = $result->num_rows;
$row = $result->fetch_array(MYSQLI_ASSOC);
       
       
       echo "<h5>Organ Zarządzajcy orlikiem</h5>";

   
    
    echo"Organ:"." ".$row['Nazwa_organu']."<br/>" ;
       
       echo "<br/>";
       
       echo"Siedziba:"." ".$row['miejsce_zarządzania']." <br/>";
       
       echo "<br/>";
       
       ?>
        <hr>
        <?php
       
         $zespol = sanitizeString($_GET['view']);
     
            
      $result=queryMysql("select login,termin.data,termin.czas_rozpoczecia,termin.czas_zakonczenia,orlik.nazwaorlika from administrator inner join rezerwacja on rezerwacja.Administrator_id=administrator.id inner join termin on termin.rezerwacja_id=rezerwacja.id right join orlik on termin.Orlik_id=orlik.id where nazwaorlika='$orlik' order by data ");
           


      

  $num    = $result->num_rows;
      
    

  echo "<h3>Terminy rezerwacji dla orlika</h3><ul>";
           ?>
        
        <table border=1 style='background-color:silver; float:center; border:3px solid blue;  '>
            <?php
       echo "<tr>";
    echo "<td>";
    echo "Data"."</td>";
    echo "<td>";
    echo "Czas rozpoczecia"."</td>";
    echo "<td>";
    echo "Czas zakończenia"."</td>";
        echo "<td>";
        echo "Konto"."</td>";
       echo "</tr>";
       
for ($j = 0 ; $j < $num ; ++$j)
  {
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
   
     
 
     echo "<tr>";
    echo "<td>";
    echo  $row['data']."</td>";
    echo "<td>";
    echo  $row['czas_rozpoczecia']."</td>";
    echo "<td>";
    echo  $row['czas_zakonczenia']."</td>";
    echo "<td>";
    echo  $row['login']."</td>";
      

       
   }
       
      echo "</tr>";  
       echo "</table>";
       
       
     
            
       $result=queryMysql("select login,termin.data,termin.czas_rozpoczecia,termin.czas_zakonczenia,orlik.nazwaorlika from konto_logowania inner join rezerwacja on rezerwacja.konto_logowania_id=konto_logowania.id inner join termin on termin.rezerwacja_id=rezerwacja.id right join orlik on termin.Orlik_id=orlik.id where nazwaorlika='$orlik' order by data");
           


      

  $num    = $result->num_rows;
      
    
?>
  <br>
        <table border=2 style='background-color:silver; float:center; border:3px solid blue;  '>
            <?php
       echo "<tr>";
    echo "<td>";
    echo "Data"."</td>";
    echo "<td>";
    echo "Czas rozpoczecia"."</td>";
    echo "<td>";
    echo "Czas zakończenia"."</td>";
        echo "<td>";
        echo "Konto"."</td>";
       echo "</tr>";
       
for ($j = 0 ; $j < $num ; ++$j)
  {
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
   
     
 
     echo "<tr>";
    echo "<td>";
    echo  $row['data']."</td>";
    echo "<td>";
    echo  $row['czas_rozpoczecia']."</td>";
    echo "<td>";
    echo  $row['czas_zakonczenia']."</td>";
    echo "<td>";
    echo  $row['login']."</td>";
      

       
   }
       
      echo "</tr>";  
       echo "</table>";
       
   }

      ?>
 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>