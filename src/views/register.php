<link rel="stylesheet" href="styles/login.css">
<img id="logo" src="assets/img/flagLogo.png" alt="">
<div id="form">
    <form action="/register" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" maxlength="85" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <label for="region">Région</label>
        <select name="region" id="region" required>
            <option value="" selected disabled>Choisissez une région</option>
            <?php foreach ($regions as $region) { ?>
                <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
            <?php } ?>
        </select>

        <input type="submit" id="btnSubmitForm" value="Envoyer">
    </form>
</div>
<a style="color: black;" href="/login">Vous possédez déjà un compte ? </a>

<script src="frontend/login.js"></script>