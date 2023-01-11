<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onderhoud groep</title>
</head>

<body>
    <div class="content">
        <?php
        $listcategorien = $db->run('SELECT * FROM gerechtcategorien');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Onderhoud Hoofd groep</h4>
            </caption>
            <thead>
                <tr>
                    <th> Code</th>
                    <th> Omschrijving</th>
                    <th> <a href="index.php?page=newGerechtHoofdgroep"><i class="bi bi-plus-square-fill"></i></a></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listcategorien->rowCount() > 0) {
                    while ($fetch_hoofgroepen = $listcategorien->fetch(PDO::FETCH_ASSOC)) {
                        $editLink = "<a href='index.php?page=editGerechtHoofdgroep&ID=" . $fetch_hoofgroepen['Code'] . "'><i class='bi bi-pen-fill'></i></a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_hoofgroepen['Code'] ?></span></td>
                            <td><span><?= $fetch_hoofgroepen['Naam'] ?></span></td>
                            <td><span><?= $editLink ?></span></td>
                            <td><span><a href="index.php?page=GerechtHoofdgroep&ID=<?= $fetch_hoofgroepen['ID'] ?>"><i class="bi bi-trash-fill"></i></a></span></td>

                        </tr>

                <?php
                    }
                } else {
                    echo '<p class="empty">Er zijn geen Hoofdgroepen</p>';
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
    $deleteSql = "DELETE FROM gerechtcategorien WHERE ID =$ID";
    $delete = $db->run($deleteSql);
    $melding = "Groep verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
    location.href='index.php?page=GerechtHoofdgroep'</script></div>";
    }
}
?>

</html>