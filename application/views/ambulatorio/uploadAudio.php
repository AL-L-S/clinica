<?php
include('db.php');
$session_id='1';
if($_POST['audiosrc'] && !empty($session_id))
{
$audiosrc=$_POST['audiosrc'];
$result = pg_query($dbcon, "INSERT INTO newsfeed (user_id_fk, audioMessage) VALUES ( $session_id, '$audiosrc')");
//$query=mysqli_query($db,"INSERT INTO `newsfeed` (`user_id_fk`, `audioMessage`) VALUES ( '$session_id', '$audiosrc')")or die(mysqli_error($db));

}
?>
