<?php
    include 'php/sessionManager.php';
    include 'models/users.php';
    $viewTitle = "Retrait de compte";
    
    userAccess(200);

    
   
        $user = UsersFile()->findByKey("id", $_SESSION['currentUserId']);
        if ($user->isAdmin()){
            $url = 'usersList.php';
            $id = (int) $_GET["id"];
        }else{
            $url = 'editProfilForm.php';
            $id = (int) $_SESSION["currentUserId"];
        }
        

    $viewContent = <<<HTML
    <div class="content loginForm">
        <br>
       <h3> Voulez-vous vraiment effacer le compte? </h3>
        <div class="form">
            <a href="deleteProfil.php?id=$id"><button class="form-control btn-danger">Effacer le compte</button>
            <br>
            <a href=$url class="form-control btn-secondary">Annuler</a>
        </div>
    </div>
    HTML;
    $viewScript = <<<HTML
        <script defer>
            $("#addPhotoCmd").hide();
        </script>
    HTML;
    include "views/master.php";