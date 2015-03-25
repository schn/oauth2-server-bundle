<?php

namespace OAuth2\ServerBundle\Exception;

/**
 * Oauth2Exception 
 */
class Oauth2Exception extends \Exception
{
    public static function cantFindUserWithId($id)
    {
        return new static("User with id: " . $id . " not found");
    }
} 