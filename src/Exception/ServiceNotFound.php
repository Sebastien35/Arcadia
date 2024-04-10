<?php
Namespace App\Exception;    
use Exception;

class ServiceNotFound extends Exception
{
    public function __construct($message = "Aucun service n'a été trouvé avec cet identifiant", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}