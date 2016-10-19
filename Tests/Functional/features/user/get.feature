# language: fr

@feature/get_users
Fonctionnalité: Get des users

@GET
Scénario: Get tous les users du monde
    Quand       je fais un GET sur /users
    Alors       le status HTTP devrait être 200
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    [
        {
             "id": 1,
             "lastname": "HEART",
             "firstname": "Kingston",
             "date_of_birth": {
                 "date": "1994-02-15 00:00:00.000000",
                 "timezone_type": 3,
                 "timezone": "Europe\/Paris"
             },
             "title": "Monsieur",
             "email": "heart_k@etna.io"
        },
        {
             "id": 2,
             "lastname": "BELANGER",
             "firstname": "Angélique",
             "date_of_birth": {
                 "date": "1970-04-11 00:00:00.000000",
                 "timezone_type": 3,
                 "timezone": "Europe\/Paris"
             },
             "title": "Madame",
             "email": "AngeliqueBelanger@jourrapide.com"
        },
        {
             "id": 3,
             "lastname": "TALON",
             "firstname": "Faure",
             "date_of_birth": {
                 "date": "1986-04-06 00:00:00.000000",
                 "timezone_type": 3,
                 "timezone": "Europe\/Paris"
             },
             "title": "Monsieur",
             "email": "TalonFaure@redbearstavern.com"
        },
        {
             "id": 4,
             "lastname": "NOUEL",
             "firstname": "Soucy",
             "date_of_birth": {
                 "date": "1941-06-17 00:00:00.000000",
                 "timezone_type": 3,
                 "timezone": "Europe\/Paris"
             },
             "title": "Madame",
             "email": "NouelSoucy@rhyta.com"
        },
        {
             "id": 5,
             "lastname": "MELVILLE",
             "firstname": "Lamy",
             "date_of_birth": {
                 "date": "1957-12-04 00:00:00.000000",
                 "timezone_type": 3,
                 "timezone": "Europe\/Paris"
             },
             "title": "Mademoiselle",
             "email": "MelvilleLamy@dayrep.com"
        }
    ]
    """
