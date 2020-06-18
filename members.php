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

<div id="container" style="height:1400px; background-color:#E7FBE9">
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
        
 
        <?php
   if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    
    if ($view == $user) $name = "(ja)";
    else                $name = "$view";
    
    echo "<h3>Profil użytkownika $name</h3>";
    showProfile($view);
      ?>
            <a data-role='button' data-transition='slide' class="btn btn-primary" href='messages.php?view=<?php echo $view ?>'>Wyświetl wiadomości: <?php echo $name ?></a> 
   <hr>
      <?php
      $result = queryMysql("SELECT imie,nazwisko,dataurodzenia,miasto,adres,kodpocztowy,konto_logowania.email FROM klient inner join konto_logowania on klient.konto_logowania_id=konto_logowania.id  where login='$view'");
  $num    = $result->num_rows;

  echo "<h3>Informacje o użytkowniku</h3>";
    $row = $result->fetch_array(MYSQLI_ASSOC);


echo "<br/>";
    echo "Imię: "." ". $row['imie']."<br/>";
    echo "<br/>";
    echo "Nazwisko: "." ". $row['nazwisko']."<br/>";
    echo "<br/>";
    echo "Data urodzenia: "." ". $row['dataurodzenia']."<br/>";
    echo "<br/>";
    echo "Miasto: "." ". $row['miasto']."<br/>";
    echo "<br/>";
       echo "Adres zamieszkania: "." ". $row['adres']."<br/>";
    echo "<br/>";
    echo "Kod pocztowy: "." ". $row['kodpocztowy']."<br/>";
    echo "<br/>";
     echo "Adres email: "." ". $row['email']."<br/>";
    echo "<br/>";
      
      
      
      $result = queryMysql("SELECT zespol FROM czlonkowie where login='$view'");
  $num    = $result->num_rows;
      ?>
<hr>
<?php

  echo "<h3>Czlonek zespołu</h3>";

 
    $row = $result->fetch_array(MYSQLI_ASSOC);
if($row){
         echo "<a  href='czlonkowie.php?view=" .
      $row['zespol'] . "'>" . $row['zespol'] . "</a>";
}
else {  echo "Nie nazleży jeszcze do żadnego klubu";
     }
    die("</div></body></html>");
      

  }

  if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM przyjaciele 
      WHERE login='$add' AND przyjaciel='$user'");
    if (!$result->num_rows)
      queryMysql("INSERT INTO przyjaciele VALUES (null,'$add', '$user')");
  }
  elseif (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM przyjaciele WHERE login='$remove' AND przyjaciel='$user'");
  }

  $result = queryMysql("SELECT login FROM konto_logowania where login not like 'administrator' ORDER BY login");
  $num    = $result->num_rows;

  echo "<h3>Inni użytkownicy</h3><ul>";

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['login'] == $user) continue;
    
    echo "<li><a data-transition='slide' href='members.php?view=" .
      $row['login'] . "'>" . $row['login'] . "</a>";
    $follow = "obserwuj";

    $result1 = queryMysql("SELECT * FROM przyjaciele WHERE
      login='" . $row['login'] . "' AND przyjaciel='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM przyjaciele WHERE
      login='$user' AND przyjaciel='" . $row['login'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; jesteście znajomymi";
    elseif ($t1)         echo " &larr; Ty obserwujesz";
    elseif ($t2)       { echo " &rarr; obserwuje Ciebie";
                         $follow = "odwzajemnij"; }
    
    if (!$t1) { ?> <a data-transition='slide' 
      href='members.php?add=<?php echo $row['login'] ?>' class="btn btn-primary"><?php echo $follow ?></a>
    <?php } else { ?>     <a data-transition='slide'
      href='members.php?remove=<?php echo $row['login'] ?>' class="btn btn-danger">usuń</a>
<?php 
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

