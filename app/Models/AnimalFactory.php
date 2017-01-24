<?php
namespace SimpleZoo\Models;

class AnimalFactory
{
    public static function factory($animal)
    {
        switch (mb_strtolower($animal)) {
            case 'elephant':
                $obj = new Elephant();
                break;
            case 'giraffe':
                $obj = new Giraffe();
                break;
            case 'monkey':
                $obj = new Monkey();
                break;
            default:
                throw new \Exception("Sorry, '" . $animal . "' is not a valid animal in this zoo.", 1000);
        }

        return $obj;
    }
}
