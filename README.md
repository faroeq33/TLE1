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

### Login voor medewerker
```
name: testuser
email: test@test.com
password: testpassword123
```

