<?php

use Cinema\Database;

require_once 'lib/autoload.php';

$faker       = Faker\Factory::create();
$blockbuster = new Database();
$env         = getenv("APPLICATION_ENV");

if (empty($argv[1]) == true) {
    $timer = 1000000;
} else {
    $timer = $argv[1]*1000;
}


while (true) {
    usleep($timer);
    $firstAge        = $blockbuster->getAge();
    $nbTickets       = $blockbuster->getNbTickets();
    $firstCivility   = $blockbuster->getGender(false, $firstAge);
    $firstNom        = $faker->firstName;
    $firstPrenom     = $faker->firstName;
    $firstEmail      = $firstNom . '.' . $firstPrenom . '@' . $blockbuster->getSuffixEmail();
    $firstPersonType = $blockbuster->getPersonType($firstAge);

    $result['Acheteur']['Civilite'] = $firstCivility;
    $result['Acheteur']['Nom']      = $firstNom;
    $result['Acheteur']['Prenom']   = $firstPrenom;
    $result['Acheteur']['Age']      = $firstAge;
    $result['Acheteur']['Email']    = strtolower($firstEmail);
    $result['Film']['Titre']        = $blockbuster->getMovie();
    $result['Film']['Jour']         = $blockbuster->getBuyDate();
    $result['Film']['Horaire']      = $blockbuster->getHour();
    $result['Film']['3D']           = $blockbuster->isThreeDimension();
    for ($i = 0; $i < $nbTickets; $i++) {
        if ($i == 0) {
            $result['Ticket'][$i]['Spectateur']['Civilite'] = $firstCivility;
            $result['Ticket'][$i]['Spectateur']['Nom']      = $firstNom;
            $result['Ticket'][$i]['Spectateur']['Prenom']   = $firstPrenom;
            $result['Ticket'][$i]['Spectateur']['Age']      = $firstAge;
            $result['Ticket'][$i]['Tarif']                  = $firstPersonType;
        } else {
            $otherAge        = $blockbuster->getAge();
            $otherCivility   = $blockbuster->getGender(false, $otherAge);
            $otherNom        = $faker->firstName;
            $otherPrenom     = $faker->firstName;
            $otherPersonType = $blockbuster->getPersonType($otherAge);

            $result['Ticket'][$i]['Spectateur']['Civilite'] = $otherCivility;
            $result['Ticket'][$i]['Spectateur']['Nom']      = $otherNom;
            $result['Ticket'][$i]['Spectateur']['Prenom']   = $otherPrenom;
            $result['Ticket'][$i]['Spectateur']['Age']      = $otherAge;
            $result['Ticket'][$i]['Tarif']                  = $otherPersonType;
        }
    }

    if ("testing" === $env)
    {
        echo(json_encode($result, JSON_PRETTY_PRINT));
        echo PHP_EOL;
        continue;
    }

    echo $env;
}
