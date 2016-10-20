# language: fr

@feature/prices
Fonctionnalité: GET sur /prices

@GET
Scénario: GET sur /prices
    Quand je fais un GET sur /prices
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et    le résultat devrait être identique au JSON suivant :
    """
    [
        {
             "id": 1,
             "type": "plein",
             "value": 9.4
        },
        {
             "id": 2,
             "type": "réduit",
             "value": 7.4
        },
        {
             "id": 3,
             "type": "sénior",
             "value": 6.8
        },
        {
             "id": 4,
             "type": "étudiant",
             "value": 6.8
        }
    ]

    """
