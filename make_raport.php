<?php
// Załadowanie plików potrzebnych do generowania pdf
require 'vendor/autoload.php';
include 'useDb.php';

// Pobranie danych użytkownika
if (isset($_POST['user_id'])) 
{
    // Jeżeli `user_id` został przesłany w formularzu, pobieramy dane użytkownika
    $userId = intval($_POST['user_id']);
    getDb($userId); // Funkcja powinna ustawiać dane w $_SESSION
} 
else if (isset($_SESSION["user_id"])) 
{
    // W przeciwnym razie używamy danych bieżącego użytkownika z sesji
    getDb($_SESSION["user_id"]);
} 
else 
{
    die('Brak danych użytkownika.');
}

ob_end_clean();
ob_start();

// Ustawienia danych do raportu
$poziom = $_SESSION["user_level"];
$imie = $_SESSION["user_name"];
$nazwisko = $_SESSION["user_surname"];
$punkty = $_SESSION["final_score"];
$departament = $_SESSION['dzial'];
$data = date('d-m-Y');

//jeżeli użytkownik ma 0 punktów, musi wykonać test
if ($punkty == 0) {
    $_SESSION['alert_raport'] = 1;
    header("Location: http://192.168.1.16/quizz/index.php");
}

// Tworzymy nowy obiekt TCPDF
$pdf = new TCPDF();

// Ustawiamy marginesy
$pdf->SetMargins(20, 20, 20);

// Dodajemy stronę do PDF
$pdf->AddPage();

// Ustawiamy czcionkę
$pdf->SetFont('dejavusans', '', 16);

// Dodajemy obraz nad tytułem (np. logo)
$imgFile = 'logo.png';  // Ścieżka do obrazu PNG
$pdf->Image($imgFile, 0, 10, 90, 0, 'PNG');  // Współrzędne (x, y), szerokość (40), wysokość (0 - proporcjonalne)

// Dodajemy tytuł (np. "Certyfikat ukończenia")
$pdf->SetTextColor(0, 0, 0);  // Ustawiamy czarny kolor tekstu
$pdf->Ln(50);  // Daje przestrzeń poniżej obrazu
$pdf->Cell(0, 15, 'Certyfikat Ukończenia', 0, 1, 'C');

// Dodajemy przestrzeń między liniami
$pdf->Ln(20);

// Tekst raportu (np. dane użytkownika)
$pdf->SetFont('dejavusans', '', 12);
$pdf->MultiCell(0, 10, "Imię: $imie\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Nazwisko: $nazwisko\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Liczba punktów: $punkty\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Poziom: $poziom\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Dział: $departament\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Data wykonania: $data\n", 0, 'L', 0, 1);

// Przestrzeń przed podpisem
$pdf->Ln(20);

// Dodajemy podpis
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->MultiCell(0, 10, "Podpis: ________________________________\n", 0, 'C', 0, 1);

// Wygenerowanie i wyświetlenie PDF
$pdf->Output('certyfikat.pdf', 'I');  // 'I' oznacza, że plik zostanie wyświetlony w przeglądarce
?>
