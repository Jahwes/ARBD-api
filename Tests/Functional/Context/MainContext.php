<?php

namespace Tests;

use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

putenv("APPLICATION_ENV=" . (getenv("APPLICATION_ENV") ?: "testing"));

class MainContext implements Context
{
    static private $silex_app;
    static private $parameters = [];

    /** @BeforeSuite */
    public static function setUpSilexApp()
    {
        $api_path = getcwd() . "/public/index.php";
        self::$silex_app = include_once $api_path;
    }

    /** @BeforeSuite */
    public static function setUpParams(BeforeSuiteScope $scope)
    {
        $environment = $scope->getEnvironment();
        $contexts    = $environment->getContextClassesWithArguments();
        foreach ($contexts as $context => $params) {
            self::$parameters = array_merge(self::$parameters, $params);
        }
    }

    public static function getSilexApp()
    {
        return self::$silex_app;
    }

    public function getParameter($name)
    {
        if (false === isset(self::$parameters[$name])) {
            throw new \Exception("Parameter {$name} not set");
        }

        return self::$parameters[$name];
    }

    public function setParameter($name, $value)
    {
        self::$parameters[$name] = $value;
    }
}
