# language: fr

@feature/get_peoples
Fonctionnalité: Get des peoples

@GET
Scénario: Get tous les people du monde
    Quand       je fais un GET sur /peoples
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_peoples.json"

@GET
Scénario: Get un people par son ID
    Quand       je fais un GET sur /peoples/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "lastname": "GREEN",
        "firstname": "Eva",
        "date_of_birth": {
            "date": "1980-07-06 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe\/Paris"
        },
        "nationality": "française"
    }
    """

@GET
Scénario: Get les movies d'un people
    Quand       je fais un GET sur /peoples/1/movies
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_movies.json"

@GET
Scénario: Get le score d'un people
    Quand       je fais un GET sur /peoples/1/score
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    4
    """

@GET
Scénario: Get le top des acteurs
    Quand       je fais un GET sur /peoples/top?type=acteur
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "BUTTERFIELD Asa": 4,
        "JACKSON Samuel": 2,
        "WAHLBERG Marc": 2,
        "O'BRIAN Dylan": 1,
        "PARKINSON Art": 0,
        "STATHAM Jason": 0,
        "LEE JONES Tommy": 0,
        "HUNNAM Charlie": 0,
        "GRANT Norman": 0,
        "PAYNE Frankie": 0,
        "HOPKINS Dean": 0,
        "FLOYD Merle": 0,
        "COLLIER William": 0,
        "RODRIGUEZ Orlando": 0
    }
    """

@GET
Scénario: Get le top mixte
    Quand       je fais un GET sur /peoples/top?type=both
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "BUTTERFIELD Asa": 4,
        "GREEN Eva": 4,
        "JACKSON Samuel": 2,
        "WAHLBERG Marc": 2,
        "HUDSON Kate": 2,
        "O'BRIAN Dylan": 1,
        "WELCH Kayla": 0,
        "RODRIGUEZ Orlando": 0,
        "LITTLE Priscilla": 0,
        "COLLIER William": 0,
        "LARSON Marcella": 0,
        "FLOYD Merle": 0,
        "COOK Lynn": 0,
        "HOPKINS Dean": 0,
        "KIKUCHI Rinko": 0,
        "PAYNE Frankie": 0,
        "BRADY Rhonda": 0,
        "GRANT Norman": 0,
        "HUNNAM Charlie": 0,
        "LEE JONES Tommy": 0,
        "ALBA Jessica": 0,
        "STATHAM Jason": 0,
        "PARKINSON Art": 0,
        "THERON Charlize": 0,
        "BREWER Dianne": 0
    }
    """
