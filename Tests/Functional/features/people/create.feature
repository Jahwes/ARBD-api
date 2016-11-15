# language: fr

@feature/create_people
Fonctionnalité: Création d'un people

@POST
Scénario: Créer un people avec les bonnes infos
    Quand       je fais un POST sur /peoples avec le corps contenu dans "add_people.json"
    Alors       le status HTTP devrait être 201
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id":"#^\\d+$#",
        "lastname": "NEWPORT",
        "firstname": "Biche",
        "date_of_birth": "1955-02-21",
        "nationality": "américaine"
    }
    """
