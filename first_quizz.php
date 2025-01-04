<?php
// Dodanie pliku do obsługi połączenia z bazą danych
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

$basic_cat = "basic";
$medium_cat = "medium";
$advanced_cat = "advanced";
$user_id = $_SESSION["user_id"];

// Funkcja losowania pytań
function getQuestions($conn, $category, $limit) {
    $sql = "SELECT * FROM quiz_questions WHERE category = ? ORDER BY RAND() LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Losowanie pytań oraz ich połączenie
$pytaniaLatwe = getQuestions($conn, $basic_cat, 2);
$pytaniaSrednie = getQuestions($conn, $medium_cat, 2);
$pytaniaTrudne = getQuestions($conn, $advanced_cat, 1);
$pytania = array_merge($pytaniaLatwe, $pytaniaSrednie, $pytaniaTrudne);

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
        <form action="result_quizz.php" method="POST">
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
