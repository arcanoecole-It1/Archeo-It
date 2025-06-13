#!/usr/bin/env python3
import random
import string
import sys

def generate_password(password_type, length=12):
    """
    Génère un mot de passe aléatoire selon le type demandé
    Types: 1 = Alphabétique, 2 = Alphanumérique, 3 = Avec caractères spéciaux
    """
    # Définir les caractères disponibles selon le type
    lowercase = string.ascii_lowercase
    uppercase = string.ascii_uppercase
    digits = string.digits
    special_chars = "!@#$%^&*()_+-=[]{}|;:,.<>?"
    if password_type == "1":
        chars = lowercase + uppercase
    elif password_type == "2":
        chars = lowercase + uppercase + digits
    elif password_type == "3":
        chars = lowercase + uppercase + digits + special_chars
    else:
        return "Erreur: Type invalide"
    # Générer le mot de passe
    password = []
    # on s'assure d'avoir au moins une majuscule et une minuscule
    password.append(random.choice(uppercase))
    password.append(random.choice(lowercase))
    # Ajouter d'autres caractères selon le type
    if password_type == "2":
        password.append(random.choice(digits))
    elif password_type == "3":
        password.append(random.choice(digits))
        password.append(random.choice(special_chars))
    # Compléter le reste du mot de passe
    for _ in range(length - len(password)):
        password.append(random.choice(chars))
    # Mélanger le mot de passe
    random.shuffle(password)
    return ''.join(password)

if __name__ == "__main__":
    if len(sys.argv) > 1:
        password_type = sys.argv[1]
        length = int(sys.argv[2]) if len(sys.argv) > 2 else 12
        print(generate_password(password_type, length))
    else:
        print("Types: 1=Alphabétique, 2=Alphanumérique, 3=Avec caractères spéciaux")