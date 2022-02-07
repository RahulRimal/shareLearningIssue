<?php

use function PHPSTORM_META\type;

require('User.php');

class SessionException extends Exception
{
}

class Session
{

    private $db;

    private $id;
    private $userId;
    private $accessToken;
    private $accessTokenExpiryTime;
    private $refreshToken;
    private $refreshTokenExpiryTime;


    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (PDOException $ex) {
            error_log("Session Const: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Couldn't connect to database");
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

    public function getAccssToken()
    {
        return $this->accessToken;
    }

    public function getAccessTokenExpiry()
    {
        return $this->accessTokenExpiryTime;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getRefreshTokenExpiry()
    {
        return $this->refreshTokenExpiryTime;
    }


    public function setId($id)
    {
        if (is_null($id))
            throw new SessionException('Session ID can\'t be null');
        elseif (!is_numeric($id))
            throw new SessionException('Session ID must be numeric');
        else
            $this->id = $id;
    }

    public function setUserId($uid)
    {
        if (is_null($uid))
            throw new SessionException('User ID can\'t be null');
        elseif (!is_numeric($uid))
            throw new SessionException('User ID  must be numeric');
        else
            $this->userId = $uid;
    }

    public function hasExpired($tokenExpiryTime)
    {
        $date = new DateTime();
        if (date("Y-m-d H:i:s", $date->getTimestamp()) > $tokenExpiryTime)
            return true;
        return false;
    }

    public function setAccessToken($token)
    {
        if (is_null($token))
            throw new SessionException('Access Token can\'t be null');
        elseif (empty($token))
            throw new SessionException('Access Token can\'t be empty');
        else
            $this->accessToken = $token;
    }

    public function setAccessTokenExpiry($tokenTime)
    {

        if (is_null($tokenTime))
            throw new SessionException('Access token expiry time can\'t be null');
        elseif (empty($tokenTime))
            throw new SessionException('Access token expiry time can\'t be empty');

        else {

            // if ($this->hasExpired($tokenTime))
            //     // throw new SessionException('Access token expiry time must be future');
            //     $this->updateSession($this->refreshToken);
            //     else
            $this->accessTokenExpiryTime = $tokenTime;
        }
    }


    public function setRefreshToken($token)
    {
        if (is_null($token))
            throw new SessionException('Refresh Token can\'t be null');
        elseif (empty($token))
            throw new SessionException('Refresh Token can\'t be empty');
        else
            $this->refreshToken = $token;
    }

    public function setRefreshTokenExpiry($tokenTime)
    {
        if (is_null($tokenTime))
            throw new SessionException('Refresh token expiry time can\'t be null');
        elseif (empty($tokenTime))
            throw new SessionException('Refresh token expiry time can\'t be empty');

        else {
            // if ($this->hasExpired($tokenTime))
            //     throw new SessionException('Access token expiry time must be future');
            // else
            $this->refreshTokenExpiryTime = $tokenTime;
        }
    }


    public function setSessionFromRow($row)
    {
        $this->setId($row->id);
        $this->setUserId($row->userId);
        $this->setRefreshToken($row->refreshToken);
        $this->setAccessToken($row->accessToken);
        $this->setAccessTokenExpiry($row->accessTokenExpiry);
        $this->setRefreshTokenExpiry($row->refreshTokenExpiry);
    }

    public function returnSessionAsArray()
    {
        $sessionData = array();

        $sessionData['id'] = $this->id;
        $sessionData['userId'] = $this->userId;
        $sessionData['accessToken'] = $this->accessToken;
        $sessionData['accessTokenExpiry'] = $this->accessTokenExpiryTime;
        $sessionData['refreshToken'] = $this->refreshToken;
        $sessionData['refreshTokenExpiry'] = $this->refreshTokenExpiryTime;

        return $sessionData;
    }

    public function getDateFromSeconds($timeInSeconds)
    {
        $date = new DateTime();
        $date->add(new DateInterval('PT' . $timeInSeconds . 'S'));
        return date("Y-m-d H:i:s", $date->getTimestamp());
    }

    public function sessionExists($sessId)
    {
        try {
            $this->db->query('SELECT COUNT(*) AS totalCount FROM sessions WHERE id = :sessionId');
            $this->db->bind(':sessionId', $sessId);

            $this->db->execute();

            $row = $this->db->single();

            if ($row->totalCount > 0)
                return true;
            else
                return false;
        } catch (PDOException $ex) {
            error_log("Fun SessionExist : " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function setSessionFromRefreshToken($refreshToken)
    {

        try {
            $this->db->query('SELECT * FROM sessions WHERE refreshToken = :refToken');
            $this->db->bind(':refToken', $this->refreshToken);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->setSessionFromRow($row);
            } else {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the session");
                $response->send();
                exit;
            }
        } catch (PDOException $ex) {
            error_log('fun CreateSessionFromRefresh: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function createSession($user)
    {

        try {
            $this->setAccessToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
            $this->setAccessTokenExpiry($this->getDateFromSeconds(1200));
            $this->setRefreshToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
            $this->setRefreshTokenExpiry($this->getDateFromSeconds(1209600));


            // $this->db->query("INSERT INTO sessions (id, userid, accesstoken, accesstokenexpiry, refreshtoken, refreshtokenexpiry) VALUES (null, :userId, :accessToken, DATE_ADD(NOW(), INTERVAL :accessTokenExpiry SECOND), :refreshToken, DATE_ADD(NOW(), INTERVAL :refreshTokenExpiry SECOND))");

            $this->db->query("INSERT INTO sessions (id, userId, accessToken, accessTokenExpiry, refreshToken, refreshTokenExpiry) VALUES (null, :userId, :accessToken, DATE_ADD(NOW(), INTERVAL :accessTokenExpiry SECOND), :refreshToken, DATE_ADD(NOW(), INTERVAL :refreshTokenExpiry SECOND))");

            $this->db->bind(":userId", $user->getId());
            $this->db->bind(":accessToken", $this->accessToken);
            // $this->db->bind(":accessTokenExpiry", $this->accessTokenExpiryTime);
            $this->db->bind(":accessTokenExpiry", 1200);
            $this->db->bind(":refreshToken", $this->refreshToken);
            // $this->db->bind(":refreshTokenExpiry", $this->refreshTokenExpiryTime);
            $this->db->bind(":refreshTokenExpiry", 1209600);


            $this->db->execute();

            if ($this->db->rowCount() > 0) {
                $sessionId = $this->db->lastInsertId();

                $this->db->query('SELECT * FROM sessions WHERE id = :sessionId');

                $this->db->bind(":sessionId", $sessionId);

                $this->db->execute();

                if ($this->db->rowCount() > 0) {

                    $row = $this->db->single();

                    $this->setSessionFromRow($row);

                    $sessionArray =  array();

                    $sessionArray[] = $this->returnSessionAsArray();

                    $returnData = array();
                    $returnData['rows_returned'] = $this->db->rowCount();
                    $returnData["sessions"] = $sessionArray;

                    $response = new Response();
                    $response->setHttpStatusCode(201);
                    $response->setSuccess(true);
                    $response->addMessage("Session Created Successfully");
                    $response->setData($returnData);
                    return $response;
                    // $response->send();
                    // exit;
                } else {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't receive information after creating session, please try again");
                    $response->send();
                    exit;
                }
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (SessionException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun UpdateSession: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getSessionInfo($accessToken)
    {
        try {
            $this->setAccessToken($accessToken);

            $this->db->query('SELECT * FROM sessions WHERE accessToken = :accessToken');
            $this->db->bind(':accessToken', $accessToken);

            $row = $this->db->single();

            if ($this->db->rowCount() == 0) {

                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage('Error getting session information, please check access token');
                $response->send();
                exit;
            }

            $this->setSessionFromRow($row);

            if ($this->hasExpired($this->accessTokenExpiryTime)) {
                if ($this->hasExpired($this->refreshTokenExpiryTime)) {
                    $response = new Response();
                    $response->setHttpStatusCode(400);
                    $response->setSuccess(false);
                    $response->addMessage('Expired token, please log in again');
                    $response->send();
                    exit;
                }
                // $this->updateSession($this->refreshToken);
                $this->setAccessToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
                $this->setAccessTokenExpiry($this->getDateFromSeconds(1200));
                $this->setRefreshToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
                $this->setRefreshTokenExpiry($this->getDateFromSeconds(1209600));

                $this->db->query('UPDATE sessions SET accessToken = :accessToken, accessTokenExpiry = :accessTokenExpiry, refreshToken = :refreshToken, refreshTokenExpiry = :refreshTokenExpiry WHERE id = :sessionId and userId = :userId');

                $this->db->bind(':sessionId', $this->id);
                $this->db->bind(':userId', $this->userId);
                $this->db->bind(':accessToken', $this->accessToken);
                $this->db->bind(':accessTokenExpiry', $this->accessTokenExpiryTime);
                $this->db->bind(':refreshToken', $this->refreshToken);
                $this->db->bind(':refreshTokenExpiry', $this->refreshTokenExpiryTime);

                $this->db->execute();

                if ($this->db->rowCount() == 0) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn\'t get session information, please try again");
                    $response->send();
                    exit;
                }

                return $this;
            }
            return $this;
        } catch (SessionException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun UpdateSession: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function deleteSession($sessId)
    {
        $sessId = intval($sessId);
        $this->setId($sessId);
        try {

            if ($this->sessionExists($this->id)) {

                $this->db->query('DELETE FROM sessions where id = :sessionId');
                $this->db->bind(":sessionId", $this->id);

                if ($this->db->execute()) {
                    $response = new Response();
                    $response->setHttpStatusCode(200);
                    $response->setSuccess(true);
                    $response->addMessage("Session Deleted Successfully");
                    return $response;
                    // $response->send();
                    // exit;
                } else {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't delete session");
                    $response->send();
                    exit;
                }
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("No session found to delete");
                $response->send();
                exit;
            }
        } catch (PDOException $ex) {
            error_log('fun login: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function updateSession($refreshToken)
    {
        try {
            $this->setRefreshToken($refreshToken);

            $this->setSessionFromRefreshToken($refreshToken);


            if ($this->hasExpired($this->refreshTokenExpiryTime)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Expired token, please log in again");
                $response->send();
                exit;
            }

            if ($this->sessionExists($this->id)) {
                $this->setAccessToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
                $this->setAccessTokenExpiry($this->getDateFromSeconds(1200));
                $this->setRefreshToken(base64_encode(bin2hex(openssl_random_pseudo_bytes(24) . time())));
                $this->setRefreshTokenExpiry($this->getDateFromSeconds(1209600));

                $this->db->query('UPDATE sessions set accessToken = :accessToken, accessTokenExpiry = :accessTokenExpiry, refreshToken = :refreshToken, refreshTokenExpiry = :refreshTokenExpiry WHERE id = :sessionId and userId = :userId');

                $this->db->bind(':sessionId', $this->id);
                $this->db->bind(':userId', $this->userId);
                $this->db->bind(':accessToken', $this->accessToken);
                $this->db->bind(':accessTokenExpiry', $this->accessTokenExpiryTime);
                $this->db->bind(':refreshToken', $this->refreshToken);
                $this->db->bind(':refreshTokenExpiry', $this->refreshTokenExpiryTime);

                $this->db->execute();

                if ($this->db->rowCount() > 0) {

                    $sessionArray = array();
                    $sessionArray[] = $this->returnSessionAsArray();

                    $returnData = array();
                    $returnData['rows_returned'] = $this->db->rowCount();
                    $returnData['sessions'] = $sessionArray;

                    $response = new Response();
                    $response->setHttpStatusCode(200);
                    $response->setSuccess(true);
                    $response->addMessage("User session updated successfully");
                    $response->setData($returnData);
                    return $response;
                    // $response->send();
                    // exit;
                } else {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't update session, please try again");
                    $response->send();
                    exit;
                }
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("No session found to update");
                $response->send();
                exit;
            }
        } catch (SessionException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun UpdateSession: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    // public function loginUser($email = null, $username = null,  $password)
    public function loginUser($email, $username,  $password)
    {
        $user = new User("tempUser", "tempPass", null, "tempFirst", "tempLast", null, null, null);
        try {
            $queryFields = '';
            if (!is_null($username)) {
                $user->setUsername($username);
                $queryFields .= "username = :username AND ";
            } elseif (!is_null($email)) {
                $user->setEmail($email);
                $queryFields .= 'email = :email AND ';
            } else {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Username or email required");
                $response->send();
                exit;
            }

            $user->setPassword($password);
            $queryFields .= 'password = :password';

            $this->db->query("SELECT * FROM user where " . $queryFields);

            !is_null($email) ? $this->db->bind(':email', $user->getEmail()) : $this->db->bind(":username", $user->getUsername());
            $this->db->bind(':password', $user->getPassword());

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {
                $user->setUserFromRow($row);
                return $this->createSession($user);
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (SessionException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (UserException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log('fun login: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }

        //php function to get current time
    }
}
