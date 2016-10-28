# language: fr

@feature/post_orders
Fonctionnalité: Post des orders

@GET
Scénario: Post un order
    Quand       je fais un POST sur /orders avec le JSON suivant :
    """
    {
        "Acheteur": {
            "Civilite": "Mademoiselle",
            "Nom": "Lawson",
            "Prenom": "Bradly",
            "Age": 6,
            "Email": "lawson.bradly@e-corp.com"
        },
        "Film": {
            "Titre": "Master of Assassination",
            "Jour": "2016-10-20",
            "Horaire": "03:00",
            "3D": "Oui"
        },
        "Ticket": [
            {
                "Spectateur": {
                    "Civilite": "Mademoiselle",
                    "Nom": "Lawson",
                    "Prenom": "Bradly",
                    "Age": 6
                },
                "Tarif": "Tarif etudiant"
            },
            {
                "Spectateur": {
                    "Civilite": "Mademoiselle",
                    "Nom": "Anissa",
                    "Prenom": "Novella",
                    "Age": 59
                },
                "Tarif": "Senior"
            },
            {
                "Spectateur": {
                    "Civilite": "Mademoiselle",
                    "Nom": "Daryl",
                    "Prenom": "Elizabeth",
                    "Age": 33
                },
                "Tarif": "Plein tarif"
            }
        ]
    }
    """
    Alors       le status HTTP devrait être 201
    Et          je devrais avoir un résultat d'API en JSON
    Et          le résultat devrait être identique au JSON suivant :
    """
    {
        "id": "#^\\d+$#",
        "created_at": "2016-10-01",
        "user": {
            "id": 6,
            "lastname": "Lawson",
            "firstname": "Bradly",
            "date_of_birth": "2010-01-01",
            "title": "Mademoiselle",
            "email": "lawson.bradly@e-corp.com"
        }
    }
    """
