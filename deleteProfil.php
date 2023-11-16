<?php
include 'php/sessionManager.php';
include 'models/users.php';
include 'models/photos.php';

userAccess();

$currentUserId = (int) $_GET["id"];

do {
    $photos = PhotosFile()->toArray();
    $oneDeleted = false;
    foreach ($photos as $photo) {
        if ($photo->OwnerId() == $currentUserId) {
            $oneDeleted = true;
            PhotosFile()->remove($photo->Id());
            break;
        }
    }
} while ($oneDeleted);

UsersFile()->remove($currentUserId);
if($_SESSION["currentUserId"]->isAdmin()){
    redirect('usersList.php');
}
redirect('loginForm.php');