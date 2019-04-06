<?php
    include 'profile.php';
    function testSystem()
    {
        $profile = new profile('jrj268');
        $flag = true;
        
        if( $profile->getUser() != 'jrj268' )
        {
            echo "Test failed at getUser()\n";
            $flag = false;
        }
        
        if( $profile->getEmail() != 'jrj268@nau.edu' )
        {
            echo "Test failed at getEmail()\n";
            $flag = false;
        }
        
        if( $profile->getDescript() != "Sakura trees are the best!" )
        {
            echo "Test failed at getDescript()\n";
            $flag = false;
        }
        
        if( $profile->getType() != '3')
        {
            echo "Test failed at getType()\n";
            $flag = false;
        }
        
        if( $flag )
        {
            echo("All tests passed.\n");
        }
        else
        {
            echo("Tests failed");
        } 
        
    }
?>

