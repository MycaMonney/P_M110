<?php
$addonPath = '';
$slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
for ($i = $slashCount; $i > 1; $i--) {
    $addonPath .= '../';
}
?>
<link rel="stylesheet" href="<?= $addonPath ?>styles/index.css">
<section>
    <img id="logoPrincipal" src="assets/img/flagLogo.png" alt="">
    <div style="font-size: 18px;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. At explicabo aspernatur
        excepturi ab neque, totam
        earum quisquam esse nesciunt voluptatum ducimus sint mollitia pariatur dolores perspiciatis eligendi amet
        saepe reiciendis.</div>
</section>