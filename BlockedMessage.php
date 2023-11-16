<?php
$viewTitle = "Usager bloqué!";
$viewContent = <<<HTML
    <br>
    <div class="loginForm">
    <h4>Votre compte à été bloqué.</h4><br><br>
    <h2><a href='loginForm.php'>Connexion</a></h2>
    </div>
HTML;
$viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
        HTML;
include "views/master.php";