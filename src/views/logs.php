<?php
$addonPath = '';
$slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
for ($i = $slashCount; $i > 1; $i--) {
    $addonPath .= '../';
}
?>
<link rel="stylesheet" href="<?= $addonPath ?>styles/index.css">
<div>
    <style>
        h2 {
            margin-right: 5%;
        }

        .top-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
        }

        #searchBar {
            flex-grow: 1;
            margin-right: 20px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #lastLog {
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            background-color: #f5f5f5;
            min-width: 250px;
            text-align: center;
        }

        #logContainer {
            margin: 20px;
        }

        p {
            padding: 10px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            margin: 5px 0;
        }

        /* Couleurs des logs */
        .log-info {
            background-color: #d9edf7;
            color: #31708f;
        }

        .log-warning {
            background-color: #fcf8e3;
            color: #8a6d3b;
        }

        .log-error {
            background-color: #f2dede;
            color: #a94442;
        }

        .log-critical {
            background-color: #ebccd1;
            color: #843534;
        }

        .log-default {
            background-color: #f5f5f5;
            color: #333;
        }
    </style>

    <div class="top-container">
        <h2>Logs</h2>
        <input id="searchBar" onkeyup="rechercher()" type="text" placeholder="Rechercher 🔍">

        <!-- Dernier log -->
        <div id="lastLog">
            <?php
            if (!empty($logs)) {
                echo htmlspecialchars(end($logs));
            } else {
                echo "Aucun log disponible";
            }
            ?>
        </div>
    </div>

    <div id="logContainer">
        <?php foreach (array_reverse($logs) as $log) :
            if (strpos($log, 'INFO') !== false) {
                $class = 'log-info';
            } elseif (strpos($log, 'WARNING') !== false) {
                $class = 'log-warning';
            } elseif (strpos($log, 'ERROR') !== false) {
                $class = 'log-error';
            } elseif (strpos($log, 'CRITICAL') !== false) {
                $class = 'log-critical';
            } else {
                $class = 'log-default';
            }
        ?>
            <p class="<?= $class ?>"><?= htmlspecialchars($log) ?></p>
        <?php endforeach; ?>
    </div>
</div>
<script>
    function rechercher() {
        input = document.getElementById("searchBar").value;
        input = input.toLowerCase();
        x = document.querySelectorAll("p");

        for (i = 0; i < x.length; i++) {
            if (!x[i].innerHTML.toLowerCase().includes(input)) {
                x[i].style.display = "none";
            } else {
                x[i].style.display = "block";
            }
        }
    }
</script>