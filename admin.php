<?php
// Połączenie z bazą danych
include "connect.php";

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Sprawdzenie, czy użytkownik jest administratorem
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    echo ("Musisz się zalogować jako administrator");
    header("Location: login.php");
    exit;
}

// Pobranie wartości filtrów z URL
$filterName = $_GET['filter_name'] ?? '';
$filterSurname = $_GET['filter_surname'] ?? '';
$department = $_GET['department'] ?? ''; // Filtr departamentu
$page = $_GET['page'] ?? 1;
$itemsPerPage = 10;

// Obliczenie offsetu dla paginacji
$offset = ($page - 1) * $itemsPerPage;



$sql = "SELECT * FROM users WHERE departament not like 'Administrator'" ; // Pomiń administratorów




$params = [];
$types = ''; // Typy dla bind_param()

if ($filterName) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$filterName%";
    $types .= "s"; // dodajemy typ string dla parametru name
    debug_to_console($params);
}

if ($filterSurname) {
    $sql .= " AND surname LIKE ?";
    $params[] = "%$filterSurname%";
    $types .= "s"; // dodajemy typ string dla parametru surname
    debug_to_console($params);
}

if ($department) {
    $sql .= " AND departament = ?";
    $params[] = $department;
    $types .= "s"; // dodajemy typ string dla parametru departament
}



$sql .= " order by surname ASC ";

$sql .= " LIMIT ?, ?";


// Przygotowanie zapytania
$stmt = $conn->prepare($sql);

// Jeżeli mamy parametry, używamy bind_param, w przeciwnym razie po prostu wykonujemy zapytanie
if (count($params) > 0) {
    $params[] = $offset; // Dodajemy offset
    $params[] = $itemsPerPage; // Dodajemy limit
    $types .= "ii"; // Dodajemy typy dla offsetu i limitu (integer)
    $stmt->bind_param($types, ...$params);
} else {
    $params[] = $offset; // Dodajemy offset
    $params[] = $itemsPerPage; // Dodajemy limit
    $stmt->bind_param("ii", ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Panel Administratora</title>
</head>
<body>
    <!-- Menu -->
    <nav id="admin-menu">
        <ul>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Panel Administratora</h1>

        <!-- Filtr -->
        <form method="GET" class="filter-form">
            <label for="filter_name">Filtruj po imieniu:</label>
            <input type="text" name="filter_name" id="filter_name" value="<?= htmlspecialchars($filterName) ?>">
            
            <label for="filter_surname">Filtruj po nazwisku:</label>
            <input type="text" name="filter_surname" id="filter_surname" value="<?= htmlspecialchars($filterSurname) ?>">

            <label for="department">Wybierz departament:</label>
            <select name="department" id="department">
                <option value="">Wszystkie</option>
                <option value="kadry" <?= $department === 'Kadry' ? 'selected' : '' ?>>Kadry</option>
                <option value="ksiegowosc" <?= $department === 'Ksiegowość' ? 'selected' : '' ?>>Księgowość</option>
                <option value="zarzad" <?= $department === 'Zarzad' ? 'selected' : '' ?>>Zarząd</option>
                <option value="handlowy" <?= $department === 'Handlowy' ? 'selected' : '' ?>>Handlowy</option>
                <option value="produkcja" <?= $department === 'Produkcja' ? 'selected' : '' ?>>Produkcja</option>
                <option value="utrzymanie_czystosci" <?= $department === 'Utrzymanie Czystosci' ? 'selected' : '' ?>>Utrzymanie Czystości</option>
                <option value="it" <?= $department === 'it' ? 'selected' : '' ?>>IT</option>
            </select>

            <button type="submit">Filtruj</button>
        </form>

        <!-- Tabela z danymi użytkowników -->
        <div class="table-container">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Departament</th>
                        <th>Poziom</th>
                        <th>Liczba Punktów</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['surname']) ?></td>
                            <td><?= htmlspecialchars($user['departament']) ?></td>
                            <td><?= htmlspecialchars($user['level']) ?></td>
                            <td><?= htmlspecialchars($user['score']) ?></td>
                            <td>
                                <form action="make_raport.php" method="POST" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <button type="submit" class="generate">Generuj Certyfikat</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

       
          
    <div class = "center_report">
        <form action="generate_all_reports.php" method="POST" target="_blank" class="inline-form">
            <input type="hidden" name="filter_name" value="<?= htmlspecialchars($filterName) ?>">
            <input type="hidden" name="filter_surname" value="<?= htmlspecialchars($filterSurname) ?>">
            <input type="hidden" name="department" value="<?= htmlspecialchars($department) ?>">
            <button type="submit" class="report-buttons">Generuj raport całościowy</button>
            <button class="report-buttons" onclick="window.location.href='admin.php' ">Odśwież</button>
        </form>
    </div>
</div>
    <img src="logo.png" alt="Logo Quizu" class="quiz-logo">
</body>
</html>
