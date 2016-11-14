<?php

namespace CinemaHD\Utils\Silex;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ValidatorUtils
{
    /**
     * Valide une entité avec les contraintes données
     *
     * @param Application     $app                  Silex Application
     * @param array           $constraints          les contraintes qu'on veut appliquer
     *
     * @return array
     */
    public static function validateEntity(Application $app, array $constraints)
    {
        $errors = $app['validator']->validate($data, $constraints);

        if (0 < count($errors)) {
            $error_msg = [];
            foreach ($errors as $error) {
                $error_msg[] = "{$error->getPropertyPath()}: {$error->getMessage()}";
            }

            return $error_msg;
        }
    }

    public static function typeIs($field_type)
    {
        return [
            new Assert\Type([
                'type' => $field_type
            ])
        ];
    }

    public static function notNull()
    {
        return [
            new Assert\NotNull()
        ];
    }

    public static function notBlank()
    {
        return [
            new Assert\NotBlank()
        ];
    }

    public static function isEmail()
    {
        return [
            new Assert\Email([
                'strict'    => false,
                'checkMX'   => false,
                'checkHost' => false
            ])
        ];
    }

    public static function notBlankAndIsNumeric()
    {
        return [
            new Assert\Callback(
                function ($field_value, ExecutionContextInterface $context) {
                    $types      = ['integer', 'float', 'double'];
                    $field_type = gettype($field_value);

                    if (false === in_array($field_type, $types)) {
                        $context
                        ->buildViolation('This value should be a valid number.')
                        ->addViolation();
                    }
                }
            )
        ];
    }

    public static function isDate()
    {
        return [
            new Assert\Regex([
                'pattern' => '/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
                'message' => 'This value is not a valid date.'
            ])
        ];
    }

    public static function dateInFutur()
    {
        $now = new \DateTime(date('c'));

        return [
            new Assert\GreaterThan([
                'value' => $now->format('c')
            ])
        ];
    }

    public static function maxLength($value)
    {
        return [
            new Assert\Length([
                'max' => $value
            ])
        ];
    }

    public static function isOneOf($types)
    {
        return [
            new Assert\Choice([
                'choices' => $types
            ])
        ];
    }

    public static function isSomeOf($types)
    {
        return [
            new Assert\Choice([
                'choices'  => $types,
                'multiple' => true,
                'min'      => 1
            ])
        ];
    }

    public static function isLessThan($value)
    {
        return [
            new Assert\LessThan([
                'value' => $value
            ])
        ];
    }

    public static function isGreaterThan($value)
    {
        return [
            new Assert\GreaterThan([
                'value' => $value
            ])
        ];
    }
}
