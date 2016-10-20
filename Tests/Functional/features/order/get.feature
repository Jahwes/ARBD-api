# language: fr

@feature/get_orders
Fonctionnalité: Get des orders

@GET
Scénario: Get tous les orders du monde
    Quand       je fais un GET sur /orders
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_orders.json"

@GET
Scénario: Get un order par son ID
    Quand       je fais un GET sur /orders/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "created_at": "2016-10-18T00:00:00+02:00",
        "user": {
            "id": 1,
            "lastname": "HEART",
            "firstname": "Kingston",
            "date_of_birth": {
                "date": "1994-02-15 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "Europe/Paris"
            },
            "title": "Monsieur",
            "email": "heart_k@etna.io"
        }
    }
    """

@GET
Scénario: Get les tickets d'un order
    Quand       je fais un GET sur /orders/1/tickets
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_tickets.json"
