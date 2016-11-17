# language: fr

@feature/prices
Fonctionnalité: POST sur /prices

@POST
Scénario: Création d'un nouveau prix pour le tarif étudiant
    Quand       je fais un POST sur /prices avec le corps contenu dans "add_price_student.json"
    Alors       le status HTTP devrait être 201
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id":"#^\\d+$#",
        "type": "Tarif etudiant",
        "value": 5,
        "current": true
    }
    """
    Quand       je fais un GET sur /prices/current
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
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
            "id": "#^\\d+$#",
            "type": "Tarif etudiant",
            "value": 5,
            "current": true
        }
    ]
    """

@POST
Scénario: Créer un price avec des infos caca
    Quand       je fais un POST sur /prices avec le corps contenu dans "add_price_wrong.json"
    Alors       le status HTTP devrait être 400
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    [
        "[type]: The value you selected is not a valid choice.",
        "[value]: This value should be of type float."
    ]
    """
