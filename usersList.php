<?php
include 'php/sessionManager.php';
include_once "models/Users.php";



userAccess();
$user = UsersFile()->findByKey("id", $_SESSION['currentUserId']);
if(!$user->isAdmin()){
    redirect('illegalAction.php');
}


$viewTitle = "Liste des usagers";
$list = UsersFile()->toArray();
$viewContent = "";

foreach ($list as $User) {
    $id = strval($User->id());
    $name = $User->name();
    $email = $User->Email();
    $avatar = $User->Avatar();
    $imageSRC = "images/usager.png";
    
    
    if(!$User->isBlocked()){
        $face = '<i class="fas fa-smile" style="font-size:24px;color:green"></i>';
    }
    else{
        $face = '<i class="fas fa-frown" style="font-size:24px;color:red"></i>';
    }

    if($user->isAdmin()){
        $adminIcone;
    }
    $UserHTML = <<<HTML
    <div class="UserRow" User_id="$id">
        <div class="UserContainer noselect">
            <div class="UserLayout">
                <div class="UserAvatar" style="background-image:url('$avatar')"></div>
                <div class="UserInfo">
                    <span class="UserName">$name</span>
                    <a href="mailto:$email" class="UserEmail" target="_blank" >$email</a>
                    <a href="loginForm.php">login</a>
                    <a href="blockedUnblocked.php?id=$id">$face</a>
                    <a href="confirmDeleteProfil?id=$id"><i class="fas fa-user-alt-slash" style="font-size:24px;color:orange"></i></a>
                    
                </div>
            </div>
        </div>
    </div>           
    HTML;
    if($User != $user){
        $viewContent = $viewContent . $UserHTML;
    }
    
}

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addPhotoCmd").hide();
    </script>
HTML;

include "views/master.php";
