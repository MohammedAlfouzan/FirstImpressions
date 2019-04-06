<?php
    include_once('utility.php');

    class category
    {
        // Field variable for the table that this class references.
        private $table = 'category';
        
       /******************************************************************************
        * Method: createCategory
        * Functionality: Creates a category in the database with the associated name
        * paramater.
        * @param $name : String, The name of the new category.
        ******************************************************************************/
        public function createCategory( $name )
        {
            $columns = array( 'category_name' );
            $values = array( $name );
            
            insertInto( $this->table, $columns, $values );
        }
        
        /******************************************************************************
        * Method: getNumberOfPosts
        * Functionality: Counts the number of posts in a given category passed in as 
        * a parameter.
        * @param $category_id : int, The category to be analyzed.
        * @return $numOfPosts : int, The number of posts in that category. 
        ******************************************************************************/
        public function getNumberOfPosts( $category_id )
        {
            $numOfPosts = 0;
            $result = queryDatabase( 'post', 'category_id', "WHERE category_id = '$category_id'", 1 );
            
            while( $row = mysqli_fetch_array($result) )
            {
                $numOfPosts++;
            }
            
            return $numOfPosts;
        }
        
        /******************************************************************************
        * Method: getTopRatedPosts( $number )
        * Functionality: Gets the top upvotes posts on the platfrom.
        * <p>
        * @param $number, int, DEFAULT = 5 : The number of posts to get from the top.
        * @return $posts, int[], The array with the post_id's of the corresponding top
        * posts.
        ******************************************************************************/
        public function getTopRatedPosts( $number = 5 )
        {
            $posts = array();
            $results = queryDatabase('post', 'post_id', "ORDER BY upvotes DESC LIMIT $number", 1 );
            
            while( $row = mysqli_fetch_array($results) )
            {
                array_push( $posts, $row['post_id']);
            }
                
            return $posts;
        }
    }
?>
