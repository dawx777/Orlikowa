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
	
	<div id="blok_glowny" style="color:blue; background-color:#E7FBE9  ">
        
  <?php
        $max_words = 5; 
$max_length = 50; 
        
        if ( !isset($_POST['submit']) )
{
            ?>
	<h1>Wyszukiwarka miejscowego orlika</h1><br><br>
	<form action="orlik.php" method="post">
	Szukaj orlika w swoim miejscu <span style="color: red; font-weight: bold;">*</span> <input type="post" name="fraza" style="width: 200px;" maxlength="'.$max_length.'"><br>
	<input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
	</form>
	
	<?php
}
else
{
	$search_words = sanitizeString($_POST['fraza']);
	$search_words = mysqli_real_escape_string($connection,$search_words);
	$count_words = substr_count($search_words, ' ');
	
	if ( ($count_words + 1) > ($max_words) )
	{
		echo "Użyłeś za wiele słów";
		exit;
	}
	
	$search_words = str_replace("*", "%", $search_words);
	
	$result = queryMysql("SELECT nazwaorlika FROM orlik WHERE miejscowość LIKE '".$search_words."'");
	
	$num = mysqli_num_rows($result);
	if ( $num == 0 )
	{
		echo "Nie znaleziono pasujących.";
		exit;
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
            echo "<h3>Wyszukane orliki </h3><ul>";
			$body_search = $row['nazwaorlika'].'<br>';
            echo "<li><a data-transition='slide' href='orliki.php?view=" .
      $row['nazwaorlika'] . "'>" . $row['nazwaorlika'] . "</a>"."</br>";
            ?>
            <a data-transition='slide'
      href='booking.php?view=<?php echo $row['nazwaorlika'] ?>' class="btn btn-success">REZERWUJ TERMIN</a>
<?php
		}
		
	}
}


?>
        <hr>
    <br><br>
        
    <?php



 $result = queryMysql("SELECT nazwaorlika FROM orlik  ORDER BY nazwaorlika");
$num    = $result->num_rows;

  echo "<h3>Dostępne orliki</h3><ul>";
 for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
  

    echo "<li><a data-transition='slide' href='orliki.php?view=" .
      $row['nazwaorlika'] . "'>" . $row['nazwaorlika'] . "</a>"."</br>";
     
     ?>
<a data-transition='slide'
      href='booking.php?view=<?php echo $row['nazwaorlika'] ?>' class="btn btn-primary">REZERWUJ TERMIN</a>
 
   
    <?php
   
    
  }


?>
 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>