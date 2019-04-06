<?php 
    include 'profile.php';

    $prof = new profile();
    if( $_POST['username'] != null and $_POST['password'] != null )
    {
        $prof->createProfile( $_POST['username'], $_POST['password'], $_POST['email'], 1 );
    }
?>