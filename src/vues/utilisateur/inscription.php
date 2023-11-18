<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
</head>
<body>

<section class='block-connexion'>
    <div class='bienvenue'>
        <p>BIENVENUE</p>
    </div>
    <div class='infos-compte'>
        <form method='get' action='../web/controleurFrontal.php' onsubmit="return validateForm(event)">
            <p>S'inscrire</p>
            <p>
                <input type='text' placeholder='Email' name='email' required>
            </p>
            <div class='info-details'>
                <p>
                    <input type='text' placeholder='Nom' name='nom' required>
                </p>
                <p>
                    <input type='text' placeholder='Prenom' name='prenom' required>
                </p>
            </div>
            <div class='info-details'>
                <p class='InputAddOn'>
                    <input class='InputAddOn-field' type='password' placeholder='Mot de passe' name='mdp' id='mdp' required>
                </p>
                <p class='InputAddOn'>
                    <input class='InputAddOn-field' type='password' placeholder='Confirmer mot de passe' name='mdp2' id='mdp2' oninput="checkPasswordMatch()" required>
                </p>
                <p id="password-match-message" class="error-message"></p>
            </div>
            <p>
                <?php
                use App\Magasin\Modeles\Repository\UtilisateurRepository;

                $email = isset($_GET['email']) ? $_GET['email'] : '';
                if ((new UtilisateurRepository)->clePrimaireExiste([$email])) {
                    echo "<input class='button' type='submit' value='S\'inscrire'>";
                } else {
                    $warningMessage = urlencode("L'email $email est déjà utilisé");
                    $redirectUrl = "../web/controleurFrontal.php?action=afficherInscription&controleur=utilisateurGenerique&messagesFlash[warning][]=$warningMessage";
                    echo "<input class='button' type='button' value=\"S'inscrire\" onclick=\"window.location.href='$redirectUrl'\">";
                }
                ?>

                <input type='hidden' name='action' value='inscription'>
                <input type='hidden' name='controleur' value='utilisateurGenerique'>
            </p>
            <p><span id='detail'>Déjà un compte ? <a href='controleurFrontal.php?action=afficherConnexion&controleur=utilisateurGenerique'>Connectez-vous</a></span></p>
        </form>
    </div>

    <script src="../../ressources/scripts/fonctionsInscription.js"></script>

</body>
</html>
