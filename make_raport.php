<?php
// Załaduj Composer autoload
require 'vendor/autoload.php';
include 'useDb.php';

getDb($_SESSION["user_id"]);


// Ustawienia danych do raportu
$poziom = $_SESSION["user_level"];
$imie = $_SESSION["user_name"];
$punkty = $_SESSION["final_score"];
$data = date('d-m-Y');

// Tworzymy nowy obiekt TCPDF
$pdf = new TCPDF();

// Ustawiamy marginesy
$pdf->SetMargins(20, 20, 20);

// Dodajemy stronę do PDF
$pdf->AddPage();

// Ustawiamy czcionkę
$pdf->SetFont('dejavusans', '', 16);

// Dodajemy tytuł (np. "Certyfikat ukończenia")
$pdf->SetTextColor(0, 0, 0);  // Ustawiamy czarny kolor tekstu
$pdf->Cell(0, 15, 'Certyfikat Ukończenia', 0, 1, 'C');

// Dodajemy przestrzeń między liniami
$pdf->Ln(20);

// Tekst raportu (np. dane użytkownika)
$pdf->SetFont('dejavusans', '', 12);
$pdf->MultiCell(0, 10, "Imię: $imie\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Liczba punktów: $punkty\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Poziom: $poziom\n", 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, "Data wykonania: $data\n", 0, 'L', 0, 1);

// Przestrzeń przed podpisem
$pdf->Ln(20);

// Dodajemy podpis
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->MultiCell(0, 10, "Podpis: ________________________________\n", 0, 'C', 0, 1);

// Wygenerowanie i wyświetlenie PDF
$pdf->Output('certyfikat.pdf', 'I');  // 'I' oznacza, że plik zostanie wyświetlony w przeglądarce
?>
