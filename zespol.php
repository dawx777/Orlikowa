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

<div id="container" style="height:1400px; background-color:#E7FBE9;">
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

if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM czlonkowie  
      WHERE login='$user' AND zespol='$add'");
    if (!$result->num_rows)
      queryMysql("INSERT INTO czlonkowie VALUES (null,'$user', '$add',(select konto_logowania.id from konto_logowania where login='$user'),(select zespół.id from zespół where Nazwa='$add'))");
    //queryMysql("update klient inner join czlonkowie on klient.czlonkowie_id=czlonkowie.id where login='$user' set kilent.zespol_id=czlonkowie.id")
  }
  elseif (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE czlonkowie from czlonkowie left join mecz on mecz.id_czlonkowie=czlonkowie.id left join wynik on wynik.mecz_id=mecz.id  WHERE czlonkowie.login='$user' AND czlonkowie.zespol='$remove'");
  }

 $result = queryMysql("SELECT Nazwa FROM zespół  ORDER BY Nazwa");
$num    = $result->num_rows;

  echo "<h3>Zespoły</h3><ul>";
 for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    

    echo "<li><a data-transition='slide' href='czlonkowie.php?view=" .
      $row['Nazwa'] . "'>" . $row['Nazwa'] . "</a>";

 $follow = "DOŁĄCZ!";

    $result1 = queryMysql("SELECT * FROM czlonkowie  WHERE
       login='$user' AND zespol='" . $row['Nazwa'] . "'");
    $t1      = $result1->num_rows;
   

   
    if ($t1)         echo " &larr; Dołączyłeś do zepsołu";
   
    
    if (!$t1) { ?>  <a data-transition='slide'
      href='zespol.php?add=<?php echo $row['Nazwa'] ?> ' class="btn btn-success"><?php  echo $follow ?></a>
<?php }    else  { ?>   <a data-transition='slide'
      href='zespol.php?remove=<?php echo $row['Nazwa'] ?> ' class="btn btn-warning">usuń</a>
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