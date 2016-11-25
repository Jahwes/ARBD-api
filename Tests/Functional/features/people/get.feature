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
        "date_of_birth": "1980-07-06",
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
    5
    """

@GET
Scénario: Get le top des acteurs
    Quand       je fais un GET sur /peoples/top?type=acteur
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "GRANT Norman": 5,
        "PAYNE Frankie": 2,
        "WELCH Kayla": 2,
        "HOPKINS Dean": 2,
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
        "GRANT Norman": 5,
        "BRADY Rhonda": 5,
        "PAYNE Frankie": 2,
        "WELCH Kayla": 2,
        "HOPKINS Dean": 2,
        "COOK Lynn": 2,
        "FLOYD Merle": 0,
        "LARSON Marcella": 0,
        "COLLIER William": 0,
        "RODRIGUEZ Orlando": 0,
        "BREWER Dianne": 0,
        "LITTLE Priscilla": 0
    }
    """
