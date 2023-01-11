<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onderhoud sub groep</title>
</head>

<body>
    <div class="content">
        <?php
        $listSoort = $db->run('SELECT * FROM gerechtsoorten');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Onderhoud sub groep</h4>
            </caption>
            <thead>
                <tr>
                    <th> Code</th>
                    <th> Omschrijving</th>
                    <th> Valt onder</th>
                    <th> <a href="index.php?page=newGerechtSubgroep"><i class="bi bi-plus-square-fill"></i></a></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listSoort->rowCount() > 0) {
                    while ($fetch_subgroepen = $listSoort->fetch(PDO::FETCH_ASSOC)) {
                        $getNaamSub=$db->run('SELECT Naam FROM gerechtcategorien WHERE ID = ? LIMIT 1', [$fetch_subgroepen['Gerechtcategorie_ID']])->fetch(PDO::FETCH_ASSOC);
                        foreach ($getNaamSub as $fetch_Sub) {
                            $CatoNaam = $fetch_Sub;
                        }
                        $editLink = "<a href='index.php?page=editGerechtSubgroep&ID=" . $fetch_subgroepen['ID'] . "'><i class='bi bi-pen-fill'></i></a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_subgroepen['Code'] ?></span></td>
                            <td><span><?= $fetch_subgroepen['Naam'] ?></span></td>
                            <td><span><?= $CatoNaam ?></span></td>
                            <td><span><?= $editLink ?></span></td>
                            <td><span><a href="index.php?page=GerechtSubgroep&ID=<?= $fetch_subgroepen['ID'] ?>"><i class="bi bi-trash-fill"></i></a></span></td>

                        </tr>

                <?php
                    }
                } else {
                    echo '<p class="empty">Er zijn geen Subgroepen</p>';
                }
                ?>

            </tbody>
        </table>

    </div>

</body>
<!-- verwijderen -->
<?php
if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    $deleteSql = "DELETE FROM gerechtsoorten WHERE ID =$ID";
    $delete = $db->run($deleteSql);
    $melding = "Soort verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
    location.href='index.php?page=GerechtSubgroep'</script></div>";
    }
}
?>

</html>