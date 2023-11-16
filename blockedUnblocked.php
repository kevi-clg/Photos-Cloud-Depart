<?php
include 'php/sessionManager.php';
include 'models/users.php';

userAccess();

$id = (int) $_GET["id"];
if (!isset($_GET["id"]))
    redirect("illegalAction.php");

    $user = UsersFile()->get($id);

    if ($user->isBlocked()){
        $user->setBlocked(0);
    }else{
        $user->setBlocked(1);
    }

    UsersFile()->update($user);

    redirect("usersList.php?id=$id");



?>