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
  if (isset($_GET['view']))
  {
       $rywal = sanitizeString($_GET['view']);
 $result = queryMysql("SELECT zespol,rywal FROM mecz where rywal='$rywal'");
$num    = $result->num_rows;

  echo "<h3>Zoragnizowany mecz</h3><ul>";
 for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
  

     echo $row['zespol']." "."VS"." ".$row['rywal'];
    
     
    echo "<hr>";
 }
    
  }


?>
 <form  method="post" action='spotkanie.php?view=<?php echo $row['rywal'] ?>'>
				<div class="druzyna"><span class="red">Wybór drużyny</span><p>
					Twoja drużyna: 
					<select name="nazwa">
					<?php
						for($i=0; $i<=$j-1; $i++){
						echo" <option> ".$row['zespol']."</option> ";
						}
					?> 	
					</select>
					vs 
					<select name="nazwa2">
					<?php
						for($i=0; $i<=$j-1; $i++){
						echo"<option>".$row['rywal']."</option>";
						}
					?> 
					</select>
					:Twój przeciwnik 
				</div>	
 <hr>
				<div class="wynik"><span class="red">Wynik meczu</span><p>
					 <input type="text" name="wynikspotkania" id="wynikspotkania" placeholder="np.2:1" />
					
				</div>	
				<div class="przycisk">
						<button type="submit" class="btn btn-primary">Wyślij</button>
				</div>
				
 
    </form>

        
         <?php

@$wynikspotkania=sanitizeString($_POST['wynikspotkania']);
    $result=queryMysql("insert into wynik values(null,'$wynikspotkania',(select mecz.id from mecz where rywal='$rywal'))");
if($result==TRUE){
}

    
?>
        
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>
  