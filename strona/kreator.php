<?php

if (isset($_GET['usr'])) {
    $usr = $_GET['usr'];
} else {
    $usr = 0;
}

if (isset($_GET['oper'])) {
    $oper = $_GET['oper'];
} else {
    $oper = 0;
}

?>

<h1>Lista studentów</h1>

<?php
//Lista wyboru
switch ($oper) {
    case 0: //Standardowe wyświetlenie tabelki
        ?>

        <h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?oper=3">Dodaj nowy wpis</a></h3>
<?php

echo pokazUsers();
        break;
    case 3: //Wyświetlenie formularza zmiany danych
        $nazwisko = "";
        $imie = "";
        $grupa = "";

        if (isset($usr) and $usr != 0) { // Sprawdzenie czy trzeba wypełnić fromularz
            $userArr = pobiezUser($usr);
            $nazwisko = $userArr['nazwisko'];
            $imie = $userArr['imie'];
            $grupa = $userArr['grupa'];
        }
        $act = $_SERVER['PHP_SELF'] . "?oper=4&usr=" . $usr; // Ustawienie działania formularza

        ?>

        <form name="AdresForm" action="<?php echo $act ?>" method="POST">
        <table>
        <tr>
            <td>Imię</td>
            <td><input type="text" name="imie" value="<?php echo $imie ?>" /></td>
        </tr>
        <tr>
            <td>Nazwisko</td>
            <td><input type="text" name="nazwisko" value="<?php echo $nazwisko ?>" /></td>
        </tr>
        <tr>
            <td>Grupa</td>
            <td><input type="text" name="grupa" value="<?php echo $grupa ?>"/></td>
        </tr>

        </table>
        <input type="submit" value="OK" name="wyslij" />

        </form>
<?php
break;

    case 4: //Obsługa formularza zmiany danych
        //Akcja podejmowana w zależności od zmiennej $usr
        /* Tutaj dodatkowo powinna zostać dokonana walidacja danych z formularza. W tym momencie zakładamy 
            że cokolwiek pobierzemy będzie dobre. Kod sprawdza jedynie czy usr jest niepusty i różny od zera.
            Zero oznacza że wpisu nie ma w bazie danych więc dodawany jest nowy rekord.
        */
        
        if (isset($usr) and $usr != 0) { // Sprawdzenie czy modyfikować wpis czy dodawać nowy
            $sql = "UPDATE studenci SET " . 
            "imie =\"" . $_POST['imie'] . "\", " . 
            "nazwisko = \"" . $_POST['nazwisko'] . "\", " . 
            "grupa = \"" . $_POST['grupa'] . "\"  " . 
            "WHERE id = \"" . $usr . "\";";

        } else {
            $sql = "INSERT INTO studenci (imie, nazwisko, grupa) VALUES ('" . $_POST['imie'] . "', '"
                . $_POST['nazwisko'] . "', '" . $_POST['grupa'] . "');";
        }

    case 5: //Usunięcie wpisu z bazy danych
        if (isset($usr) and $usr != 0 and $oper == 5) {
            $sql = "DELETE FROM studenci
                        WHERE id='" . $usr . "';";
        }
        
        // Obsługa bazy danych dla przypadku 4 i 5
        $message = modyfikujUser($sql);

        echo "<br>" . $message; //Wyświetlenie komunikatu o bazie danych
        //echo "<br> <a href=\"" . $_SERVER['PHP_SELF'] . "\">Powrót do listy konatktów</a>";

        // Wygenerowanie zawartości strony po operacji na bazie danych
        ?>
        
        <h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>?oper=3">Dodaj nowy wpis</a></h3>

<?php
echo pokazUsers();
        break;

    default:
        break;
}
?>

<?php
/*
---------------------------------------- Utworzenie funkcji pomocniczych ---------------------------------
 */
function polacz()
{
    //$user = "proj_skibd";
    //$passwd = "student2000";
    //$host = "localhost";
    //$baza = "proj_skibd";
    
    $user = "lekcje";
    $passwd = "student2000";
    $host = "localhost";
    $baza = "lekcje";

    $connection = @mysqli_connect($host, $user, $passwd)
    or die("Nie można się zalogować do serwera!");

    if ($connection) {
        $db = mysqli_select_db($connection, $baza)
        or die("Użytkownik: $user nie ma praw do bazy: $baza!");
        //mysqli_query("SET NAMES 'utf-8'");

    }
    return $connection;
}

function pokazUsers() // Wygenerowanie tabelki z danymi. Jako wyjście zwracany jest ciąg znaków.
{
    $connection = polacz();
    //
    $sql = "SELECT * FROM studenci;";

    $result = mysqli_query($connection, $sql)
    or die("Nie można wykonać zapytania!");

    $cnt = 0;
    $content = "
        <table>
            <tr>
                <th>Lp.</th> <th>Imię</th> <th>Nazwisko</th> <th>Grupa</th>
            </tr>";

    while ($res = mysqli_fetch_array($result)) {
        $cnt++;

        $content .= "<TR>
                           <TD>$cnt   </TD>
                           <TD>$res[2]</TD>
                           <TD>$res[1]</TD>
                           <TD>$res[3]</TD>
                           <TD><a href=\"" . $_SERVER['PHP_SELF'] . "?oper=3&usr=$res[0]\">Edytuj</a></TD>
                           <TD><a href=\"" . $_SERVER['PHP_SELF'] . "?oper=5&usr=$res[0]\">Usuń</a></TD>
                           </TR>";
    }

    $content .= "</table>";
    return $content;
}

function pobiezUser($usr) // Pobranie danych konkretnego usera o danym id
{
    $res = null;
    if (!isset($usr)) {
        return $res;
    }
    $connection = polacz();
    //
    $sql = "SELECT * FROM studenci where id='$usr';";

    $result = mysqli_query($connection, $sql)
    or die("Nie można wykonać zapytania!");
    if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_array($result);
    }
    return $res;
}

function modyfikujUser($sql) // Modyfikacja wpisu w bazie danych
{
    $connection = polacz();
    if (mysqli_query($connection, $sql)) {
        $message = "Dane zostały zmodyfikowane";
    } else {
        $message = "Dane nie zostały zmodyfikowane z powodu błędu!";
    }
    return $message;
}
?>
