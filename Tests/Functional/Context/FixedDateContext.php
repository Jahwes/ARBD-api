<?php

namespace Tests;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

class FixedDateContext extends BaseContext
{
    private static $_date;
    private static $_custom_date;

    public function __construct($date)
    {
        // Constructeur pour avoir des paramètres,
        // sauf qu'on récupère les paramètres en BeforeSuite
        // donc on ne fait rien ici
    }

    /**
     * @BeforeSuite
     */
    public static function setCustomDateParams(BeforeSuiteScope $scope)
    {
        $environment        = $scope->getEnvironment();
        $contexts_params    = $environment->getContextClassesWithArguments();
        self::$_date        = $contexts_params['Tests\FixedDateContext']["date"];
        self::$_custom_date = self::$_date;
    }

    /**
     * @BeforeSuite
     */
    public static function setCustomDate()
    {
        $_custom_date = self::$_custom_date;
        uopz_set_return("time", function () use ($_custom_date) {
            return strtotime($_custom_date);
        }, true);

        uopz_set_return("date", function ($format, $timestamp = null) {
            $timestamp = $timestamp ?: time();
            return date($format, $timestamp);
        }, true);

        uopz_set_return("strtotime", function ($time, $now = null) {
            $now = $now ?: time();
            return strtotime($time, $now);
        }, true);
    }

    /**
     * @AfterSuite
     */
    public static function resetToNormalDate()
    {
        uopz_unset_return("strtotime");
        uopz_unset_return("date");
        uopz_unset_return("time");
    }

    /**
     * @Given /^que la date est "([^"]*)"$/
     */
    public function queLaDateEst($new_date)
    {
        self::$_custom_date = $new_date;

        self::resetToNormalDate();
        self::setCustomDate();
    }

    /**
     * @Given /^je rollback la date$/
     */
    public function jeRollbackLaDate()
    {
        self::$_custom_date = self::$_date;

        self::resetToNormalDate();
        self::setCustomDate();
    }
}
