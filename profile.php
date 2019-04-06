<?php  
    include_once('utility.php');
    include_once('post.php');
    
    class profile
    {
        // The user that this object references if any. 
        private $user = null;
        
        // The table that this object references.
        private $table = 'profile';
        
        // The post that has been selected by this user.
        private $post = null;
        
         /******************************************************************************
        * Method: __construct( $username )
        * Functionality: The constructor for the profile class given one parameter. 
        * By default, upon object creation the system checks whether the username exists.
        * If it does, it will store it in the private local field variable $user.
        * <p>
        * @param $username : String, The username of the associated user to be fetched 
        *  from the DB.
        ******************************************************************************/
        public function __construct( $username )
        {
            $this->fetchUser( $username ); 
        }
        
        /******************************************************************************
        * Method: fetchUser( $username ) 
        * Functionality: Fetches the user passed in as a parameter if it exists from 
        * the database and places it in the local private field variable $user.
        * <p>
        * @param $username : String, The username of the referenced account.
        ******************************************************************************/
        public function fetchUser( $username )
        {
            if( validateExistence( 'profile', 'username', $username ) == true )
            {
                $this->user = $username;
                $this->post = new post();
            }
        }
        
         /******************************************************************************
        * Method: getUser()
        * Functionality: Returns the current referenced user of this object.
        * <p>
        * @return String : The username of the associated user stored in this object.
        ******************************************************************************/
        public function getUser()
        {
            return $this->user;
        }  
        
        /******************************************************************************
        * Method: getEmail()
        * Functionality: Returns the email of the current referenced user of this object.
        * <p>
        * @return String : The email of the associated user stored in this object.
        ******************************************************************************/
        public function getEmail()
        {
            $results = queryDatabase( $this->table, 'email', "WHERE username = '$this->user'" );
            
            return $results['email'];
        }
        
        /******************************************************************************
        * Method: getType()
        * Functionality: Returns the account type of current referenced user of this object.
        * <p>
        * @return String : The account type of the associated user stored in this object.
        ******************************************************************************/
        public function getType()
        {
            $results = queryDatabase( $this->table, 'typeId', "WHERE username = '$this->user'");
      
            return $results[ 'typeId' ];
        }
        
         /******************************************************************************
        * Method: getPassword()
        * Functionality: Returns the password of current referenced user of this object.
        * <p>
        * @return String : The password of the associated user stored in this object.
        ******************************************************************************/
        private function getPassword()
        {
            $results = queryDatabase( $this->table, 'password', "WHERE username = '$this->user'");
            
            return $results['password'];
        }
        
         /******************************************************************************
        * Method: getDescript()
        * Functionality: Returns the profile description current referenced user
        * of this object.
        * <p>
        * @return String : The profile description of the associated user stored in this object.
        ******************************************************************************/
        public function getDescript()
        {
            $results = queryDatabase( $this->table, 'profile_descript', "WHERE username = '$this->user'");
 
            return $results['profile_descript'];
        }
        
        /******************************************************************************
        * Method: showFavorites()
        * Functionality: Returns the array of category names which have been 
        * favorited by the current user stored in this object.
        * <p>
        * @return String[] : Thelist of favorited categorys by the associated user stored 
        * in this object.
        ******************************************************************************/
        public function showFavorited()
        {
            $index = 0;
            $result = queryDatabase( 'favorites', 'category_id', "WHERE username = '$this->user'", 1);
            $categories = array();
            $categoryNames = array();
            
            while( $row = mysqli_fetch_array( $result ) )
            {
                array_push( $categories, $row['category_id'] );
            }
            
            foreach( $categories as $category )
            {
                $results = queryDatabase( 'category', 'category_name', "WHERE category_id = '$category'");
                array_push( $categoryNames, $results['category_name'] );
            }
            
            return $categoryNames;     
        }
        
         /******************************************************************************
        * Method: validatePassword( $password )
        * Functionality: Checks if the password parameter is the same as the user
        * referenced in this object.
        * <p>
        * @param $password : String, The password to be validated against.
        * @return Boolean : True if the same, false otherwise.
        ******************************************************************************/
        public function validatePassword( $password )
        {
            $pass = $this->getPassword();
            
            if( $password == $pass )
            {
                return true;
            }
            return false;
        }
        
        /******************************************************************************
        * Method: setEmail( $email )
        * Functionality: Sets the email associated with the referenced user in this
        * object.
        * <p>
        * @param $email : String, The new email.
        ******************************************************************************/
        public function setEmail( $email )
        {
            $column = "email";
            $value = $email;
            
            alterTable( $this->table, $column, $value, "WHERE username = '$this->user'" );
        }
        
        /******************************************************************************
        * Method: setDescript( $descript )
        * Functionality: Sets the profile description for the user associated in this
        * object.
        * <p>
        * @param $descript : String, The new profile description.
        ******************************************************************************/
        public function setDescript( $descript )
        {
            $column = "profile_descript";
            $value = $descript;
            
            alterTable( $this->table, $column, $value, "WHERE username = '$this->user'");
        }
        
        /******************************************************************************
        * Method: setDescript( $otherUser, $typeID )
        * Functionality: Sets the type for the parameter $otherUser to the parameter
        * $typeID.
        * <p>
        * @param $otherUser : String, The profile whose type should be changed.
        * @param $typeID : int, The new account type for the referenced profile.
        * NOTE: This funciton cannot be preformed unless the current account stored in
        * this object is of the admin type ( type_id = 3 ).
        ******************************************************************************/
        public function setType( $otherUser, $typeID )
        {
            $type = $this->getType();
            $adminType = 3;
            
            if( $type != $adminType )
            {
                echo("Error, you do not have permission to preform this operation.");
            }
            else
            {
                $column = 'typeId';
                $value = $typeID;
                
                alterTable( $this->table, $column, $value, "WHERE username = '$otherUser'");  
            }
        }
        
        /******************************************************************************
        * Method: favorite( $category )
        * Functionality: Favorites the category passed in as a parameter for the current
        * user referenced in this object.
        * <p>
        * @param $category : int, The category_id of the category to be favorited.
        ******************************************************************************/
        public function favorite( $category )
        {
            $columns = array( 'username', 'category_id');
            $values = array( $this->user, $category );
            insertInto( 'favorites', $columns, $values );
        }
        
        /******************************************************************************
        * Method: unfavorite( $category )
        * Functionality: Unfavorites the category passed in as a parameter for the current
        * user referenced in this object.
        * <p>
        * @param $category : int, The category_id of the category to be unfavorited.
        ******************************************************************************/
        public function unfavorite( $category )
        {
            deleteRow( 'favorites', "WHERE username = '$this->user' AND category_id = '$category'");
        }
        
        /******************************************************************************
        * Method: createProfile( $username, $password, $email, $typeID )
        * Functionality: Creates a new profile with the passed in parameters.
        * <p>
        * @param $username : String The new username to be created.
        * @param $password : String The password of the new profile.
        * @param $email    : String The email of the new profile.
        * @param $typeID   : int    The account type of the new profile.
        ******************************************************************************/
        public function createProfile( $username, $password, $email, $typeID )
        {
            $columns = array( 'username', 'password', 'email', 'typeId' );
            $values = array( $username, $password, $email, $typeID );
            
            insertInto( $this->table, $columns, $values );
        }
        
        /******************************************************************************
        * Method: deleteProfile( $username )
        * Functionality: Deletes the profile passed in as a parameter.
        * <p>
        * @param $username : String The profile to be deleted.
        * NOTE: This action deletes the user and ALL associated posts from that user.
        ******************************************************************************/
        public function deleteProfile( $username )
        {
            deleteRow( 'post', "WHERE username = '$username'");
            deleteRow( $this->table, "WHERE username = '$username'");
        }
        
        /******************************************************************************
        * Method: createPost( $post_text, post_title, category_id, picture )
        * Functionality: Creates a new post with the passed in parameters.
        * <p>
        * @param $post_text : String, The text of the post to be created.
        * @param $post_title : String, The title of the post to be created.
        * @param $category_id : int, The category to post in.
        * @param $picture : VARBINARY(1MB), DEFAULT = null, The picture associated with a
        * post.
        ******************************************************************************/
        public function createPost( $post_text, $post_title, $category_id, $picture = null )
        {
            echo"here";
            $this->post->createPost( $post_text, $this->user, $post_title, $category_id, $picture );
        }
        
        
        /******************************************************************************
        * Method: deleteProfile( $username )
        * Functionality: Deletes the profile passed in as a parameter.
        * <p>
        * @param $username : String The profile to be deleted.
        * NOTE: This action deletes the user and ALL associated posts from that user.
        * An account of moderator type can delete any post (type_id = 2);
        ******************************************************************************/
        public function deletePost()
        {
            if( $this->post != null and $this->post->getUser() == $this->user )
            {
                $this->post->deletePost();
            }
        }
        
        /******************************************************************************
        * Method: selectPost( $postID )
        * Functionality: Selects the post referenced by the passed in postID.
        * <p>
        * @param $postID : int The postID of the post to select.
        ******************************************************************************/
        public function selectPost( $postId )
        {
            $this->post->fetchPostID( $postId );
        }
        
        /******************************************************************************
        * Method: upvote()
        * Functionality: Upvotes the selected post by this user.
        ******************************************************************************/
        public function upvote()
        {
            if( $this->post != null )
            {
                $this->post->incrementUpvotes();
            }
        }
        
        /******************************************************************************
        * Method: downvote()
        * Functionality: Downvotes the selected post by this user.
        ******************************************************************************/
        public function downvote()
        {
            if( $this->post != null )
            {
                $this->post->incrementDownvotes();
            }
        }
    } 
?>