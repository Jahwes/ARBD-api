# language: fr

@feature/home
Fonctionnalité: GET sur / pour tester behat

@GET
Scénario: GET sur /price
    Quand je fais un GET sur /prices
    Alors je devrais avoir un résultat d'API en JSON
    Et    le status HTTP devrait être 200
    Et    je devrais avoir un résultat d'API en JSON
    Et    le résultat devrait être identique au JSON suivant :
    """
    [
        {
            "Bonjour": "Je suis un test",
            "Hello": 4242,
            "Cinema": "du turfu",
            "Plein de trucs": {
                "un truc": 1,
                "deux trucs": "bonjour",
                "trois trucs": 4938475
            }
        }
    ]
    """
