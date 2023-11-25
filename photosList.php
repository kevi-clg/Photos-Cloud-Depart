<?php
include 'php/sessionManager.php';
include "models/photos.php";
include "models/users.php";
$viewName="photoList";
userAccess();
$viewTitle = "Liste de photos";
$list = PhotosFile()->toArray();
$viewContent = "<div class='photosLayout'>";
$user = UsersFile()->findByKey("id", $_SESSION['currentUserId']);
$ajouterPhoto = ' <a href="newPhotoForm.php" class="cmdIcon fa fa-plus" title="Ajouter une photo"></a>';

$list2 = [];
$sort = "";
if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
}

if ($sort == 'owners'){
   
}
else if ($sort == 3){
    foreach ($list as $key) {
        if($key->OwnerId() == $user->Id()){
            array_push($list2, $key);
        }
        $list = $list2;
        
    }
}
foreach ($list as $photo) {
    $id = strval($photo->id());
    
    $title = $photo->Title();
    $description = $photo->Description();
    $image = $photo->Image();
    $owner = UsersFile()->Get($photo->OwnerId());
    $ownerName = $owner->Name();
    $ownerAvatar = $owner->Avatar();
    $shared = $photo->Shared() == "true";
    $sharedIndicator = "";
    $editCmd = "";
    $visible = $shared;
    if (($photo->OwnerId() == (int)$_SESSION["currentUserId"]) || $user->isAdmin()) {
        $visible = true;
        $editCmd = <<<HTML
            <a href="editPhotoForm.php?id=$id" class="cmdIconSmall fa fa-pencil" title="Editer $title"> </a>
            <a href="confirmDeletePhoto.php?id=$id"class="cmdIconSmall fa fa-trash" title="Effacer $title"> </a>
        HTML;
        if ($shared) {
            $sharedIndicator = <<<HTML
                <div class="UserAvatarSmall transparentBackground" style="background-image:url('images/shared.png')" title="partagée"></div>
            HTML;
        } 
    }
    if ($visible) {
    $photoHTML = <<<HTML
        <div class="photoLayout" photo_id="$id">
            <div class="photoTitleContainer" title="$description">
                <div class="photoTitle ellipsis">$title</div> $editCmd</div>
            <a href="pagePhoto.php?id=$id" >
                <div class="photoImage" style="background-image:url('$image')">
                    <div class="UserAvatarSmall transparentBackground" style="background-image:url('$ownerAvatar')" title="$ownerName"></div>
                    $sharedIndicator
                </div>
            </a>
        </div>           
        HTML;
        $viewContent = $viewContent . $photoHTML;
    }
}
$viewContent = $viewContent . "</div>";

$viewScript = <<<HTML
    <script src='js/session.js'></script>
    <script defer>
        $("#addphotoCmd").hide();
    </script>
HTML;

include "views/master.php";
