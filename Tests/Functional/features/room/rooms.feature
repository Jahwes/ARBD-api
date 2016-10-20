# language: fr

@feature/get_rooms
Fonctionnalité: Get des rooms

@GET
Scénario: Get tous les rooms
    Quand       je fais un GET sur /rooms
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    [
        {
            "id": 1,
            "nb_places": 50
        },
        {
            "id": 2,
            "nb_places": 35
        },
        {
            "id": 3,
            "nb_places": 78
        },
        {
            "id": 4,
            "nb_places": 90
        },
        {
            "id": 5,
            "nb_places": 25
        },
        {
            "id": 6,
            "nb_places": 129
        },
        {
            "id": 7,
            "nb_places": 157
        }
    ]
    """

@GET
Scénario: Get une room par son ID
    Quand       je fais un GET sur /rooms/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "nb_places": 50
    }
    """
