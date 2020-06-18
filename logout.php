<?php
  require_once 'header.php';

  if (isset($_SESSION['login']))
  {
    destroySession();
    echo "<br><div class='center'>Wylogowanie prawidłowe. 
         <a data-transition='slide' href='index.php'>Kliknij tutaj</a>,
         aby odświeżyć stronę.</div>";
  }
  else echo "<div class='center'>Nie możesz się wylogować, bo nie jesteś zalogowany(a)</div>";
?>
    </div>
  </body>
</html>
