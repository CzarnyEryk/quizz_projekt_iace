<?php
// Dodanie pliku do obsługi połączenia z bazą danych
include "connect.php";
include "useDb.php";

//przechywcenie sesji jeżeli nie istnieje :( 
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



//ustalenie kategorii pytań
$basic_cat = "basic";
$medium_cat = "medium";
$advanced_cat = "advanced";
$user_id = $_SESSION["user_id"];

//pobranie aktualnych danych z bazy
getDb($user_id);

//jeżeli użytkownik jest na max poziomie i ma max ilość punktów zwróć informację
if ($_SESSION["user_level"] == 3 and $_SESSION["final_score"] == 10)
{
    $_SESSION['alert'] = 1;
    header("Location: http://192.168.1.16/quizz/index.php");
}

// Funkcja losowania pytań
function getQuestions($conn, $category) {
    $sql = "SELECT * FROM quiz_questions WHERE category = ? ORDER BY RAND()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Losowanie pytań zgodnie z kategorią po wykonaniu testu sprawdzającego

if ($_SESSION["user_level"] == 1)
{
    $pytania = getQuestions($conn, $basic_cat);
}
else if ($_SESSION["user_level"] == 2)
{
    $pytania = getQuestions($conn, $medium_cat);
}
elseif ($_SESSION["user_level"] == 3)
{
    $pytania = getQuestions($conn, $advanced_cat);
}



?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="quizz.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz</title>
    </head>
    <body>
        <h1>Quiz</h1>
        <form action="final_result.php" method="POST">
            <?php foreach ($pytania as $index => $pytanie): ?>
                <div>
                    <p><strong><?php echo htmlspecialchars($pytanie["question"]); ?></strong></p>
                    <input type="hidden" name="questions[<?php echo $index; ?>][id]" value="<?php echo $pytanie["id"]; ?>">
                    <input type="radio" name="questions[<?php echo $index; ?>][answer]" value="A" required> <?php echo htmlspecialchars($pytanie["option_a"]); ?><br>
                    <input type="radio" name="questions[<?php echo $index; ?>][answer]" value="B" required> <?php echo htmlspecialchars($pytanie["option_b"]); ?><br>
                    <input type="radio" name="questions[<?php echo $index; ?>][answer]" value="C" required> <?php echo htmlspecialchars($pytanie["option_c"]); ?><br>
                    <input type="radio" name="questions[<?php echo $index; ?>][answer]" value="D" required> <?php echo htmlspecialchars($pytanie["option_d"]); ?><br>
                </div>
            <?php endforeach; ?>
            <button type="submit">Zatwierdź odpowiedzi</button>
        </form>
    </body>
</html>

</html>
