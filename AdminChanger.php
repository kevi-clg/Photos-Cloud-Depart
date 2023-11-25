<?php
include 'php/sessionManager.php';
include 'models/users.php';

userAccess();

$id = (int) $_GET["id"];
if (!isset($_GET["id"]))
    redirect("illegalAction.php");

    $user = UsersFile()->get($id);

    if ($user->isAdmin()){
        $user->setType(0);
    }else{
        $user->setType(1);
    }

    UsersFile()->update($user);

    redirect("usersList.php?id=$id");



?>