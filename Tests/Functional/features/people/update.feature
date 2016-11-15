# language: fr

@feature/update_people
Fonctionnalité: Update d'un people

@PUT
Scénario: Update un people avec les bonnes infos
    Quand       je fais un PUT sur /peoples/1 avec le corps contenu dans "update_people.json"
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "lastname": "GREEN",
        "firstname": "Eva",
        "date_of_birth": "1957-02-21",
        "nationality": "américaine"
    }
    """

@PUT
Scénario: Update un people avec des infos caca
    Quand       je fais un PUT sur /peoples/1 avec le corps contenu dans "add_people_wrong.json"
    Alors       le status HTTP devrait être 400
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    [
        "[lastname]: This value should be of type string.",
        "[firstname]: This value should not be blank.",
        "[date_of_birth]: This value is not a valid date.",
        "[nationality]: This value should not be blank."
    ]
    """
