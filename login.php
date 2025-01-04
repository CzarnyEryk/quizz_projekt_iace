<!-- Plik służacy do możliwości logowania się i zapisania danych w sesji -->
<!--  -->
<?php
    //dodanie pliku do obsługi połączenia z bazą danych

    //obsługa błędów
    try 
    {
        include "connect.php";
        //przejęcie sesji
        if (!isset($_SESSION))
        {
            session_start();
        }
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            //pobranie e-mail oraz hasła z formularza
            $e_mail = $_POST["e_mail"];
            $password = $_POST["password"];

            //jeżeli użytkownik podał e_mail oraz hasło
            if ($e_mail && $password)
            {
                $hash_password = hash("sha256", $password);
                //przygotowanie zapytania 
                
                $sql = "SELECT * FROM users WHERE e_mail= ? AND password= ? ";
                 
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $e_mail, $hash_password);
                $stmt->execute();
                //obsługa zapytania mysql
                $odpowiedz = $stmt->get_result();

                //sprawdzenie czy baza danych zwróciła nam wiersz
                if($odpowiedz->num_rows == 1)
                {
                    //przypisanie do sesji danych o użytkowniku
                    $row = $odpowiedz->fetch_assoc();
                    
                    //Pobranie z bazy danych id
                    $_SESSION["user_id"] = $row["user_id"]; 
                    $_SESSION["user_level"] = $row["level"];
                    $_SESSION["user_name"] = $row["name"];
                    $_SESSION["final_score"] = $row["final_quiz"];
                    $_SESSION['last_score'] = $row['score'];
                    //Pobranie roli z bazy danych
                    
                    //zakończ połączenie
                    $conn->close();
                    
                    if ($_SESSION["user_level"] == 0)
                    {
                        header("Location: http://192.168.1.16/quizz/first_quizz.php");
                    }
                    else
                    {
                        header("Location: http://192.168.1.16/quizz/index.php");
                    }
                    
                
                }

                //jeżeli baza danych nie zwróciła nam żadnych wartości zwróć błąd
                else
                {
                    //zakończ połączenie
                    $message = "Złe dane";
                    $conn->close();
                    
                }

                
                  } 
        }
    } 
    //jeżeli występuje błąd to przechwyć go
    catch (\Throwable $th) 
    {
        echo $th;
    }  
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaloguj</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1>CyberSecurity Quiz</h1>
            <p>Zaloguj się, aby kontynuować</p>
            <form method="POST" action="login.php">
                <label for="e_mail">E-mail:</label>
                <input type="email" id="e_mail" name="e_mail" placeholder="Wprowadź swój e-mail" required>
                
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" placeholder="Wprowadź swoje hasło" required>
                
                <input type="submit" name="zaloguj" value="Zaloguj">
            </form>
            <p id="info"><?php echo ($message) ?></p>
        </div>
    </div>
</body>

</html>
