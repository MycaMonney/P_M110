<link rel="stylesheet" href="styles/login.css">
<img id="logo" src="assets/img/flagLogo.png" alt="">
<div id="form">
    <form action="/login" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" maxlength="85" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" id="btnSubmitForm" value="Envoyer">
    </form>
</div>
<a style="color: black;" href="/register">Vous n'avez pas de compte ?</a>

<script src="frontend/login.js"></script>