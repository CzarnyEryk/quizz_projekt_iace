<?php
require 'vendor/autoload.php';
include "connect.php";

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    echo ("Musisz się zalogować jako administrator");
    header("Location: login.php");
    exit;
}

$filterName = $_POST['filter_name'] ?? '';
$filterSurname = $_POST['filter_surname'] ?? '';
$department = $_POST['department'] ?? '';

$sql = "SELECT * FROM users WHERE departament not like 'Administrator'";
$params = [];
$types = '';

if ($filterName) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$filterName%";
    $types .= "s";
}

if ($filterSurname) {
    $sql .= " AND surname LIKE ?";
    $params[] = "%$filterSurname%";
    $types .= "s";
}

if ($department) {
    $sql .= " AND departament = ?";
    $params[] = $department;
    $types .= "s";
}

$sql .= " ORDER BY surname ASC ";

$stmt = $conn->prepare($sql);
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

ob_end_clean(); // Oczyść bufor
$pdf = new TCPDF();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage(); // Dodanie pierwszej strony

// Wstawienie logo
$imgFile = 'logo.png';
$pdf->Image($imgFile, 0, 10, 90, 0, 'PNG');
$pdf->Ln(30);

// Tytuł raportu
$pdf->SetFont('dejavusans', '', 12);
$pdf->Cell(0, 15, 'Raport Całościowy', 0, 1, 'C');
$pdf->Ln(10);

// Nagłówki tabeli
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(30, 10, 'Imię', 1, 0, 'C');
$pdf->Cell(40, 10, 'Nazwisko', 1, 0, 'C');
$pdf->Cell(50, 10, 'Departament', 1, 0, 'C');
$pdf->Cell(30, 10, 'Poziom', 1, 0, 'C');
$pdf->Cell(40, 10, 'Liczba Punktów', 1, 1, 'C');

// Wstawianie wierszy tabeli
$pdf->SetFont('dejavusans', '', 12);
while ($user = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $user['name'], 1, 0, 'C');
    $pdf->Cell(40, 10, $user['surname'], 1, 0, 'C');
    $pdf->Cell(50, 10, $user['departament'], 1, 0, 'C');
    $pdf->Cell(30, 10, $user['level'], 1, 0, 'C');
    $pdf->Cell(40, 10, $user['score'], 1, 1, 'C');

    // Dodawanie nowej strony, jeśli tabela wychodzi poza marginesy
    if ($pdf->getY() > ($pdf->getPageHeight() - $pdf->getMargins()['bottom'] - 20)) {
        $pdf->AddPage();
        // Nagłówki tabeli na nowej stronie
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(30, 10, 'Imię', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nazwisko', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Departament', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Poziom', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Liczba Punktów', 1, 1, 'C');
        $pdf->SetFont('dejavusans', '', 12);
    }
}

// Dodanie daty wykonania raportu
$pdf->Ln(20);
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->MultiCell(0, 10, "Data wykonania raportu: " . date('d-m-Y'), 0, 'C', 0, 1);

$pdf->Output('raport_calosciowy.pdf', 'I');
?>
