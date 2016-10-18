<?php

namespace Tests;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

abstract class BaseContext implements Context
{
    static protected $silex_app;
    static protected $contexts;
    protected $requests_path;
    protected $results_path;

    /** @BeforeScenario */
    public function setUp(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $contexts    = array_combine(
            $environment->getContextClasses(),
            $environment->getContexts()
        );

        self::$contexts  = $contexts;
        self::$silex_app = $contexts['Tests\MainContext']->getSilexApp();
    }

    /**
     * @param string $context
     */
    protected function getContext($context)
    {
        if (false === isset(self::$contexts[$context])) {
            throw new \Exception("Context {$context} not found");
        }

        return self::$contexts[$context];
    }

    /**
     * @param string $name
     */
    protected function getParameter($name)
    {
        return self::$contexts['Tests\MainContext']->getParameter($name);
    }

    protected static function setParameter($name, $value)
    {
        self::$contexts['Tests\MainContext']->setParameter($name, $value);
    }

    /**
     * @BeforeScenario
     */
    public function setUpScenarioDirectories(BeforeScenarioScope $scope)
    {
        $this->results_path  = realpath(dirname($scope->getFeature()->getFile())) . '/results/';
        $this->requests_path = realpath(dirname($scope->getFeature()->getFile())) . '/requests/';
    }

    protected function handleErrors($data, $errors)
    {
        if ($nb_err = count($errors)) {
            echo json_encode($data, JSON_PRETTY_PRINT);
            throw new \Exception("{$nb_err} errors :\n" . implode("\n", $errors));
        }
    }

    /**
     * Valide l'égalité de 2 valeurs ($expected_value & $found_value)
     *
     * Le test prendra en considération les tableaux associatifs qui n'auront pas la nécessisité
     * d'être dans le même ordre, mais devront contenir exactement les mêmes clefs et les mêmes valeurs.
     *
     * Il y a aussi quelques exceptions possibles :
     *  - "key" => "#Array#" : va juste vérifier que la valeur de $expected_value["key"] est bien un tableau
     *  - "key" => #regex# : va vérifier que la valeur de $expected_value["key"] matche la regexp "regexp"
     * @param string $prefix
     */
    protected function check($expected_value, $found_value, $prefix, &$errors)
    {
        if (true === is_string($expected_value) && "#Array#" === $expected_value) {
            if (false === is_array($found_value)) {
                $errors[] = sprintf("%-35s: not an array", $prefix);
            }

            return;
        }

        $is_string   = (true === is_string($expected_value));
        $sharp_start = ($is_string && "#" === substr($expected_value, 0, 1));
        $sharp_end   = ($is_string && "#" === substr($expected_value, -1, 1));
        if (true === $is_string && true === $sharp_start && true === $sharp_end) {
            if (1 !== preg_match($expected_value, $found_value)) {
                $errors[] = sprintf(
                    "%-35s: regex error : '%s' does not match '%s'",
                    $prefix,
                    $found_value,
                    $expected_value
                );
            }

            return;
        }

        $expected_type = gettype($expected_value);
        $found_type    = gettype($found_value);
        if ($expected_type !== $found_type) {
            $errors[] = sprintf("%-35s: type error : expected '%s'; got '%s'", $prefix, $expected_type, $found_type);
            return;
        }

        if (true === is_array($expected_value)) {
            $expected_count = count($expected_value);
            $found_count    = count($found_value);
            if ($expected_count !== $found_count) {
                $errors[] = sprintf(
                    "%-35s: array length error : expected '%d'; got '%d'",
                    $prefix,
                    $expected_count,
                    $found_count
                );
                return;
            }

            for ($i = 0; $i < $expected_count; $i++) {
                $this->check($expected_value[$i], $found_value[$i], "{$prefix}[{$i}]", $errors);
            }
            return;
        }

        if (true === is_object($expected_value)) {
            $expected_keys = array_keys((array) $expected_value);
            $found_keys    = array_keys((array) $found_value);

            foreach (array_diff($expected_keys, $found_keys) as $key) {
                $errors[] = sprintf("%-35s: missing key", "{$prefix}->{$key}", $key);
            }
            foreach (array_diff($found_keys, $expected_keys) as $key) {
                $errors[] = sprintf("%-35s: unexpected key", "{$prefix}->{$key}", $key);
            }

            foreach (array_intersect($expected_keys, $found_keys) as $key) {
                $this->check($expected_value->$key, $found_value->$key, "{$prefix}->{$key}", $errors);
            }

            return;
        }

        if ($expected_value !== $found_value) {
            $errors[] = sprintf(
                "%-35s: value error : expected %s; got %s",
                $prefix,
                var_export($expected_value, true),
                var_export($found_value, true)
            );
        }
    }
}
