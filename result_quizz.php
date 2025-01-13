<?php
include "connect.php";
//przechwycenie sesji jeżeli nie istnieje
if (!isset($_SESSION))
  {
      session_start();
  }

//sprawdzene czy użytkownik jest zalogowany
if (!isset($_SESSION["user_id"])) {
    echo ("Musisz się zalogować");
    header("Location: http://192.168.1.16/quizz/login.php");
    exit;
}

  //sprawdzenie czy admin
  if ($_SESSION["is_admin"] == 1)
  {
  header("Location: http://192.168.1.16/quizz/admin.php");
  }


//sprawdzenie przesłania danych
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $questions = $_POST['questions'];
    $user_id = $_SESSION["user_id"];
    $score = 0;

    foreach ($questions as $question) {
        $question_id = $question['id'];
        $user_answer = $question['answer'];

        // Pobranie poprawnej odpowiedzi z bazy danych
        $sql = "SELECT correct_option FROM quiz_questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $correct_option = $result->fetch_assoc()["correct_option"];

        // Sprawdzenie odpowiedzi użytkownika
        if (strtolower($user_answer) === $correct_option) {
            $score++;
        }
    }

    // Obliczenie procentowego wyniku
    $total_questions = count($questions);
    $percentage = round(($score / $total_questions) * 100, 2);
    
    //ustalenie poziomu użytkownika
    if ($score <=2 )
    {
        $level = 1;
    }
    elseif ($score > 2 and $score <=4)
    {
        $level = 2;
    }
    elseif ($score == 5)
    {
        $level = 3;
    }

    //przypisanie poziomu do sesji 
    $_SESSION["user_level"] = $level;
    //przesłanie danych do bazy
    $sql_update = "UPDATE users SET score=?, level=? WHERE user_id=?";        
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("iii", $score, $level, $user_id);
    $stmt->execute();
    
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="result.css">
    <title>Wynik Quizu</title>
</head>
<body>
    <div class="result-container">
        <h1>Twój wynik</h1>
        <p>Zdobyłeś: <span class="score"><?php echo $score; ?></span> na <span class="total"><?php echo $total_questions; ?></span></p>
        <p>Twój wynik procentowy: <span class="percentage"><?php echo $percentage; ?>%</span></p>
        <p>Twój poziom to: <span class="score"><?php echo $level; ?></span></p>

        <a href="index.php" class="home-button">Wróć na stronę główną</a>
        <a href="mainquiz.php" class="home-button">Następny Poziom</a>
    </div>
</body>
</html>
