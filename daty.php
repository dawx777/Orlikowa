<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>

<body>
  <?php

  require_once 'header.php';

  if (!$loggedin) die("</div></body></html>");

    
    
      

    
        $max_words = 5; 
$max_length = 50; 
        
        if ( !isset($_POST['submit']) )
{
            ?>
	<h1>Wyszukiwarka daty rezerwacji</h1><br><br>
	<form action="daty.php?view=<?php echo $_GET['view'] ?>" method="post">
	Szukaj daty rezerwacji orlika w swoim miejscu <span style="color: red; font-weight: bold;">*</span> <input type="date" name="fraza" style="width: 200px;" maxlength="'.$max_length.'"><br>
	<input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
	</form>
    
    <?php
}
      
else
{
	$search_words = sanitizeString($_POST['fraza']);
	
	
	

  

   
	
	
	$result = queryMysql("select login,termin.data,termin.czas_rozpoczecia,termin.czas_zakonczenia,orlik.nazwaorlika from konto_logowania inner join rezerwacja on rezerwacja.konto_logowania_id=konto_logowania.id inner join termin on termin.rezerwacja_id=rezerwacja.id right join orlik on termin.Orlik_id=orlik.id where termin.data LIKE '".$search_words."'and orlik.nazwaorlika='".$_GET['view']."' union  select login,termin.data,termin.czas_rozpoczecia,termin.czas_zakonczenia,orlik.nazwaorlika from administrator inner join rezerwacja on rezerwacja.Administrator_id=administrator.id inner join termin on termin.rezerwacja_id=rezerwacja.id right join orlik on termin.Orlik_id=orlik.id where termin.data LIKE '".$search_words."'and orlik.nazwaorlika='".$_GET['view']."' group by termin.czas_rozpoczecia ");
     
    $num    = $result->num_rows;
		if ( $num == 0 )
	{
		echo "Nie znaleziono pasujących.";
		exit;
	}
    else
    {
	
	echo "<h3>Terminy rezerwacji dla orlika na dany dzień </h3><ul>";
           ?>
        
        <table border=1 style='background-color:silver; float:center; border:3px solid blue; '>
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
     
    

     
         
      
       
}
		
	




      


      
 
?>
        </body>

</html>       
    