
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
        if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
      $pm   = substr(sanitizeString($_POST['pm']),0,1);
      $time = date('Y-m-d H:i:s');
      queryMysql("INSERT INTO wiadomosc VALUES(NULL, '$user',
        '$view','$pm', '$time', '$text')");
    }
  }

  if ($view != "")
  {
    if ($view == $user) $name1 = $name2 = "Twoje";
    else
    {
      $name1 = "<a href='members.php?view=$view'>$view</a> - jej/jego";
      $name2 = "$view - jej/jego";
    }

    echo "<h3>$name1 wiadomości</h3>";
    showProfile($view);
    
?>

      <form method='post' action='messages.php?view=<?php echo $view ?>'>
        <fieldset data-role="controlgroup" data-type="horizontal">
          <legend>Poniżej wpisz treść wiadomości:</legend>
          <input type='radio' name='pm' id='public' value='0' checked='checked'>
          <label for="public">Publiczna</label>
          <input type='radio' name='pm' id='private' value='1'>
          <label for="private">Prywatna</label>
        </fieldset>
      <textarea name='text'></textarea>
      <input data-transition='slide' type='submit' class="btn btn-primary" value='Wyślij wiadomość'>
    </form><br>
<?php

    date_default_timezone_set('UTC');

    if (isset($_GET['erase']))
    {
      $erase = sanitizeString($_GET['erase']);
      queryMysql("DELETE FROM wiadomosc WHERE id=$erase AND recip='$user'");
    }
    
    $query  = "SELECT * FROM wiadomosc WHERE recip='$view' ORDER BY czas DESC";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['pm'] == 0 || $row['autor'] == $user ||
          $row['recip'] == $user)
      {
        echo date($row['czas']);
        echo " <a href='messages.php?view=" . $row['autor'] .
             "'>" . $row['autor']. "</a> ";

        if ($row['pm'] == 0)
          echo "Pisze: &quot;" . $row['tekst'] . "&quot; ";
        else
          echo "Prywatnie: <span class='whisper'>&quot;" .
            $row['tekst']. "&quot;</span> ";

        if ($row['recip'] == $user)
            
          echo "<a href='messages.php?view=$view" .
               "&erase=" . $row['id'] . "' class='btn btn-primary'>usuń</a>";

        echo "<br>";
      }
    }
  }

  if (!$num)
    echo "<br><span class='info'>Brak wiadomości.</span><br><br>";

  echo "<br><a data-role='button'
        href='messages.php?view=$view' class='btn btn-danger'>Odśwież wiadomości</a>";
?>
  
 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>