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
Scénario: search les movies avec l'id 6
    Quand       je fais un GET sur /movies/search?q=+id:6
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "total": 1,
        "max_score": 1,
        "hits": [
            {
                "id": 6,
                "title": "Fatal Punishment",
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
