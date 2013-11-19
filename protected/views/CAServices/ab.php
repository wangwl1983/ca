<?php

echo file_get_contents('php://input');
echo file_get_contents('php://input');
echo file_get_contents('php://input');
var_dump(file_get_contents('php://input'));
var_dump(file_get_contents('php://input'));
?>
<form method="post">
    <input type="text" name="ab" />
    <input type="submit" value="Submit" />
</form>