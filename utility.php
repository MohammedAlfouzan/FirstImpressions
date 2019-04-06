<?php

    function deleteRow( $table, $condition )
    {
        $sql = "DELETE FROM " . $table . " " . $condition . ";";
        
        sendQuery( $sql );
    }

   /* 
    *  Method: alterTable
    *  Function: Alters the corresponding column/columns with the new values everywhere
       or satisfying a specific query.
    */
    function alterTable( $table, $columns, $values, $condition = null )
    {
        if( !is_array( $columns ) and !is_array( $values ) )
        {
            $sql = "UPDATE $table SET $columns = '$values' $condition;";
        }
        
        sendQuery( $sql );     
    }

    /*
      Method: insertInto
      Function: Generates the SQL queries necessary for inserting into the database.
      @param $table The String representation of the table being inserted into.
      @param $columns The array of columns for which values will be referenced.
      @param $values  The array of values for which will be inserted.
      
      !!!NOTE: ARRAY VALUES AND COLUMNS MUST MATCH WITHIN THE ARRAYS OR IT WON'T WORK.!!!
      Index [0] in columns must reference the appropriate type within Index[0] of values.
      E.G. Username = CHARVALUE
    */
    function insertInto( $table, $columns, $values )
    {
        $index = 0;
        $sql = "INSERT INTO $table ( ";
        
        if( sizeof( $columns ) != sizeof( $values ) )
        {
            echo("Error: insertInto argument for columns and values must have the same length.\n");
            return null;
        }

        
        for( $index = 0; $index < sizeof( $columns ); $index++ )
        {
            if( $index == ( sizeof( $columns ) - 1 ) )
            {
                $sql.= $columns[ $index ] . " )";
            }
            else
            {
                $sql.= $columns[ $index ] . ", ";
            }
        
        }
        

        $sql .= " VALUES ( ";
        
        for( $index = 0; $index < sizeof( $values ); $index++ )
        {
            if( $index == ( sizeof( $values ) - 1 ) )
            {
                $sql.= "'" . $values[ $index ] . "' );";
            }
            else
            {
                $sql.= "'" . $values[ $index ] . "', ";
            }
        
        }
        
        sendQuery( $sql );
    }
    

    /*
      Method: connectToDatabse
      Funciton: Establishes the connection to the NAU Database.
    */
    function connectToDatabase()
    {
        // Validation Credentials
        $Username = "ma2594";
        $Password = "5105780";
        $Server = "tund.cefns.nau.edu";
        
        // Connection object.
        $conn = mysqli_connect( $Server, $Username, $Password, "ma2594" );
        
        // Ensure proper connection.
        if( mysqli_connect_errno() )
        {
            die( "Connection failed to establish." . $conn->mysqli_connect_error );
        }
        
        return $conn;
    }

    function sendQuery( $sql )
    {
        $conn = connectToDatabase();
        
        $results = $conn->query( $sql );
        $rows = mysqli_fetch_assoc( $results );
        
        mysqli_close( $conn );
        
        return $rows;
    }

    function queryDatabase( $table, $column, $condition = null, $flag = 0)
    {
        $sql = "SELECT $column FROM $table $condition;";

        if( $flag == 1 )
        {
            $conn = connectToDatabase();
        
            return $conn->query( $sql );
        }
        
        return sendQuery( $sql );
    }

    function validateExistence( $table, $column, $value )
    {

        $value = queryDatabase( $table, $column, "WHERE $column = '$value'" );

        if( $value[ $column ] != null )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

?>