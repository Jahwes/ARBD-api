# language: fr

@feature/get_showings
Fonctionnalité: Get des showings

@GET
Scénario: Get tous les showings du monde
    Quand       je fais un GET sur /showings
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_showings.json"

@GET
Scénario: Get un showing par son ID
    Quand       je fais un GET sur /showings/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
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
    }
    """

@GET
Scénario: Get les tickets d'un showing
    Quand       je fais un GET sur /showings/1/tickets
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_tickets_from_showing.json"
