<?php
namespace App\Exceptions;
class NotFoundmonException extends  monException
{
    public function __construct()
    {
        $message = $this->create(func_get_args());
        parent::__construct($message);
    }
}