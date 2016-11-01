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
Scénario: Get un ticket par son ID
    Quand       je fais un GET sur /tickets/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "price": {
            "id": 1,
            "type": "Plein tarif",
            "value": 9.4,
            "current": false
        },
        "showing": {
            "id": 1,
            "date": "2016-11-18 10:00:00",
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
            "age": 25,
            "title": "Monsieur"
        },
        "order": {
            "id": 1,
            "created_at": "2016-10-18",
            "user": {
                "id": 1,
                "lastname": "HEART",
                "firstname": "Kingston",
                "date_of_birth": "1994-02-15",
                "title": "Monsieur",
                "email": "heart_k@etna.io"
            }
        }
    }
    """
