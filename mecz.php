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
	
	<div id="blok_glowny" style="color:blue; background-color:#E7FBE9">
        <?php
        
  if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);
      

    $result = queryMysql("SELECT mecz.zespol,mecz.rywal FROM mecz inner join czlonkowie on czlonkowie.id=mecz.id_czlonkowie
      WHERE mecz.zespol=czlonkowie.zespol AND mecz.rywal='$add' and czlonkowie.id=rywal_id and id_czlonkowie=czlonkowie.id ");
    if (!$result->num_rows)
      $result=queryMysql("INSERT INTO mecz VALUES (null,(select czlonkowie.zespol from czlonkowie where login='$user') ,'$add',(select czlonkowie.id from czlonkowie where login='$user'),(select czlonkowie.id from czlonkowie where zespol='$add'))");
  }
  
  if (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE mecz FROM mecz inner join czlonkowie on czlonkowie.id=mecz.id_czlonkowie WHERE mecz.zespol=czlonkowie.zespol AND mecz.rywal='$remove'   ");
  }

  $result = queryMysql("select zespol from czlonkowie where zespol not like(select czlonkowie.zespol from czlonkowie where login like '$user')");
  $num    = $result->num_rows;

  echo "<h3>Wyzywij zespol</h3><ul>";

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    
    
    echo "<li><a data-transition='slide' href='czlonkowie.php?view=" .
      $row['zespol'] . "'>" . $row['zespol'] . "</a>";
  
    $follow = "WYZWIJ";
      
       

$result1 = queryMysql("SELECT * FROM mecz WHERE
      mecz.rywal='" . $row['zespol'] . "'  ");

       
    $t1      = $result1->num_rows;
  $result1 = queryMysql("SELECT * FROM mecz where
      mecz.zespol='" . $row['zespol'] . "'   ");

      
    $t2      = $result1->num_rows;
  
    if (($t1 + $t2) > 1) echo " &harr; WYZWANIE PRZYJĘTE";
    elseif ($t1)         echo " &larr; TY WYZWAŁEŚ";
    elseif ($t2)       { echo " &rarr; WYZWAŁ CIĘ";
                         $follow = "WYZWIJ"; }
      
      
  
    if (!$t1) { ?> <a data-transition='slide'
      href='mecz.php?add=<?php echo $row['zespol'] ?>' class="btn btn-success"><?php echo $follow ?></a>
<?php }
    else {     ?>  <a data-transition='slide'
      href='mecz.php?remove=<?php echo $row['zespol'] ?> ' class="btn btn-warning">usuń</a>
      <?php }
      
      if($t1+$t2>1) { ?>
           <a data-transition='slide'
      href='spotkanie.php?view=<?php echo $row['zespol'] ?> ' class="btn btn-primary">PRZEJDŹ DO PRZEBUEGU</a>
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