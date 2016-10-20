# language: fr

@feature/get_spectators
Fonctionnalité: Get des spectators

@GET
Scénario: Get tous les spectators du monde
    Quand       je fais un GET sur /spectators
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_spectators.json"

@GET
Scénario: Get un spectator par son ID
    Quand       je fais un GET sur /spectators/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "lastname": "HEART",
        "firstname": "Kingston",
        "date_of_birth": {
            "date": "1994-02-15 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "Europe\/Paris"
        },
        "title": "Monsieur"
    }
    """
