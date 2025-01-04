<?php
    include "connect.php";
    if (!isset($_SESSION))
    {
        session_start();
    }
    function getDb($user)
    {
        $conn = $_SESSION['db'];
        $sql = "SELECT * FROM users WHERE user_id=?";
                 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user);
        $stmt->execute();
        //obsługa zapytania mysql
        $odpowiedz = $stmt->get_result();

        if($odpowiedz->num_rows == 1)
        {
            $row = $odpowiedz->fetch_assoc();
             //Pobranie z bazy danych id
             $_SESSION["user_level"] = $row["level"];
             $_SESSION["user_name"] = $row["name"];
             $_SESSION["final_score"] = $row["final_quiz"];
             $_SESSION['last_score'] = $row['score'];
             //Pobranie roli z bazy danych
        
        }   
    };

?>