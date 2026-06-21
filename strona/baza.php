<?php
$host = "localhost";
$uzytkownik = "s429954";
$haslo = "michalowskijakub maksymilian";
$baza = "s429954";

$komunikat = "";
$tabela = "";

$connection = mysqli_connect($host, $uzytkownik, $haslo);

if (!$connection) {
    $komunikat = "Nie udało się połączyć z serwerem MySQL.";
} else {
    mysqli_set_charset($connection, "utf8");

    if (!mysqli_select_db($connection, $baza)) {
        $komunikat = "Nie udało się wybrać bazy danych.";
    } else {
        $komunikat = "Połączono z bazą danych.";

        if (isset($_POST["usun_id"])) {
            $id = intval($_POST["usun_id"]);
            mysqli_query($connection, "DELETE FROM kontakty WHERE id = $id");

            header("Location: baza.php");
            exit;
}

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $imie = mysqli_real_escape_string($connection, $_POST["imie"]);
            $nazwisko = mysqli_real_escape_string($connection, $_POST["nazwisko"]);
            $telefon = mysqli_real_escape_string($connection, $_POST["telefon"]);
            $email = mysqli_real_escape_string($connection, $_POST["email"]);

            if ($imie != "" && $nazwisko != "") {
                $sql_insert = "INSERT INTO kontakty (imie, nazwisko, telefon, email)
                               VALUES ('$imie', '$nazwisko', '$telefon', '$email')";

                if (mysqli_query($connection, $sql_insert)) {
                    $komunikat = "Dodano kontakt do bazy danych.";
                    header("Location: baza.php");
                    exit;
                } else {
                    $komunikat = "Błąd podczas dodawania kontaktu. Sprawdź, czy tabela kontakty istnieje.";
                }
            } else {
                $komunikat = "Imię i nazwisko są wymagane.";
            }
        }

        $sql = "SELECT id, imie, nazwisko, telefon, email FROM kontakty ORDER BY nazwisko ASC";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            $tabela .= "<table>";
            $tabela .= "<tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Akcja</th>
            </tr>";

           while ($row = mysqli_fetch_array($result)) {
                $tabela .= "<tr>";
                $tabela .= "<td>" . $row["imie"] . "</td>";
                $tabela .= "<td>" . $row["nazwisko"] . "</td>";
                $tabela .= "<td>" . $row["telefon"] . "</td>";
                $tabela .= "<td>" . $row["email"] . "</td>";

               $tabela .= "<td>
                    <form class='delete-form' method='post' action='baza.php'>
                        <input type='hidden' name='usun_id' value='" . $row["id"] . "'>
                        <input type='submit' value='Usuń'>
                    </form>
                </td>";
                $tabela .= "</tr>";
}

            $tabela .= "</table>";
        } else {
            $tabela = "<p>Nie udało się pobrać danych z tabeli kontakty. Najpierw utwórz tabelę poleceniem z pliku utworz_tabele.sql.</p>";
        }
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Baza danych</title>
</head>
<body>

<div class="sidebar">
    <a href="index.html">Strona główna</a>
    <a href="kalkulator.php">Kalkulator</a>
    <a href="baza.php">Baza danych</a>
</div>

<div class="container">
    <h1>Baza danych MySQL</h1>



    <p><strong>Status:</strong> <?php echo htmlspecialchars($komunikat); ?></p>

    <h2>Dodaj kontakt</h2>

    <form method="post" action="baza.php">
        <label for="imie">Imię:</label>
        <input type="text" id="imie" name="imie" placeholder="Jan">

        <br><br>

        <label for="nazwisko">Nazwisko:</label>
        <input type="text" id="nazwisko" name="nazwisko" placeholder="Kowalski">

        <br><br>

        <label for="telefon">Telefon:</label>
        <input type="text" id="telefon" name="telefon" placeholder="123456789">

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="jan@example.com">

        <br><br>

        <input type="submit" value="Dodaj do bazy">
    </form>

    <h2>Lista kontaktów</h2>

    <?php echo $tabela; ?>

    <h2>Opis działania</h2>
    <p>
        Skrypt łączy się z serwerem MySQL, wybiera bazę danych użytkownika,
        wykonuje zapytanie INSERT po wysłaniu formularza oraz SELECT do wyświetlenia zapisanych rekordów.
    </p>
</div>

</body>
</html>
