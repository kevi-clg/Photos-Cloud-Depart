<?php
include 'php/sessionManager.php';
include_once "models/Users.php";
include_once "models/users.php";


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
    if($User->isAdmin()){
        $imageSRC = "images/Admin.png";
    }
    $UserHTML = <<<HTML
    <div class="UserRow" User_id="$id">
        <div class="UserContainer noselect">
            <div class="UserLayout">
                <div class="UserAvatar" style="background-image:url('$avatar')"></div>
                <div class="UserInfo">
                    <span class="UserName">$name</span>
                    <a href="mailto:$email" class="UserEmail" target="_blank" >$email</a>
                    <img class="control" src=$imageSRC alt="">
                </div>
            </div>
        </div>
    </div>           
    HTML;
    $viewContent = $viewContent . $UserHTML;
}

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addPhotoCmd").hide();
    </script>
HTML;

include "views/master.php";
