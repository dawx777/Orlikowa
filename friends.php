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

<div id="container" style="height:1400px; background-color:#E7FBE9 ">
<div id="kontener">
	<div id="baner">
	<img src="logo.png"  style="margin-top:5px; margin-left:28%;" />
		
	</div>
	<div class="menu" style="height:70px;">
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
        
  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if ($view == $user)
  {
    $name1 = $name2 = "Twoje ";
    $name3 =          "Ty ";
  }
  else
  {
    $name1 = "<a data-transition='slide'
              href='members.php?view=$view'>$view</a>";
    $name2 = "$view - jej/jego";
    $name3 = "$view ";
  }

  // Usuń komentarz z poniższej linii, jeśli chcesz wyświetlić profil użytkownika
  // showProfile($view);

  $followers = array();
  $following = array();

  $result = queryMysql("SELECT * FROM przyjaciele WHERE login='$view'");
  $num    = $result->num_rows;

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row           = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['przyjaciel'];
  }

  $result = queryMysql("SELECT * FROM przyjaciele WHERE przyjaciel='$view'");
  $num    = $result->num_rows;

  for ($j = 0 ; $j < $num ; ++$j)
  {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['login'];
  }

  $mutual    = array_intersect($followers, $following);
  $followers = array_diff($followers, $mutual);
  $following = array_diff($following, $mutual);
  $friends   = FALSE;

  echo "<br>";

  if (sizeof($mutual))
  {
    echo "<span class='subhead'>$name2 znajomości</span><ul>";
    foreach($mutual as $friend)
      echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }
  if (sizeof($followers))
  {
    echo "<span class='subhead'>$name2 grono obserwatorów</span><ul>";
    foreach($followers as $friend)
      echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (sizeof($following))
  {
    echo "<span class='subhead'>$name3 obserwuje(sz)</span><ul>";
    foreach($following as $friend)
      echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (!$friends) echo "<br>Nie masz jeszcze żadnych znajomości.<br><br>";

  
?>
        <a data-role='button' data-transition='slide' class="btn btn-primary" href='messages.php?view=<?php echo $view ?>'>Wyświetl wiadomości: <?php echo $name2 ?></a>   


    </div>

 
    </div>
</div>
        

	
		
	
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>
