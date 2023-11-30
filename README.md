# Ip-car client
Deze applicatie gebruikt de gids om de ip-car op afstand te kunnen bedienen

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

