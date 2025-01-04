<?php
  if (!isset($_SESSION))
  {
      session_start();
  }

//konfiguracja połączenia z bazą
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "quizz";

//utworzenie połączenia
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$_SESSION["db"] = $conn;
$_SESSION['alert'] = -1;

// Sprawdź połączenie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
?>
