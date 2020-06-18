<?php
  require_once 'header.php';


if (!$loggedin) die("</div></body></html>");





  if (isset($_GET['view']))
  {
  

    @$orlik=sanitizeString($_GET['view']);
     @$email = sanitizeString($_POST['email']);
      @$imie = sanitizeString($_POST['imie']);
      @$nazwisko = sanitizeString($_POST['nazwisko']);
        @$telefon = sanitizeString($_POST['telefon']);
      @$adres = sanitizeString($_POST['adres']);
     @$timeroz = sanitizeString($_POST['timeroz']);
      @$timezak = sanitizeString($_POST['timezak']);
      @$kodpocztowy = sanitizeString($_POST['kod']);
      @$data= sanitizeString($_POST['data']);
    
     $result=queryMysql("select id from konto_logowania where login='".$_SESSION['login']."'");
    
 $row = $result->fetch_array(MYSQLI_ASSOC);
      $id=$row['id'];

    

    if ($email == "" || $imie == "" || $nazwisko == "" || $telefon == "" || $adres == "" || $kodpocztowy == "" || $timeroz == "" || $timezak == "" || $data == "" ){
     $_SESSION['blady']="Nie wszystkie pola zostały wypełnione";
    }
    
      else
    {
      $result1=queryMysql("SELECT termin.id FROM termin inner join orlik on termin.orlik_id=orlik.id where data='$data' and (('$timeroz' > czas_rozpoczecia and '$timeroz' < czas_zakonczenia) or ('$timezak' >= czas_rozpoczecia AND '$timezak' <= czas_zakonczenia) or ( '$timeroz' < czas_rozpoczecia AND '$timezak' > czas_zakonczenia))  and nazwaorlika='$orlik' ");

      if ($result1->num_rows) {
        $_SESSION['godziny']= "Ta godzina jest zajeta.<br><br>";
        
         
      }
      
      
      else 
      {  
          queryMysql("set autocommit=0");
          queryMysql("start transactiom");
          try{
            
         $result= queryMysql("INSERT INTO status_rezerwacji values(null,default,null)"); 
          if ($result===TRUE)
              $id_stat=mysqli_insert_id($connection);
          
$result=queryMysql("INSERT INTO rezerwacja values (null, '$imie', '$nazwisko', '$email','$telefon','$adres','$kodpocztowy','$id','$id_stat',null)"); 
                 
   if ($result===TRUE)
              $last_id=mysqli_insert_id($connection);
                    
           queryMysql("INSERT INTO termin () values (null,'$data','$timeroz','$timezak','$last_id',(select orlik.id from orlik where nazwaorlika='$orlik'))");          
           
$_SESSION['dod']=" Rezerwacja pomyślnie zrealiozowana";
       
    queryMysql("commit");
      }
          catch(Exception $a){
             echo $a->getMessage();
              queryMysql("rollback");
              
          }
      }
      }
 }
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
</head>
<body>

<div id="container" style="height:1200px; background-color:white;">
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
	
	<div id="blok_glowny" style="color:blue; ">
        
 <div class="row">
        
        <div class=" col-md-auto col2">
            <h1>Zarezerwuj termin orlika</h1>
            
            
             <?php
			if (isset($_SESSION['dod']))
			{
                ?>
				<div class="alert alert-success"><?php echo $_SESSION['dod'] ?> </div>
            <?php
				unset($_SESSION['dod']);
                }
              
			if (isset($_SESSION['blady']))
			{
				?> <div class="alert alert-warning"><?php echo $_SESSION['blady'] ?></div>
            <?php
				unset($_SESSION['blady']);
                }
                ?>
            
             <?php
			if (isset($_SESSION['godziny']))
			{
				?> <div class="alert alert-warning"><?php echo $_SESSION['godziny'] ?></div>
              <form method="post" action="daty.php?view=<?php echo $orlik ?>" target="_blank" >  
                
<button type="submit" class="btn btn-primary">Wyświetl rezerwacje na dany dzień</button>
            </form>

            <?php
				unset($_SESSION['godziny']);
                }
                ?>
            <form method="post" action="booking.php?view=<?php echo $orlik ?>">
                 <div class="form-group">
                    <label for="przykladoweImie">Imię</label>
                    <input type="text" class="form-control" name="imie"   placeholder="Podaj Imię">
               
                
                    <label for="przykladoweNazwisko">Nazwisko</label>
                    <input type="text" class="form-control" name="nazwisko" placeholder="Podaj Nazwisko">
                </div>
               <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="przykladowyEmail">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                  
                <div class="form-group col-md-6">
                        <label for="przykladowyTelefon">Telefon</label>
                        <input type="text" class="form-control" name="telefon" placeholder="Numer">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="przykladowyAdres">Adres</label>
                        <input type="text" class="form-control" name="adres" placeholder="Adres">
                    </div>
                  
                <div class="form-group col-md-6">
                        <label for="przykladowykod">Kod pocztowy</label>
                        <input type="text" class="form-control" name="kod" placeholder="Kod pocztowy">
                    </div>
                </div>
               <div class="form-group">
                    <label for="przykladowadata">Data  rezerwacji</label>
                    <input type="date" class="form-control" name="data" min="<?php  echo date("Y-m-d");?>"   placeholder="Podaj datę rezerwacji">
                </div>
                <div class="form-group">
                    <label for="przykladowadata">Czas Rozpoczecia rezerwacji</label>
                    <input type="time" step="1" class="form-control" name="timeroz"  placeholder="Podaj czas rozpoczęcia rezerwacji">
                </div>
                 <div class="form-group">
                    <label for="przykladowadata">Czas Zakonczenia rezerwacji</label>
                    <input type="time" step="1" class="form-control" name="timezak"  placeholder="Podaj czas zakonczenia rezerwacji">
                </div>
               
<button type="submit" class="btn btn-primary">Wyślij</button>
                
            
                
            </form>
        </div>
    </div>

 
    </div>
</div>
        

	
		
	</div>
	
    
      <script src="Scripts/jquery-3.0.0.js"></script>
    <script src="Scripts/bootstrap.js"></script>
</body>
</html>




