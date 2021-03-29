<?php


namespace App\Repository;


class RepositoryException extends \Exception
{
    public static function generalIssueError(string $message)
    {
        return new self($message);
    }

    public static function validUuidRequired(string $class, string $method)
    {
        return new self("Call to method $method in class $class required a valid uuid.");
    }

    public static function methodDoesNotExistInClass(string $class, string $method)
    {
        return new self("Call to nonexistent method $method in class $class");
    }
}