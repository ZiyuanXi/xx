<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onderhoud Drinken</title>
</head>

<body>
    <div class="content">
        <?php
        $listDrinken = $db->run('SELECT * FROM menuitems WHERE Gerechtsoort_ID = 3 or Gerechtsoort_ID = 4');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Onderhoud Drinken</h4>
            </caption>
            <thead>
                <tr>
                    <th> Code</th>
                    <th> Omschrijving</th>
                    <th> Prijs</th>
                    <th> Valt onder</th>
                    <th> <a href="index.php?page=newGerechtDrinken"><i class="bi bi-plus-square-fill"></i></a></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listDrinken->rowCount() > 0) {
                    while ($fetch_Drank = $listDrinken->fetch(PDO::FETCH_ASSOC)) {
                        $getNaamSub=$db->run('SELECT Naam FROM gerechtsoorten WHERE ID = ? LIMIT 1', [$fetch_Drank['Gerechtsoort_ID']])->fetch(PDO::FETCH_ASSOC);
                        foreach ($getNaamSub as $fetch_Sub) {
                            $SubNaam = $fetch_Sub;
                        }
                        $editLink = "<a href='index.php?page=editGerechtDrinken&ID=" . $fetch_Drank['Code'] . "'><i class='bi bi-pen-fill'></i></a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_Drank['Code'] ?></span></td>
                            <td><span><?= $fetch_Drank['Naam'] ?></span></td>
                            <td><span><?= $fetch_Drank['Prijs'] ?></span></td>
                            <td><span><?= $SubNaam ?></span></td>
                            <td><span><?= $editLink ?></span></td>
                            <td><span><a href="index.php?page=GerechtDrinken&ID=<?= $fetch_Drank['ID'] ?>"><i class="bi bi-trash-fill"></i></a></span></td>

                        </tr>

                <?php
                    }
                } else {
                    echo '<p class="empty">Er zijn geen Drank gevonden</p>';
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
    $deleteSql = "DELETE FROM menuitems WHERE ID =$ID";
    $delete = $db->run($deleteSql);
    $melding = "Drinken verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
    location.href='index.php?page=GerechtDrinken'</script></div>";
    }
}
?>

</html>