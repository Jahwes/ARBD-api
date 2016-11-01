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

@GET @wip
Scénario: Get les movies d'un people
    Quand       je fais un GET sur /peoples/1/movies
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_movies.json"
