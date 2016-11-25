<?php

namespace Tests;

use Behat\Behat\Tester\Exception\PendingException;

class DoctrineContext extends BaseContext
{
    public function __construct()
    {
    }

    /**
     * @BeforeSuite
     */
    public static function dump()
    {
        echo "dropping database";
        passthru("vendor/doctrine/orm/bin/doctrine orm:schema-tool:drop --force --full-database");
        passthru("./bin/dump ./Tests/Data/test*.sql");
    }

    /**
     * @BeforeScenario
     */
    public function beginTransaction()
    {
        self::$silex_app["db"]->beginTransaction();
        self::$silex_app["orm.em"]->clear();
    }

    /**
     * @AfterScenario
     */
    public function rollback()
    {
        self::$silex_app["db"]->rollback();
    }
}
