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
            "type": "Plein tarif",
            "value": 9.4,
            "current": false
        },
        {
            "id": 2,
            "type": "Tarif reduit",
            "value": 7.4,
            "current": false
        },
        {
            "id": 3,
            "type": "Senior",
            "value": 6.8,
            "current": false
        },
        {
            "id": 4,
            "type": "Tarif etudiant",
            "value": 6.8,
            "current": false
        },
        {
            "id": 5,
            "type": "Plein tarif",
            "value": 10,
            "current": true
        },
        {
            "id": 6,
            "type": "Tarif reduit",
            "value": 8,
            "current": true
        },
        {
            "id": 7,
            "type": "Senior",
            "value": 7,
            "current": true
        },
        {
            "id": 8,
            "type": "Tarif etudiant",
            "value": 7,
            "current": true
        }
    ]
    """

@GET
Scénario: GET des prix en cours
    Quand je fais un GET sur /prices/current
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et    le résultat devrait être identique au JSON suivant :
    """
    [
        {
            "id": 5,
            "type": "Plein tarif",
            "value": 10,
            "current": true
        },
        {
            "id": 6,
            "type": "Tarif reduit",
            "value": 8,
            "current": true
        },
        {
            "id": 7,
            "type": "Senior",
            "value": 7,
            "current": true
        },
        {
            "id": 8,
            "type": "Tarif etudiant",
            "value": 7,
            "current": true
        }
    ]
    """
