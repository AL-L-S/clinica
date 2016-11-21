<?php
$bdcon = pg_connect("host=localhost port=5432 dbname=clinica user=postgres password=123456");
$result = pg_query($bdcon, "INSERT INTO newsfeed (user_id_fk, audioMessage) VALUES ( 1, '3')");
$session_id='1';
if($_POST['audiosrc'] && !empty($session_id))
{
$audiosrc=$_POST['audiosrc'];
$result = pg_query($bdcon, "INSERT INTO newsfeed (user_id_fk, audioMessage) VALUES ( $session_id, '$audiosrc')");
//$query=mysqli_query($db,"INSERT INTO `newsfeed` (`user_id_fk`, `audioMessage`) VALUES ( '$session_id', '$audiosrc')")or die(mysqli_error($db));

}
?>
