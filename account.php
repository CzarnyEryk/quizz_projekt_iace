<?php
include "useDb.php";
include "connect.php";

//sprawdzenie czy sesja istnieje
if (!isset($_SESSION))
{
    session_start();
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    header("Location: http://192.168.1.16/quizz/login.php");
    exit;
}


// Załadowanie danych użytkownika z bazy (odśwież)
getDb($_SESSION["user_id"]);

//przypisane danych z sesji do zmiennych (łatwiejsza obsługa)
$final_score = $_SESSION["final_score"];
$user_name = $_SESSION["user_name"];
$user_surname = $_SESSION["user_surname"];
$user_level = $_SESSION["user_level"];
$_SESSION['alert_raport'] = -1;


//sprawdzenie czy użytkownik wykonał test końcowy i przypisanie danych
if ($final_score == -1)
{
    $final_score = $_SESSION["last_score"];
}

?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Profil użytkownika</title>
</head>
<body>
    <div class="container">
    
        <!-- Wyświetlenie imienia użytkownika -->
        <h1>Witaj, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <!-- Wyświetlenie danych o użytkowniku -->
        <div class="profile-info">
            <table>
                <tr>
                    <th>Imię</th>
                    <td><?php echo htmlspecialchars($user_name); ?></td>
                </tr>
                <tr>
                <th>Nazwisko</th>
                <td><?php echo htmlspecialchars($user_surname); ?></td>
                </tr>
                <tr>
                    <th>Poziom</th>
                    <td><?php echo htmlspecialchars($user_level); echo "/3"?></td>
                </tr>
                <tr>
                    <th>Ostatni wynik testu</th>
                    <td><?php echo htmlspecialchars($final_score); echo "/10"?></td>
                </tr>
            </table>
        </div>
        <div class="actions">
            <a href="mainquiz.php" class="btn">Rozpocznij quiz</a>
            <a href="make_raport.php" class="btn">Raport</a>
            <a href="index.php" class="btn secondary">HOME</a>
        </div>
    </div>
</body>
</html>
