<?php

namespace CinemaHD\Utils\Silex;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app["findOneOr404"] = $app->protect(
    function ($entity_name, $field_name = "") use ($app) {
        return function ($field_value) use ($app, $entity_name, $field_name) {
            $class_name = "\\{$app['orm.em.options']['mappings'][0]['namespace']}\\". $entity_name;

            if (!class_exists($class_name)) {
                throw new NotFoundHttpException(sprintf('%s does not exist', $class_name));
            }

            $object = $app['orm.em']
                ->getRepository($class_name)
                ->{"findOneBy{$field_name}"}($field_value);

            if (null === $object) {
                throw new NotFoundHttpException(sprintf("{$entity_name} %s does not exist", $field_value));
            }

            return $object;
        };
    }
);
