<?php
// Rozpoczęcie sesji
session_start();

// Usunięcie wszystkich zmiennych sesji
session_unset();

// Zniszczenie sesji
session_destroy();

// Przekierowanie na stronę logowania lub inną stronę
header("Location: login.php");
exit;
?>
