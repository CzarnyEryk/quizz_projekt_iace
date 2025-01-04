<?php
    //uruchomienie sesji
    session_start();

    //sprawdzenie czy użytkownik jest zalogowany
    if ( !isset($_SESSION["user_id"]))
    {
        echo ("Musisz się zalogować");
        header("Location: http://192.168.1.16/quizz/login.php");
    }

    if ( $_SESSION['user_level'] == 0)
    {
        header("Location: http://192.168.1.16/quizz/first_quizz.php");
    }

    if ( $_SESSION['alert'] == 1)
    {
        echo '<script>alert("Masz maksymalny poziom")</script>';
        $_SESSION['alert'] == 0;
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="main.css" >
        <meta charset="utf-8" />
        <title>CyberSec</title>
    </head>

    <body>
        <div id="container">
        <div id="top_menu">
    <button class="button_top" onclick="window.location.href='http://192.168.1.16/quizz/mainquiz.php'">QUIZY</button>
    <button class="button_top" onclick="window.location.href='http://192.168.1.16/quizz/account.php'">KONTO</button>
    <button class="button_top" onclick="window.location.href='http://192.168.1.16/quizz/logout.php'">WYLOGUJ</button>
    <p><?php echo ("Witaj: " . $_SESSION["user_name"]); ?></p>
    <div style="clear:both"></div>
</div>


            <div id="information">
            <bold>Znaczenie Cyberbezpieczeństwa:</bold>
            <p>W dzisiejszym dynamicznie rozwijającym się świecie technologicznym, cyberbezpieczeństwo stało się fundamentem funkcjonowania zarówno osób prywatnych, 
            jak i organizacji. Żyjemy w erze, gdzie informacje, dane osobowe, finanse i procesy biznesowe istnieją w cyfrowym wymiarze. 
            To sprawia, że są one narażone na zagrożenia takie jak ataki hakerskie, kradzieże danych czy złośliwe oprogramowanie.
            </p>

            Cyberbezpieczeństwo to zbiór praktyk, technologii i procesów mających na celu ochronę systemów komputerowych, 
            sieci i danych przed nieautoryzowanym dostępem oraz szkodliwymi działaniami. Jego znaczenie jest nieocenione z kilku kluczowych powodów:
            <ol>
            <li>Ochrona danych osobowych - Twoje dane są cenne. Chronienie ich przed kradzieżą to ochrona Twojej tożsamości, finansów i reputacji.</li>
            <li>Bezpieczeństwo firm i organizacji - Dla przedsiębiorstw cyberbezpieczeństwo jest kluczowe, aby chronić tajemnice handlowe, dane klientów oraz operacje biznesowe.</li>
            <li>Zapobieganie cyberprzestępczości - Cyberataki mogą prowadzić do ogromnych strat finansowych i poważnych konsekwencji prawnych. Silne zabezpieczenia zmniejszają to ryzyko.</li>
            <li>Wzrost zaufania - Firmy, które inwestują w cyberbezpieczeństwo, budują większe zaufanie wśród klientów, partnerów i społeczeństwa.</li>
            </ol>
           

            <bold>Wyzwania i przyszłość</bold>
            Zagrożenia w świecie cyfrowym nieustannie ewoluują. Codziennie powstają nowe metody ataków, dlatego istotne jest, aby być na bieżąco z najlepszymi praktykami i technologiami zabezpieczeń. Edukacja w zakresie cyberhigieny, regularne aktualizacje systemów oraz stosowanie silnych haseł to kroki, które każdy z nas może podjąć, aby zwiększyć swoje bezpieczeństwo.

            

        </div>

            
            
        </div>
    </body>

</html>
