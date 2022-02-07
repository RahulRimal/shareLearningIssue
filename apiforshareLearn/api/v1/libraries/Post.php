<?php

class PostException extends Exception
{
}

class Post
{
    private $db;

    private $id;
    private $userId;
    private $bookName;
    private $author;
    private $description;
    private $boughtDate;
    private $price;
    private $bookCount;
    private $wishlistd;
    private $postType;
    private $postRating;
    private $postedOn;


    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (PDOException $ex) {
            error_log('fun Post Construct -->: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error !!");
            $response->send();
            exit;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getBookName()
    {
        return $this->bookName;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getBoughtDate()
    {
        return $this->boughtDate;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getBookCount()
    {
        return $this->bookCount;
    }

    public function getWishlisted()
    {
        return $this->wishlistd;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function getPostRating()
    {
        return $this->postRating;
    }

    public function getPostedTime()
    {
        return $this->postedOn;
    }

    public function setId($id)
    {
        if (is_null($id))
            throw new PostException('Post ID can\'t be null');
        elseif (empty($id))
            throw new PostException('Post ID can\'t be empty');
        elseif (!is_numeric($id))
            throw new PostException('Post ID must be a number');
        else
            $this->id = $id;
    }

    public function setUserId($userId)
    {
        if (is_null($userId))
            throw new PostException('User ID can\'t be null');
        elseif (empty($userId))
            throw new PostException('User ID can\'t be empty');
        elseif (!is_numeric($userId))
            throw new PostException('User ID must be a number');
        else
            $this->userId = $userId;
    }

    public function setBookName($bookName)
    {
        if (is_null($bookName))
            throw new PostException('Book name can\'t be null');
        elseif (empty($bookName))
            throw new PostException('Book name can\'t be empty');
        elseif (strlen($bookName) < 2 || strlen($bookName) > 255)
            throw new PostException('Invalid Character length for book name');
        else
            $this->bookName = $bookName;
    }

    public function setAuthor($author)
    {
        if (is_null($author))
            $this->author = null;
        if (empty($author))
            // throw new PostException('Author can\'t be empty');
            $this->author = null;
        elseif (strlen($author) < 2 || strlen($author) > 255)
            throw new PostException('Invalid Character length for author');
        else
            $this->author = $author;
    }


    public function setDescription($description)
    {
        if (is_null($description))
            throw new PostException('Description can\'t be null');
        elseif (empty($description))
            throw new PostException('Description can\'t be empty');
        else
            $this->description = $description;
    }

    public function setBoughtDate($boughtDate)
    {
        if (is_null($boughtDate))
            throw new PostException('Bought date can\'t be null');
        elseif (empty($boughtDate))
            throw new PostException('Bought date can\'t be empty');
        else
            $this->boughtDate = $boughtDate;
    }

    public function setPrice($price)
    {
        $price = intval($price);
        if (is_null($price))
            throw new PostException('Price can\'t be null');
        elseif (empty($price))
            throw new PostException('Price can\'t be empty');
        elseif (!is_numeric($price))
            throw new PostException('Book Price must be a number');
        else
            $this->price = $price;
    }

    public function setPostType($postType)
    {
        if (is_null($postType))
            throw new PostException('Post type can\'t be null');
        elseif (empty($postType))
            throw new PostException('Post type can\'t be empty');
        // elseif ($postType != 'S' || $postType != 'B')
        //     throw new PostException('Post type must be either Selling or Buying');
        else
            $this->postType = $postType;
    }

    public function setBookCount($bookCount)
    {
        if (is_null($bookCount))
            $this->bookCount = null;
        if (empty($bookCount))
            // throw new PostException('Books Count can\'t be empty');
            $this->bookCount = null;
        elseif (!is_numeric($bookCount))
            throw new PostException('Books count must be numeric value');
        else
            $this->bookCount = $bookCount;
    }

    public function setBookWishlist($wishlistd)
    {
        if (is_null($wishlistd))
            $this->wishlistd = null;
        if (empty($wishlistd))
            // throw new PostException('Book wishlist can\'t be empty');
            $this->wishlistd = null;
        elseif (!is_numeric($wishlistd))
            throw new PostException('Book wishlist must be numeric value');
        else
            $this->wishlistd = $wishlistd;
    }


    public function setPostRating($rating)
    {
        if (is_null($rating))
            $this->postRating = null;
        if (empty($rating))
            // throw new PostException('Post ratings can\'t be empty');
            $this->postRating = null;
        elseif (!is_numeric($rating))
            throw new PostException('Post rating must be numeric value');
        // elseif (!is_numeric($rating) || !is_float($rating))
        // elseif (!is_float($rating))
        //     throw new PostException('Post rating must be a numeric value');
        else
            $this->postRating = $rating;
    }

    public function setPostedOn($postedOn)
    {
        if (is_null($postedOn))
            throw new PostException('Posted date can\'t be null');
        else
            $this->postedOn = $postedOn;
    }

    public function setPostFromRow($row)
    {
        $this->setId($row->id);
        $this->setUserId($row->userId);
        $this->setBookName($row->bookName);
        $this->setAuthor($row->author);
        $this->setDescription($row->description);
        $this->setBoughtDate($row->boughtDate);
        $this->setPrice($row->price);
        $this->setBookCount($row->bookCount);
        $this->setBookWishlist($row->wishlisted);
        $this->setPostType($row->postType);
        $this->setPostRating($row->postRating);
        $this->setPostedOn($row->postedOn);
    }

    public function setPostFromArray($data)
    {
        isset($data['bookName']) ?
            $this->setBookName($data['bookName']) : false;
        isset($data['author']) ? $this->setAuthor($data['author']) : $this->setAuthor(null);
        isset($data['description']) ? $this->setDescription($data['description']) : false;
        isset($data['boughtDate']) ? $this->setBoughtDate($data['boughtDate']) : false;
        isset($data['price']) ? $this->setPrice($data['price']) : false;
        isset($data['wishlisted']) ? $this->setBookWishlist($data['wishlisted']) : false;
        isset($data['bookCount']) ? $this->setBookCount($data['bookCount']) : false;
        isset($data['postType']) ? $this->setPostType($data['postType']) : false;
        isset($data['postRating']) ? $this->setPostRating($data['postRating']) : $this->setPostRating(null);
        isset($data['postedOn']) ? $this->setPostedOn($data['postedOn']) : false;
    }

    public function returnPostAsArray()
    {
        $post = array();

        $post['id'] = $this->id;
        $post['userId'] = $this->userId;
        $post['bookName'] = $this->bookName;
        $post['author'] = $this->author;
        $post['description'] = $this->description;
        $post['boughtDate'] = $this->boughtDate;
        $post['price'] = $this->price;
        $post['bookCount'] = $this->bookCount;
        $post['wishlisted'] = $this->wishlistd;
        $post['postType'] = $this->postType;
        $post['postRating'] = $this->postRating;
        $post['postedOn'] = $this->postedOn;

        return $post;
    }

    private function getPost($id)
    {
        try {
            $this->setId($id);

            $this->db->query('SELECT * FROM post where id = :postId');
            $this->db->bind(':postId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0)
                return $row;
            else {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Post not found");
                $response->send();
                exit;
            }
        } catch (PDOException $ex) {
            error_log("Fun->GetUserById.. :" . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Couldn't retrieve data from database");
            $response->send();
            exit;
        }
    }

    public function getUserPost($uid)
    {
        try {
            $this->setUserId($uid);

            $this->db->query('SELECT * FROM post WHERE userId = :userId');
            $this->db->bind(":userId", $this->userId);

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {

                $postArray = array();

                foreach ($rows as $row) {
                    $this->setPostFromRow($row);

                    $postArray[] = $this->returnPostAsArray();
                }

                    $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $postArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Posts retrievd successfully');
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve posts, please try again');
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getPostById($id)
    {
        $id = intval($id);

        try {
            $this->setId($id);

            $this->db->query('SELECT * FROM post WHERE id = :postId');
            $this->db->bind(':postId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->setPostFromRow($row);

                $postArray[] = $this->returnPostAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $postArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Posts retrievd successfully');
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function postExists($uid, $bookId = null, $bookName = null)
    {
        try {
            $this->setUserId($uid);
            if (!is_null($bookId)) {

                $this->setId($bookId);
                $this->db->query('SELECT COUNT(id) as totalCount FROM post where userId = :userId AND id = :bookId');

                $this->db->bind(':userId', $this->userId);
                $this->db->bind(':bookId', $this->id);
            } elseif (!is_null($bookName)) {
                $this->setBookName($bookName);
                $this->db->query('SELECT COUNT(id) as totalCount FROM post where userId = :userId AND bookName = :book');

                $this->db->bind(':userId', $this->userId);
                $this->db->bind(':book', $this->bookName);
            } else {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
            $row = $this->db->single();

            if ($row->totalCount > 0)
                return true;

            return false;
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function createPost($uid, $data)
    {
        $uid = intval($uid);

        try {
            $this->setUserId($uid);
            $data['postedOn'] = date("Y-m-d H:i:s");
            $this->setPostFromArray($data);

            if ($this->postExists($this->userId, null, $this->bookName)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Book already Posted");
                $response->send();
                exit;
            }

            $this->db->query('INSERT INTO post (id, userId, bookName, author, description, boughtDate, price, bookCount, wishlisted, postType, postRating, postedOn) VALUES (null, :userId, :bookName, :author, :description, :boughtDate, :price, :bookCount, :wishlisted, :postType, :postRating, null)');

            $this->db->bind(':userId', $this->userId);
            $this->db->bind(':bookName', $this->bookName);
            $this->db->bind(':author', $this->author);
            $this->db->bind(':description', $this->description);
            $this->db->bind(':boughtDate', $this->boughtDate);
            $this->db->bind(':price', $this->price);
            $this->db->bind(':bookCount', $this->bookCount);
            $this->db->bind(':wishlisted', $this->wishlistd);
            $this->db->bind(':postType', $this->postType);
            $this->db->bind(':postRating', $this->postRating);

            if ($this->db->execute()) {
                $postId = $this->db->lastInsertId();
                $this->setId($postId);

                if (is_null($this->id)) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get post data after creating new post");
                    $response->send();
                    exit;
                }

                $this->db->query('SELECT * FROM  post where id = :postId');
                $this->db->bind(":postId", $this->id);

                $row = $this->db->single();

                if ($this->db->rowCount() < 1) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get post data after creating new post");
                    $response->send();
                    exit;
                }

                $this->setPostFromRow($row);

                $userArray = array();

                $userArray[] = $this->returnPostAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['posts'] = $userArray;

                $response = new Response();
                $response->setHttpStatusCode(201);
                $response->setSuccess(true);
                $response->addMessage("Post Created Successfully");
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error creating new post, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }


    public function updatePost($id, $data)
    {
        try {
            $data['userId'] = intval($data['userId']);
            $this->setUserId($data['userId']);
            $this->setId($id);

            $this->setPostFromArray($data);

            if (!$this->postExists($this->userId, $this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the post to update");
                $response->send();
                exit;
            }

            $bookNameUpdated = false;
            $authorUpdated = false;
            $descriptionUpdated = false;
            $boughtDateUpdated = false;
            $priceUpdated = false;
            $bookCountUpdated = false;
            $wishlistdUpdated = false;
            $postTypeUpdated = false;
            $postRatingUpdated = false;

            $queryFields = "";

            $this->db->query('SELECT * FROM post where id = :postId');
            $this->db->bind(":postId", $this->id);

            $row = $this->db->single();

            $this->setPostFromRow($row);

            if (array_key_exists('bookName', $data)) {
                if ((strcmp($data["bookName"], $this->bookName)) != 0) {
                    $bookNameUpdated = true;
                    $this->setBookName($data['bookName']);
                    $queryFields .= "bookName = :bookName, ";
                }
            }

            if (array_key_exists('author', $data)) {
                if (!is_null($this->author)) {
                    if ((strcmp($data["author"], $this->author)) != 0) {
                        $authorUpdated = true;
                        $this->setAuthor($data['author']);
                        $queryFields .= "author = :author, ";
                    }
                } else {
                    $authorUpdated = true;
                    $this->setAuthor($data['author']);
                    $queryFields .= "author = :author, ";
                }
            }

            if (array_key_exists('description', $data)) {
                if ((strcmp($data["description"], $this->description)) != 0) {
                    $descriptionUpdated = true;
                    $this->setDescription($data['description']);
                    $queryFields .= "description = :description, ";
                }
            }

            if (array_key_exists('boughtDate', $data)) {
                if ((strcmp($data["boughtDate"], $this->boughtDate)) != 0) {
                    $boughtDateUpdated = true;
                    $this->setBoughtDate($data['boughtDate']);
                    $queryFields .= "boughtDate = :boughtDate, ";
                }
            }

            if (array_key_exists('price', $data)) {
                if ((strcmp($data["price"], $this->price)) != 0) {
                    $priceUpdated = true;
                    $this->setPrice($data['price']);
                    $queryFields .= "price = :price, ";
                }
            }

            if (array_key_exists('bookCount', $data)) {
                if ((strcmp($data["bookCount"], $this->bookCount)) != 0) {
                    $bookCountUpdated = true;
                    $this->setBookCount($data['bookCount']);
                    $queryFields .= "bookCount = :bookCount, ";
                }
            }

            if (array_key_exists('wishlisted', $data)) {
                if ((strcmp($data["wishlisted"], $this->wishlistd)) != 0) {
                    $wishlistedUpd = true;
                    $this->setBookWishlist($data['wishlisted']);
                    $queryFields .= "wishlisted = :wishlisted, ";
                }
            }

            if (array_key_exists('postType', $data)) {
                if ((strcmp($data["postType"], $this->postType)) != 0) {
                    $postTypeUpdated = true;
                    $this->setPostType($data['postType']);
                    $queryFields .= "postType = :postType, ";
                }
            }

            if (array_key_exists('postRating', $data)) {
                if (is_null($this->postRating)) {
                    if ((strcmp($data["postRating"], $this->postRating)) != 0) {
                        $postRatingUpdated = true;
                        $this->setPostRating($data['postRating']);
                        $queryFields .= "postRating = :postRating, ";
                    }
                } else {
                    $postRatingUpdated = true;
                    $this->setPostRating($data['postRating']);
                    $queryFields .= "postRating = :postRating, ";
                }
            }

            $queryFields = rtrim($queryFields, ", ");

            if (!$bookNameUpdated && !$authorUpdated && !$descriptionUpdated && !$boughtDateUpdated && !$priceUpdated && !$postTypeUpdated && !$postRatingUpdated) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("No new information to update");
                $response->send();
                exit;
            }

            $this->db->query("UPDATE post SET " . $queryFields . " WHERE id = :postId");
            $this->db->bind(':postId', $this->id);

            if ($bookNameUpdated)
                $this->db->bind(":bookName", $this->bookName);

            if ($authorUpdated)
                $this->db->bind(":author", $this->author);

            if ($descriptionUpdated)
                $this->db->bind(":description", $this->description);

            if ($boughtDateUpdated)
                $this->db->bind(":boughtDate", $this->boughtDate);

            if ($priceUpdated)
                $this->db->bind(":price", $this->price);

            if ($bookCountUpdated)
                $this->db->bind(":bookCount", $this->bookCount);

            if ($wishlistdUpdated)
                $this->db->bind(":wishlisted", $this->wishlistd);

            if ($postTypeUpdated)
                $this->db->bind(":postType", $this->postType);


            if ($postRatingUpdated)
                $this->db->bind(":postRating", $this->postRating);

            $this->db->execute();

            if ($this->db->rowCount() > 0) {

                $row = $this->getPost($this->id);

                $this->setPostFromRow($row);

                $postArray = array();
                $postArray[] = $this->returnPostAsArray();

                $returnData = array();

                $returnData["rows_returned"] = $this->db->rowCount();
                $returnData["posts"] = $postArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Post Information Updated successfully");
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function deletePost($id, $uid)
    {
        $id = intval($id);
        $uid = intval($uid);
        try {
            $this->setId($id);
            $this->setUserId($uid);

            if (!$this->postExists($this->userId, $this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the post to delete");
                $response->send();
                exit;
            }

            $this->db->query('DELETE FROM post WHERE id = :postId AND userId = :userId');
            $this->db->bind(':postId', $this->id);
            $this->db->bind(':userId', $this->userId);

            if ($this->db->execute()) {
                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Post Deleted Successfully");
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Couldn't delete the post");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getUsersPost: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }
}
