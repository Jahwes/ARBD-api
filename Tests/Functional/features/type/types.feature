# language: fr

@feature/types
Fonctionnalité: GET sur /type

@GET
Scénario: GET sur /types
    Quand je fais un GET sur /types
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et    le résultat devrait être identique au JSON suivant :
    """
    [
        {
            "id": 1,
            "name": "fantastique"
        },
        {
            "id": 2,
            "name": "horreur"
        },
        {
            "id": 3,
            "name": "animation"
        },
        {
            "id": 4,
            "name": "drama"
        },
        {
            "id": 5,
            "name": "thriller"
        },
        {
            "id": 6,
            "name": "aventure"
        },
        {
            "id": 7,
            "name": "guerre"
        },
        {
            "id": 8,
            "name": "policier"
        },
        {
            "id": 9,
            "name": "musical"
        },
        {
            "id": 10,
            "name": "policier"
        },
        {
            "id": 11,
            "name": "romantique"
        }
    ]

    """
