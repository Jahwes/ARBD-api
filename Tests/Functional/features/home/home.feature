# language: fr

@feature/home
Fonctionnalité: GET sur / pour tester behat

@GET
Scénario: GET sur /
    Quand je fais un GET sur /
    Alors je devrais avoir un résultat d'API en JSON
    Et    le status HTTP devrait être 200
    Et    je devrais avoir un résultat d'API en JSON
    Et    le résultat devrait être identique au JSON suivant :
    """
    IT WORKS !
    """
