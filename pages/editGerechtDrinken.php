<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $gerechtID = $_GET['ID'];
    $getGerecht = $db->run('SELECT * FROM menuitems WHERE Code = ?', [$gerechtID]);
    ?>

    <title>Product code <?php echo $gerechtID; ?></title>
</head>

<body>
    <?php
    if ($getGerecht->rowCount() > 0) {
        while ($fetch_gerecht = $getGerecht->fetch(PDO::FETCH_ASSOC)) {
            $gerechtID = $fetch_gerecht['ID'];
            $getNaamSoort = $db->run('SELECT Naam FROM gerechtsoorten WHERE ID = ? LIMIT 1', [$fetch_gerecht['Gerechtsoort_ID']])->fetch(PDO::FETCH_ASSOC);
            foreach ($getNaamSoort as $fetch_Soort) {
                $SoortNaam = $fetch_Soort;
            }
    ?>
            <div class="content">
                <form method="POST">
                    <h5>Drinken bewerken</h5>
                    <br>
                    <p>Product ID: <?= $gerechtID; ?></p>
                    <label for="code">Code</label>
                    <input type="text" required name="code" value="<?= $fetch_gerecht['Code']; ?>" />
                    <br>
                    <label for="naam">Naam</label>
                    <input type="text" required name="naam" value="<?= $fetch_gerecht['Naam']; ?>" />
                    <br>
                    <label for="naam">Prijs: </label>
                    <input type="number" step="any" required name="prijs" value="<?= $fetch_gerecht['Prijs']; ?>" />
                    <br>
                    <label for="soort">Valt onder: </label>
                    <input list="soort" required name="soort" value="<?= $SoortNaam; ?>">
                    <datalist id="soort" name="soort">
                        <!-- eventueel dinamisch -->
                        <option value="Frisdrank">
                        <option value="Bieren">
                    </datalist>
                    <br>
                    <input type="submit" class="icon" id="submit" name="bewerken" value="Product bijwerken" />
                    <input type="submit" class="icon" id="submit" name="deleten" value="Product verwijderen" />
                    <a href="index.php?page=GerechtDrinken">Terug naar overzicht</a>
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
    $newPrijs = htmlspecialchars($_POST['prijs']);
    $newSoort = htmlspecialchars($_POST['soort']);
    $getSoortID = $db->run('SELECT ID FROM gerechtsoorten WHERE Naam = ? LIMIT 1', [$newSoort])->fetch(PDO::FETCH_ASSOC);
    foreach ($getSoortID as $fetch_Soort) {
        $SoortID = $fetch_Soort;
    }

    $updateSoortSql = "UPDATE menuitems SET Code =:Code, Naam =:Naam, Gerechtsoort_ID=:Gerechtsoort_ID, Prijs=:Prijs WHERE ID = $gerechtID";
    $updateSoort = $db->run($updateSoortSql, [
        'Code' => $newCode,
        'Naam' => $newNaam,
        'Gerechtsoort_ID' => $SoortID,
        'Prijs' => $newPrijs
    ]);


    if ($updateSoort) {
        echo "<script>alert('Gegevens is geupdate');
                        location.href='index.php?page=GerechtDrinken';</script>";
    } else {
        echo "<script>alert('Kan geen gegevens updaten');
                        location.href='index.php?page=GerechtDrinken';</script>";
    }
}
if (isset($_POST["deleten"])) {

    $deleteSql = "DELETE FROM gerechtcategorien WHERE ID =$productId";
    $delete = $db->run($deleteSql);
    $melding = "Item verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
        location.href='index.php?page=GerechtHoofdgroep'</script></div>";
    }
}
?>

</html>