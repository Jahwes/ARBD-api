# language: fr

@feature/update_movie
Fonctionnalité: Update d'un movie

@PUT
Scénario: Update un movie avec les bonnes infos
    Quand       je fais un PUT sur /movies/1 avec le corps contenu dans "update_movie.json"
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "title": "Miss Peregrine et les enfants particuliers",
        "duration": 150
    }
    """
