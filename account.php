<?php
include "useDb.php";
include "connect.php";
if (!isset($_SESSION))
{
    session_start();
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    echo ("Musisz się zalogować");
    header("Location: http://192.168.1.16/quizz/login.php");
    exit;
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
// Załadowanie danych użytkownika
// $user_name = $_SESSION["user_name"] ?? "Nieznane imię";
// $user_level = $_SESSION["user_level"] ?? "Brak poziomu";
// $final_score = $_SESSION["final_score"] ?? -1;
getDb($_SESSION["user_id"]);

$final_score = $_SESSION["final_score"];
$user_name = $_SESSION["user_name"];
$user_level = $_SESSION["user_level"];


if ($final_score == 0)
{
    $final_score = $_SESSION["last_score"];
}


debug_to_console($final_score);

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
        <h1>Witaj, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <div class="profile-info">
            <table>
                <tr>
                    <th>Imię</th>
                    <td><?php echo htmlspecialchars($user_name); ?></td>
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
