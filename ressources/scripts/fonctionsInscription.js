function checkPasswordMatch() {
    var password = document.getElementById("mdp").value;
    var confirmPassword = document.getElementById("mdp2").value;

    if (password !== confirmPassword) {
        return false;
    } else {
        return true;
    }
}

function validateForm(event) {
    if (!checkPasswordMatch()) {
        var url = '../web/controleurFrontal.php?action=afficherInscription&controleur=utilisateurGenerique&messagesFlash[warning][]=Les+mots+de+passe+sont+différents';
        window.location.href = url;
        event.preventDefault();
        return false;
    }
    return true;
}