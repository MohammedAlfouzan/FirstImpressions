<?php
    include_once 'utility.php';
    /**
    * Implements the post methods needed for communicating with the database.
    */
    class post
    {
        private $post_id = null;
        private $table = 'post';
        public $targetCurrentID;
        
        //Constructor
        public function __construct( $postID )
        {
            $post_id = $this->fetchPostID( $postID );
            $targetCurrentID = "WHERE post_id = '$this->post_id'";
        }
        
        // Fetches new postID if it exists and stores it in this object.
        public function fetchPostID( $postID )
        {
            if( validateExistence( 'post', 'post_id', $postID ) == true )
            {
                $this->post_id = $postID;
            }
            else
            {
                $this->post_id = null;
            }
        }
        
        // Returns the current post_id in the object or null otherwise.
        public function getPostID()
        {
            return $this->post_id;
        }
        
        // Returns the text associated with the post_id of this object.
        public function getText()
        {
            $results = queryDatabase( $this->table, 'post_text', $this->targetCurrentID );
            
            return $results['post_text'];
        }
        
        // Sets the text for the post_id of this object.
        public function setText( $text )
        {
            alterTable( $this->table, 'post_text', $text, $this->targetCurrentID );
        }
        
        // Gets the date the post was uploaded.
        public function getDate()
        {
            $results = queryDatabase( $this->table, 'post_date', $this->targetCurrentID );
            
            return $results['post_date'];
        }
        
        // Gets the photo stored in the DB.
        /*public function getPhoto()
        {
            $results = queryDatabase( $this->table, 'picture', "WHERE post_id = '$this->post_id'");
            
            echo "<img src=". $results['picture'] .">";
        }*/
        
        // Sets the photo stored in the DB.
        public function setPhoto( $picture )
        {
            alterTable( $this->table, 'picture', $picture, $this->targetCurrentID );
        }
        
        // Gets the title for the current post_id.
        public function getTitle()
        {
            $results = queryDatabase( $this->table, 'post_title', $this->targetCurrentID );
            
            return $results['post_title'];
        }
        
        // Sets the title for the current post_id.
        public function setTitle( $title )
        {
            alterTable( $this->table, 'post_title', $title, $this->targetCurrentID );   
        }
        
        // Gets the upvotes for the current post_id.
        public function getUpvotes()
        {
            $results = queryDatabase( $this->table, 'upvotes', $this->targetCurrentID );
            
            return $results['upvotes'];
        }
        
        // Gets the downvotes for the current post_id.
        public function getDownvotes()
        {
            $results = queryDatabase( $this->table, 'downvotes', $this->targetCurrentID );
            
            return $results['downvotes'];
        }
        
        // Increments the current upvotes of the current post_id.
        public function incrementUpvotes()
        {
            $currentVotes = $this->getUpvotes();
            $currentVotes++;
            
            alterTable( $this->table, 'upvotes', $currentVotes, $this->targetCurrentID );
        }
        
        // Decrements the current upvotes of the current post_id.
        public function decrementUpvotes()
        {
            $currentVotes = $this->getUpvotes();
            if( $currentVotes > 0 )
            {
                $currentVotes--;
            }
            
            alterTable( $this->table, 'upvotes', $currentVotes, $this->targetCurrentID );
        }
        
        // Increments the downvotes of the current post_id.
        public function incrementDownvotes()
        {
            $currentVotes = $this->getDownvotes();
            $currentVotes++;
            
            alterTable( $this->table, 'downvotes', $currentVotes, $this->targetCurrentID );
        }
        
        // Decrements the downvotes of the current post_id.
        public function decrementDownvotes()
        {
            $currentVotes = $this->getDownvotes();
            if( $currentVotes > 0 )
            {
                $currentVotes--;
            }
            
            alterTable( $this->table, 'downvotes', $currentVotes, $this->targetCurrentID );
        }
        
        // Gets the user.
        public function getUser()
        {
            $results = queryDatabase( $this->table, 'username', $this->targetCurrentID );
            
            return $results['username'];
        }
        
        // Gets the category of the post.
        public function getCategory()
        {
            $results = queryDatabase( $this->table, 'category_id', $this->targetCurrentID );
            $category = $results['category_id'];
            
            $results = queryDatabase( 'category', 'category_name', "WHERE category_id = '$category'" );
            
            return $results['category_name'];
        }
        
        // Changes the category of the post.
        public function changeCategory( $newCategory )
        {
            alterTable( $this->table, 'category_id', $newCategory, $this->targetCurrentID );
        }
        
        // Deletes the post.
        public function deletePost()
        {
            deleteRow( $this->table,  "WHERE post_id = '$this->post_id'" );
        }
        
        // Creates a post. 
        public function createPost( $post_text, $username, $post_title, $categoryID, $picture = null )
        {
            $columns = array( 'post_text', 'username', 'post_title', 'picture', 'category_id' );
            $values = array( $post_text, $username, $post_title, $picture, $categoryID );
            
            insertInto( $this->table, $columns, $values );
        }
    }
?>