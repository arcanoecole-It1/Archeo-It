import random # module pour générer des caracteres aléatoires.
import string # module contenant des ensembles de caracteres prédéfinis (lettres, chiffres, caracteres spéciaux).

def generate_password(option, length=12):
    if option == "alphabétique":
        characters = string.ascii_letters # lettres minuscules et majuscules
    elif option == "alphabétique et numérique":
        characters = string.ascii_letters + string.digits # lettres et chiffres
    elif option == "alphabétique, numérique et caractères spéciaux":
        characters = string.ascii_letters + string.digits + string.punctuation # lettres, chiffres et caracteres spéciaux
    else:
        raise ValueError("Option invalide")

    password = ''.join(random.choice(characters) for _ in range(length)) # génère un mot de passe aléatoire de la longueur spécifiée
    return password

option = input("Choisissez une option (alphabétique, alphabétique et numérique, alphabétique, numérique et caractères spéciaux) : ")
password = generate_password(option)
print(f"Mot de passe généré : {password}")