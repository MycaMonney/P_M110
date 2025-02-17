<link rel="stylesheet" href="styles/index.css">
<h2>Scoreboard</h2>
<section>
    <table>
        <tr>
            <th>Place</th>
            <th>Pseudo</th>
            <th>Score</th>
            <th>Region</th>
        </tr>
        <?php for ($i = 0; $i < count($scoreboard); $i++) { ?>
            <tr>
                <td><?= ($i + 1) ?></td>
                <td><?= $scoreboard[$i]['username'] ?></td>
                <td><?= $scoreboard[$i]['score'] ?></td>
                <td><?= $scoreboard[$i]['region'] ?></td>
            </tr>
        <?php } ?>
    </table>
</section>