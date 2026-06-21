<?php
$liczbaPowtorzen = rand(3, 8);
$wyraz = "KOMPUTERY";

$komunikaty = [
    "K" => "Komputer wykonał obliczenie poprawnie.",
    "O" => "Otrzymano wynik działania.",
    "M" => "Można przejść do następnego losowania.",
    "P" => "Program wylosował kolejną parę liczb.",
    "U" => "Uzyskany wynik wskazał tę literę.",
    "T" => "To losowanie zostało zakończone.",
    "E" => "Eksperyment przebiegł prawidłowo.",
    "R" => "Rezultat mieści się w zakresie od 1 do 9.",
    "Y" => "Wyświetlono komunikat przypisany do litery."
];

$wynikiWZmiennej = "";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <title>Losowanie – Laboratorium 8</title>
</head>
<body>

<div class="sidebar">
    <a href="index.html">Strona główna</a>
    <a href="#bezposrednio">Wyniki bezpośrednie</a>
    <a href="#zmienna">Wyniki ze zmiennej</a>
    <a href="#opis">Opis działania</a>
</div>

<div class="container">
    <h1>Losowanie – PHP</h1>

    <p>
        Skrypt losuje liczbę powtórzeń głównej pętli. W każdej iteracji losowane są
        dwie liczby z przedziału od 1 do 3 oraz rodzaj działania:
        dodawanie albo mnożenie.
    </p>

    <p>Użyty wyraz dziewięcioliterowy: <strong><?php echo $wyraz; ?></strong></p>
    <p>Wylosowana liczba powtórzeń: <strong><?php echo $liczbaPowtorzen; ?></strong></p>

    <p>
        <a href="losowanie.php"><button type="button">Losuj ponownie</button></a>
    </p>

    <h2 id="bezposrednio">1. Wyniki wyświetlane bezpośrednio</h2>

    <table>
        <tr>
            <th>Nr</th>
            <th>A</th>
            <th>B</th>
            <th>Działanie</th>
            <th>Wynik</th>
            <th>Litera</th>
            <th>Komunikat</th>
        </tr>

        <?php
        for ($i = 1; $i <= $liczbaPowtorzen; $i++) {
            $a = rand(1, 3);
            $b = rand(1, 3);
            $wariant = rand(0, 1);

            if ($wariant === 0) {
                $dzialanie = "$a + $b";
                $wynik = $a + $b;
            } else {
                $dzialanie = "$a × $b";
                $wynik = $a * $b;
            }

            $litera = $wyraz[$wynik - 1];
            $komunikat = $komunikaty[$litera];

            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$a</td>";
            echo "<td>$b</td>";
            echo "<td>$dzialanie</td>";
            echo "<td>$wynik</td>";
            echo "<td><strong>$litera</strong></td>";
            echo "<td>$komunikat</td>";
            echo "</tr>";

            $wynikiWZmiennej .= "<tr>";
            $wynikiWZmiennej .= "<td>$i</td>";
            $wynikiWZmiennej .= "<td>$a</td>";
            $wynikiWZmiennej .= "<td>$b</td>";
            $wynikiWZmiennej .= "<td>$dzialanie</td>";
            $wynikiWZmiennej .= "<td>$wynik</td>";
            $wynikiWZmiennej .= "<td><strong>$litera</strong></td>";
            $wynikiWZmiennej .= "<td>$komunikat</td>";
            $wynikiWZmiennej .= "</tr>";
        }
        ?>
    </table>

    <h2 id="zmienna">2. Wyniki zgromadzone w zmiennej</h2>

    <p>
        Poniższa tabela została zapisana w zmiennej
        <code>$wynikiWZmiennej</code>, a następnie wyświetlona instrukcją
        <code>echo</code>.
    </p>

    <table>
        <tr>
            <th>Nr</th>
            <th>A</th>
            <th>B</th>
            <th>Działanie</th>
            <th>Wynik</th>
            <th>Litera</th>
            <th>Komunikat</th>
        </tr>
        <?php echo $wynikiWZmiennej; ?>
    </table>

    <h2 id="opis">3. Opis działania</h2>

    <ol>
        <li>Funkcja <code>rand(3, 8)</code> losuje liczbę wykonań głównej pętli.</li>
        <li>W każdej iteracji funkcja <code>rand(1, 3)</code> losuje liczby A i B.</li>
        <li>Funkcja <code>rand(0, 1)</code> wybiera dodawanie albo mnożenie.</li>
        <li>Wynik działania wskazuje pozycję litery w wyrazie <code>KOMPUTERY</code>.</li>
        <li>Do odczytanej litery przypisany jest odpowiedni komunikat.</li>
        <li>Wynik jest wypisywany bezpośrednio oraz zapisywany w zmiennej.</li>
    </ol>

    <p>
        <a href="index.html"><button type="button">Wróć na stronę główną</button></a>
    </p>
</div>

</body>
</html>
