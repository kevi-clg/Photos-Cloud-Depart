<?php

include_once 'models/photos.php';
include_once 'models/users.php';

$id = (int) $_GET["id"];
if (!isset($_GET["id"]))
    redirect("illegalAction.php");


    $photo = PhotosFile()->get($id);
    $image = $photo->Image();
    $titre = $photo->Title();
    $ownerId = $photo->OwnerId();
    $user = UsersFile()->findByKey("id",$ownerId );
    $auteur = $user->Name();
    $description = $photo->Description();
    $date = $photo->CreationDate();
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); 
    $date_formatee = strftime('%A le %e %B %Y', $date);
    $ajouterPhoto = ' <a href="photosList.php" class="cmdIcon fa fa-x" title="Retour"></a>';
    
    
    $ownerAvatar = $user->Avatar();

    $viewTitle = $titre;
    $viewContent = <<<HTML
        <div class="photoLayout" photo_id="$id">

                
            <a href="pagePhoto.php?id=$id" >
                <div class="photoImage2" style="background-image:url('$image')">
                <div class="UserAvatarSmall transparentBackground" style="background-image:url('$ownerAvatar')" ></div>
                    
                </div>
                    
            </a>
            <br><br><br>
            <div style="padding:20px;">Auteur: $auteur</div>

            <div style="padding:20px;">Description: $description</div>
            <div style="padding:20px;">Date de publication: $date_formatee</div>
          
    HTML;
    
   // <div><img src="$image"></div>
include_once 'views/master.php';


?>