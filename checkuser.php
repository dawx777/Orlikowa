<?php
  require_once 'functions.php';
  if (isset($_POST['login']))
  {
    $user   = sanitizeString($_POST['login']);
    $result = queryMysql("SELECT login FROM konto_logowania WHERE login='$user'");

    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "Nazwa '$user' już istnieje.</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "Nazwa '$user' jest dostępna.</span>";
  }
?>
