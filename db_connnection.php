<?php

function OpenCon()
{
$dbhost = ""; //hostname
$dbuser = ""; //username
$dbpass = ""; //pass
$db = ""; //database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". mysqli_error($conn));

return $conn;
}

function CloseCon($conn)
{
mysqli_close($conn);
}

?>