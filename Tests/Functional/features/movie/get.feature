# language: fr

@feature/get_movies
Fonctionnalité: Get des movies

@GET
Scénario: Get tous les movies du monde
    Quand       je fais un GET sur /movies
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_all_movies.json"

@GET
Scénario: Get un movie par son ID
    Quand       je fais un GET sur /movies/1
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": 1,
        "title": "Miss Peregrine et les enfants particuliers",
        "duration": 127
    }
    """

@GET
Scénario: Get les showings d'un movie
    Quand       je fais un GET sur /movies/1/showings
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_showings.json"

@GET
Scénario: Get les people d'un movie
    Quand       je fais un GET sur /movies/1/people
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_people.json"

@GET
Scénario: Get les types d'un movie
    Quand       je fais un GET sur /movies/1/types
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au fichier "get_types.json"
