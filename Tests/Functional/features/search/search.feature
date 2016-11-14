# language: fr

@feature/search
Fonctionnalité: search des trucs

@GET
Scénario: search tous les movies
    Quand       je fais un GET sur /movies/search
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "search_movies.json"

@GET
Scénario: search les movies avec l'id 11
    Quand       je fais un GET sur /movies/search?q=+id:11
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "total": 1,
        "max_score": 1,
        "hits": [
            {
                "id": 11,
                "title": "Le Donjon de la mort 4",
                "duration": 120
            }
        ]
    }
    """

@GET
Scénario: search les people avec l'id 11
    Quand       je fais un GET sur /peoples/search?q=+id:11
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "total": 1,
        "max_score": 1,
        "hits": [
            {
                "id": 11,
                "lastname": "PARKINSON",
                "firstname": "Art",
                "date_of_birth": "2001-10-19",
                "nationality": "irlandaise"
            }
        ]
    }
    """

@GET
Scénario: search les spectator célibataires
    Quand       je fais un GET sur /spectators/search?q=+title:Mademoiselle
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "total": 3,
        "max_score": 3.3513753,
        "hits": [
            {
                "id": 7,
                "lastname": "AUCLAIR",
                "firstname": "Diane",
                "age": 25,
                "title": "Mademoiselle"
            },
            {
                "id": 9,
                "lastname": "CLOUTIER",
                "firstname": "Minette",
                "age": 25,
                "title": "Mademoiselle"
            },
            {
                "id": 5,
                "lastname": "MELVILLE",
                "firstname": "Lamy",
                "age": 25,
                "title": "Mademoiselle"
            }
        ]
    }
    """
