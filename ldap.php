<?php
$data=json_decode(file_get_contents('available_users.json'));
$regex='/'.preg_quote($_GET['term']).'/i';
$r=preg_grep($regex,$data);
if ($r!==false) echo json_encode(array_values($r));
?>