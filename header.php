<?php 


 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }


echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content=" width=device-width, initial-scale=1">

    <title>Strona orlikowa</title>
    <link rel="stylesheet" type="text/css" href="Content/bootstrap.css">
    <link rel="stylesheet" href="Content/style.css">


_INIT;

  require_once 'functions.php';

  $userstr = 'Witaj, gościu';
    
   if (isset($_SESSION['login']))
  {
       
    $user     = $_SESSION['login'];
    $loggedin = TRUE;
    $userstr  = "Zalogowany jako: $user";
       
  }
  else $loggedin = FALSE;
   
  
   
   




  if ($loggedin)
  {
?>
       
        
        
      
        
<?php
  }
  else
  {
?>
      
        <p class='info'>(Aby skorzystać z tej aplikacji, musisz być zalogowany).</p>
        <div class='center'>
       
        
<?php
  }
?>
