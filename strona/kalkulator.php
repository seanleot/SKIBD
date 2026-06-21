<?php
$wynik = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST["a"];
    $b = $_POST["b"];
    $dzialanie = $_POST["dzialanie"];

    if ($a === "" || $b === "") {
        $wynik = "Podaj obie liczby.";
    } else {
        $a = floatval($a);
        $b = floatval($b);

        switch ($dzialanie) {
            case "dodawanie":
                $wynik = "$a + $b = " . ($a + $b);
                break;

            case "odejmowanie":
                $wynik = "$a - $b = " . ($a - $b);
                break;

            case "mnozenie":
                $wynik = "$a * $b = " . ($a * $b);
                break;

            case "dzielenie":
                if ($b == 0) {
                    $wynik = "Nie można dzielić przez zero.";
                } else {
                    $wynik = "$a / $b = " . ($a / $b);
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Kalkulator PHP</title>
</head>
<body>

<div class="sidebar">
    <a href="index.html">Strona główna</a>
</div>

<div class="container">
    <h1>Kalkulator PHP</h1>

 

    <form method="post" action="kalkulator.php">
        <label for="a">Pierwsza liczba:</label>
        <input type="number" step="any" id="a" name="a" placeholder="np. 10">

        <br><br>

        <label for="b">Druga liczba:</label>
        <input type="number" step="any" id="b" name="b" placeholder="np. 5">

        <br><br>

        <label>Działanie:</label><br>
        <input type="radio" name="dzialanie" value="dodawanie" checked> Dodawanie<br>
        <input type="radio" name="dzialanie" value="odejmowanie"> Odejmowanie<br>
        <input type="radio" name="dzialanie" value="mnozenie"> Mnożenie<br>
        <input type="radio" name="dzialanie" value="dzielenie"> Dzielenie<br>

        <br>

        <input type="submit" value="Oblicz">
    </form>

    <?php if ($wynik != ""): ?>
        <h2>Wynik</h2>
        <p><strong><?php echo htmlspecialchars($wynik); ?></strong></p>
    <?php endif; ?>


</div>

</body>
</html>
