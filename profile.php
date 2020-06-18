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

<div id="container" style="height:auto; background-color:#E7FBE9 ">
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
	
	<div id="blok" style="background-image: url('tlo.jpg'); height:auto">
<?php
  echo "<h3>Twój profil</h3>";

  $result = queryMysql("SELECT konto_logowania.id,login FROM konto_logowania inner join profil on profil.konto_logowania_id=konto_logowania.id where login='$user' ");
$result1=queryMysql("Select konto_logowania.id from konto_logowania inner join profil on profil.konto_logowania_id=konto_logowania.id where login='$user'");

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    
      
      

    if ($result->num_rows)
        
         queryMysql("UPDATE profil left join konto_logowania on  profil.konto_logowania_id=konto_logowania.id SET text='$text',konto_logowania_id=konto_logowania.id where login='$user'");
     
   else
        queryMysql("INSERT INTO profil  VALUES(null,'$text',(Select konto_logowania.id from konto_logowania where login='$user'))");
  }
  else
  {
    if ($result->num_rows)
    {
      $row  = $result->fetch_array(MYSQLI_ASSOC);
      @$text = stripslashes($row['text']);
    }
    else $text = "";
  }

  $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Zwykłe i progresywne obrazy jpeg
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

  showProfile($user);
?>
<hr>
<?php
$result = queryMysql("SELECT imie,nazwisko,dataurodzenia,miasto,adres,kodpocztowy,konto_logowania.email FROM klient inner join konto_logowania on klient.konto_logowania_id=konto_logowania.id  where login='$user'");
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
  


$result = queryMysql("SELECT zespol FROM czlonkowie where login='$user'");
  $num    = $result->num_rows;
?>
<hr>
<a data-transition='slide'
      href='haslo.php' class="btn btn-primary">KLIKNIJ JEŚLI CHCESZ ZMIENIĆ HASŁO</a>
<hr>
<?php

  echo "<h3>Czlonek zespołu</h3>";

 
    $row = $result->fetch_array(MYSQLI_ASSOC);
if($row){
         echo "<a  href='czlonkowie.php?view=" .
      $row['zespol'] . "'>" . $row['zespol'] . "</a>";
}
else {  echo "Nie nazleżysz jeszcze do żadnego klubu";
     }

  ?>
<hr>
<?php
  
  
 $result=queryMysql("select rezerwacja.id,termin.data,termin.czas_rozpoczecia,termin.czas_zakonczenia,orlik.nazwaorlika,status_rezerwacji.status from konto_logowania,rezerwacja,termin,status_rezerwacji,orlik where rezerwacja.konto_logowania_id=konto_logowania.id and termin.rezerwacja_id=rezerwacja.id and termin.Orlik_id=orlik.id and rezerwacja.status_rezerwacji_id=status_rezerwacji.id and login='$user' ");
  

  
      

  $num    = $result->num_rows;
       ?>
  <table border=1 style='background-color:silver; border:3px solid black;'>
      <?php
         echo "<tr style='background-color:white;'>";
   echo "<td>";
    echo "ID"."</td>";
    echo "<td>";
    echo "Data"."</td>";
    echo "<td>";
    echo "Czas rozpoczecia"."</td>";
    echo "<td>";
    echo "Czas zakończenia"."</td>";
    echo "<td>";
     echo "Nazwa orlika"."</td>";
    echo "<td>";
     echo "Status rezerwacji"."</td>";
      echo "<td>";
     echo "Usuń rezerwację"."</td>";
        
        
   echo "</tr>";

 echo "<h3>Bieżace rezerwacje użytkownika</h3>";
for ($j = 0 ; $j < $num ; ++$j)
{
   
    $row = $result->fetch_array(MYSQLI_ASSOC);
    
    
  echo "<tr>";
   echo "<td>";
    echo $row['id']."</td>";
    echo "<td>";
    echo  $row['data']."</td>";
    echo "<td>";
    echo  $row['czas_rozpoczecia']."</td>";
    echo "<td>";
    echo  $row['czas_zakonczenia']."</td>";
    echo "<td>";
     echo  $row['nazwaorlika']."</td>";
    echo "<td>";
     echo  $row['status']."</td>";
   
      
if (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
      
    
    
    queryMysql("DELETE termin,rezerwacja,status_rezerwacji from termin inner join rezerwacja on termin.rezerwacja_id=rezerwacja.id inner join status_rezerwacji on status_rezerwacji.id=rezerwacja.status_rezerwacji_id where rezerwacja.id='". $row['id']."' and rezerwacja.id='$remove' ");
  header('Location:profile.php');
    
  }
  echo "<td>";
    
    ?>
        <form  method='post'
        action='profile.php?remove=<?php echo $row['id'] ?>' >
            <input type='submit' value='ANULUJ REZERWACJE' class="btn btn-danger">
</form>
     
    <?php
     echo "</td>";

}
echo "</tr>";
echo "</table>";
  
      
      
      


      
      
?>
<hr>

      <form data-ajax='false' method='post'
        action='profile.php' enctype='multipart/form-data'>
      <h3>Wpisz lub zmień swoje dane i (lub) wyślij zdjęcie.</h3>
      <textarea name='text'><?php echo $text ?></textarea><br>
      Obraz: <input type='file' name='image' size='14'>
      <input type='submit' value='Zapisz profil' class="btn btn-primary">
      </form>
      </div>
    

    </div>

 
    </div>

        

	
		
	
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>




