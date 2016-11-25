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
            "current": true
        },
        {
            "id": 2,
            "type": "Tarif reduit",
            "value": 7.4,
            "current": true
        },
        {
            "id": 3,
            "type": "Senior",
            "value": 6.8,
            "current": true
        },
        {
            "id": 4,
            "type": "Tarif etudiant",
            "value": 6.8,
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
            "id": 1,
            "type": "Plein tarif",
            "value": 9.4,
            "current": true
        },
        {
            "id": 2,
            "type": "Tarif reduit",
            "value": 7.4,
            "current": true
        },
        {
            "id": 3,
            "type": "Senior",
            "value": 6.8,
            "current": true
        },
        {
            "id": 4,
            "type": "Tarif etudiant",
            "value": 6.8,
            "current": true
        }
    ]
    """
