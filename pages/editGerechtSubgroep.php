<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $GroepID = $_GET['ID'];
    $getGroep = $db->run('SELECT * FROM gerechtsoorten WHERE ID = ?', [$GroepID]);
    ?>

    <title>Sub Groep code <?php echo $GroepID; ?></title>
</head>

<body>
    <?php
    if ($getGroep->rowCount() > 0) {
        while ($fetch_groep = $getGroep->fetch(PDO::FETCH_ASSOC)) {
            $GroepId = $fetch_groep['ID'];
            $getNaamCato = $db->run('SELECT Naam FROM gerechtcategorien WHERE ID = ? LIMIT 1', [$fetch_groep['Gerechtcategorie_ID']])->fetch(PDO::FETCH_ASSOC);
            foreach ($getNaamCato as $fetch_Cato) {
                $CatoNaam = $fetch_Cato;
            }
    ?>
            <div class="content">
                <form method="POST">
                    <h5>Sub Groep bewerken</h5>
                    <br>
                    <p>Sub Groep ID: <?= $GroepId; ?></p>
                    <label for="code">Code</label>
                    <input type="text" required name="code" value="<?= $fetch_groep['Code']; ?>" />
                    <br>
                    <label for="naam">Naam</label>
                    <input type="text" required name="naam" value="<?= $fetch_groep['Naam']; ?>" />
                    <br>
                    <label for="cato">Valt onder: </label>
                    <input list="cato" required name="cato" value="<?= $CatoNaam; ?>">
                    <datalist id="cato" name="cato">
                        <!-- eventueel dinamisch -->
                        <option value="Hapjes">
                        <option value="Dranken">
                        <option value="Voorgerechten">
                        <option value="Hoofdgerechten">
                        <option value="Nagerechten">
                    </datalist>
                    <br>
                    <input type="submit" class="icon" id="submit" name="bewerken" value="Product bijwerken" />
                    <input type="submit" class="icon" id="submit" name="deleten" value="Product verwijderen" />
                    <a href="index.php?page=GerechtSubgroep">Terug naar overzicht</a>
                </form>
            </div>
    <?php
        }
    } else {
        echo '<p class="empty">Er zijn geen product gegevens gevonden</p> <a href="javascript:history.back()">Ga terug</a>';
    }
    ?>
</body>
<?php
if (isset($_POST['bewerken'])) {
    $newCode = htmlspecialchars($_POST['code']);
    $newNaam = htmlspecialchars($_POST['naam']);
    $newCato = htmlspecialchars($_POST['cato']);
    $getCatoID = $db->run('SELECT ID FROM gerechtcategorien WHERE Naam = ? LIMIT 1', [$newCato])->fetch(PDO::FETCH_ASSOC);
    foreach ($getCatoID as $fetch_Cato) {
        $CatoID = $fetch_Cato;
    }

    $updateSoortSql = "UPDATE gerechtsoorten SET Code =:Code, Naam =:Naam, Gerechtcategorie_ID=:Gerechtcategorie_ID WHERE ID = $GroepId";
    $updateSoort = $db->run($updateSoortSql, [
        'Code' => $newCode,
        'Naam' => $newNaam,
        'Gerechtcategorie_ID' => $CatoID
    ]);


    if ($updateSoort) {
        echo "<script>alert('Gegevens is geupdate');
                        location.href='index.php?page=GerechtSubgroep';</script>";
    } else {
        echo "<script>alert('Kan geen gegevens updaten');
                        location.href='index.php?page=GerechtSubgroep';</script>";
    }
}
if (isset($_POST["deleten"])) {

    $deleteSql = "DELETE FROM gerechtcategorien WHERE ID =$productId";
    $delete = $db->run($deleteSql);
    $melding = "Groep verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
        location.href='index.php?page=GerechtHoofdgroep'</script></div>";
    }
}
?>

</html>