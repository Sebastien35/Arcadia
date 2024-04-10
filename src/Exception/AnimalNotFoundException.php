<?php
Namespace App\Exception;    
use Exception;

class AnimalNotFoundException extends Exception
{
    public function __construct($message = "Aucun animal n'a été trouvé avec cet identifiant", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}