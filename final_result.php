<?php
include "connect.php";
include "useDb.php";

//sprawdzenie czy jest ustawiona sesja
if (!isset($_SESSION))
{
    session_start();
}

//sprawdzenie czy użytkownik jest zalogowany w celu pokazania zasobów
if (!isset($_SESSION["user_id"])) {
    header("Location: http://192.168.1.16/quizz/login.php");
    exit;
}

if ($_SESSION["is_admin"] == 1)
{
    header("Location: http://192.168.1.16/quizz/admin.php");
}

//odebranie danych z formularza po wykonaniu testu
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //przypisanie danych do zmiennych
    $questions = $_POST['questions'];
    $user_id = $_SESSION["user_id"];
    $level = $_SESSION['user_level'];
    //wyzerowanie punktów użytkownika
    $score = 0;
    //przygotwanie informacji dla użytkownika
    $info = "";
    //pętla do sprawdzenia czy odpowiedź jest poprawna
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
            //dodanie punktów jeżeli odpowiedź jest poprawna
            $score++;
        }
    }

    // Obliczenie procentowego wyniku
    $total_questions = count($questions);
    $percentage = round(($score / $total_questions) * 100, 2);
    
    //awansowanie na kolejny poziom po poprawnym wykonaniu quizu
    //sprawdzenie czy użytkownik podał więcej niż 5 poprawnych odpowiedzi    
    if ($score >= 5 )
    {
        //awansowanie na kolejny poziom :)
        if ($level < 3)
        {
            $level += 1;
            $info = "Awansowałeś na poziom: ". $level;
        }
        elseif ($level == 3)
        {
            $info = "Jesteś na najwyższym poziomie: ". $level;
        }
                
    }
    //jeżeli użytkownik podał mniej niż 5 puntków poniósł porażkę :(
    else
        {
            $info = "Spróbuj ponownie aby awansować" . "<p>". "wymagana liczba punktów: 5" ."</p>";
        }

        }
        
        

  
    //przesłanie danych do bazy
    $sql_update = "UPDATE users SET final_quiz=?, level=? WHERE user_id=?";        
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("iii", $score, $level, $user_id);
    $stmt->execute();
    
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
        <p>Twój poziom to: <span class="score"><?php echo $level; ?></p>
        <p><?php echo $info ?></p>
        </span>
        

        <a href="index.php" class="home-button">Wróć na stronę główną</a>
    </div>
</body>
</html>
