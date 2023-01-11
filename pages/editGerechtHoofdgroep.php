<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $GroepCode = $_GET['ID'];
    $getGroep = $db->run('SELECT * FROM gerechtcategorien WHERE Code = ?', [$GroepCode]);
    ?>

    <title>Hoofd Groep code <?php echo $GroepCode; ?></title>
</head>

<body>
    <?php
    if ($getGroep->rowCount() > 0) {
        while ($fetch_groep = $getGroep->fetch(PDO::FETCH_ASSOC)) {
            $GroepId = $fetch_groep['ID'];
    ?>
            <div class="content">
                <form method="POST">
                    <h5>Hoofd Groep bewerken</h5>
                    <br>
                    <p>Groep ID: <?= $GroepId; ?></p>
                    <label for="code">Code</label>
                    <input type="text" required name="code" value="<?= $fetch_groep['Code']; ?>" />
                    <br>
                    <label for="naam">Naam</label>
                    <input type="text" required name="naam" value="<?= $fetch_groep['Naam']; ?>" />
                    <br>
                    <input type="submit" class="icon" id="submit" name="bewerken" value="Product bijwerken" />
                    <input type="submit" class="icon" id="submit" name="deleten" value="Product verwijderen" />
                    <a href="index.php?page=GerechtHoofdgroep">Terug naar overzicht</a>
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

    $updateGroepSql = "UPDATE gerechtcategorien SET Code =:Code, Naam =:Naam WHERE ID = $GroepId";
    $updateGroep = $db->run($updateGroepSql, [
        'Code' => $newCode,
        'Naam' => $newNaam
    ]);


    if ($updateGroep) {
        echo "<script>alert('Gegevens is geupdate');
                        location.href='index.php?page=GerechtHoofdgroep';</script>";
    } else {
        echo "<script>alert('Kan geen gegevens updaten');
                        location.href='index.php?page=GerechtHoofdgroep';</script>";
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