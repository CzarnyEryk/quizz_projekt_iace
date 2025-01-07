<!-- Plik do połączenia z bazą danych -->
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

//przekazanie połączenia z bazą danych do sesji
$_SESSION["db"] = $conn;
// Sprawdź połączenie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
?>
