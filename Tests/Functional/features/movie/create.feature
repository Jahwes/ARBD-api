# language: fr

@feature/create_movie
Fonctionnalité: Création d'un movie

@POST
Scénario: Créer un movie avec les bonnes infos
    Quand       je fais un POST sur /movies avec le corps contenu dans "add_movie.json"
    Alors       le status HTTP devrait être 201
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id":"#^\\d+$#",
        "title": "Les animaux fantastiques",
        "duration": 120
    }
    """

@POST
Scénario: Créer un movie avec des infos caca
    Quand       je fais un POST sur /movies avec le corps contenu dans "add_movie_wrong.json"
    Alors       le status HTTP devrait être 400
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    [
        "[title]: This value should not be blank.",
        "[duration]: This value should be of type integer."
    ]
    """
