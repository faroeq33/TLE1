# [Streamteam IP-car client](https://ipcar-team12.nl/)

Streamteam is een Tailored Learning Environment (TLE) project voor de studie CMGT, Hogeschool Rotterdam. Het project focust op de bestaande IP-car, een via een server te besturen auto met een livefeed, die moet worden ingezet voor dagbesteding binnen zorghuizen. De IP-car kan via deze software verbinden met een gids, die een live beeld te zien krijgt en controle van de auto kan overnemen met een controller via dezelfde verbinding.
Het is een oplevering aan [VindiQu](https://vindiqu.com/) en [FoxConnect](https://fox-connect.nl/). VindiQu biedt al livestream dagbesteding aan zorghuizen, en FoxConnect is de ontwikkelaar van de eerste IP-car, origineel bedoeld voor particulier gebruik van mensen met een motorische beperking.

## Projectleden
* [Faroeq Alves](https://www.github.com/faroeq33)
* [Roel Hoogendoorn](https://github.com/roel204)
* [Nelio Jarmohamed](https://github.com/Nelio-J)
* [Jaap Moerkerk](https://jaapmoerkerk.nl)
* [Angelique Smit](https://github.com/angelique-smit)

TLE1 2023/2024 - Team 12 (IP-car)
Hogeschool Rotterdam - Creative Media & Game Technologies


## Testgebruikers
Om te testen of de rollen goed werken kun je gebruik maken van de volgende testgebruikers.


Daarvoor moet je eerste de seeders uitvoeren om gebruik te maken van de testgebruikers.
```diff
- Let op! migrate:fresh maak eerst je database leeg voordat het nieuwe gegevens invult!
```
```s
php artisan migrate:fresh --seed
```

### Login voor admin
Na ` php artisan migrate:fresh --seed ` te hebben uitgevoerd kan je de volgende gegevens gebruiken.
```
name: testadmin
email: testadmin@test.com
password: testpassword123
```

## Gebruikershandleiding

### Gebruiker die een tour heeft geboekt:
- U ontvangt een mail met een link naar de tour.
- Open deze link op de datum en tijd van de tour.
- Klik op de “Verbinden” knop.

### Gids Gebruiker:
- Een admin heeft voor u een account aangemaakt en heeft hiervoor de gegevens doorgegeven.
- Ga naar https://ipcar-team12.nl en log in met uw Email en wachtwoord.
- Op het touroverzicht scherm ziet u alle tours die voor u zijn aangemaakt.
- Als u op een van de tours klikt, ziet u de overzichtspagina.
- Klik op de groene “Start Livestream” knop om de stream te starten.
- Klik op de “Verbinden” knop.
- Op de livestream pagina kunt u verbinden met de IP-Car en testen of alles werkt.
- Verbind en selecteer een PlayStation 4 controller om de IP-Car te kunnen besturen.

### Admin Gebruiker:
#### Eerste gebruik:
- Ga naar https://ipcar-team12.nl
- De eerste keer dat de website wordt gebruikt zijn er test accounts om in te loggen.
- Email = testadmin@test.com | Wachtwoord = testpassword123
- Log in met dit account en ga naar het gebruikersoverzicht.
- Op het gebruikersoverzicht kunt U een nieuw admin account voor uzelf aanmaken met uw eigen Email adres en veilig wachtwoord.
- Nadat er een nieuw admin account is aangemaakt, kunt u uitloggen uit het test account.
- Log nu in met het account dat daarnet is aangemaakt.
- Verwijder de test accounts, want de login daarvan staat publiek.

#### Nieuwe Gebruiker toevoegen:
- Op de gebruiker pagina kunt u een nieuwe gebruiker toevoegen.
- Klik op de “Gebruiker Toevoegen” knop.
- Vul de gegevens van de gebruiker in en verzin een goed wachtwoord.
- Als dit account voor een admin is moet de admin knop aan staan, uit is voor een gids.
- Bericht de gebruiker dan het account is aangemaakt en wat het wachtwoord is.

#### Nieuwe Tour toevoegen:
- Op de tour overzichtspagina zijn als admin alle bestaande tours zichtbaar. (een gids ziet alleen zijn eigen tours)
- Klik op de “Tour Toevoegen” knop en vul alle gegevens in.
- Vul eventuele extra informatie voor de gids in het beschrijving veld.

