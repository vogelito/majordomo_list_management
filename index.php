<?php
  include("vars.php");
?>
<html>
<head><title><?php echo $club_name; ?> Mailing List Unsubscribe</title></head>
<body>
  <h1><center><?php echo $club_name; ?> Mailing List Unsubscribe!</center></h1>
  <form action="handler.php" method="post">
    <input type="hidden" name="type" value="remove">
    E-mail to remove: <input type="text" name="email"><br>
    <input type="submit">
  </form>

</body>
</html>
