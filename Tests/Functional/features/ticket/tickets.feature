# language: fr

@feature/get_tickets
Fonctionnalité: Get des tickets

@GET
Scénario: Get tous les tickets du monde
    Quand       je fais un GET sur /tickets
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_tickets.json"

@GET
Scénario: Get un user par son ID
    Quand       je fais un GET sur /tickets/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "price": {
            "id": 1,
            "type": "plein",
            "value": 9.4
        },
        "showing": {
            "id": 1,
            "date": {
                "date": "2016-11-18 10:00:00.000000",
                "timezone_type": 3,
                "timezone": "Europe\/Paris"
            },
            "is_3D": true,
            "room": {
                "id": 1,
                "nb_places": 50
            },
            "movie": {
                "id": 1,
                "title": "Miss Peregrine et les enfants particuliers",
                "duration": 127
            }
        },
        "spectator": {
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
    }
    """
