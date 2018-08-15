<!DOCTYPE html>
<html>
<body>
<?php

$text_entry = $_POST['tcur'];
$amount = $_POST['amount'];
$result = "";


{
   $result= ($text_entry / $amount);
   echo ($result);
}

?>
</body>
</html>