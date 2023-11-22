# Git flow
In eerste instantie zullen er twee branches zijn: main en development.
In de development branch doen we onze pull-requests, zodat we alle commits in één keer kunnen testen voordat ze naar de main worden gepusht.

# Als voorbeeld:
Ik zou aan een taak werken tijdens de huidige sprint, laten we zeggen dat de story-ID 123 is. Dan zou ik het project starten
als volgt:

1. (Optioneel) Clone de repository naar clone:
```sh
git clone git@github.com:Angelique-Smit/TLE1git
```

2. Maak een nieuwe branch vanaf development branch

```sh
    git checkout -b login/story-123
```

3. Werk aan de taak



## Voltooi de taak, voer alle wijzigingen door en push naar `login/story-123`
### Voeg alle bestanden toe aan de stage

```
git add .
```
### Voeg commit toe
```sh
git commit -m "Mijn boodschap"
```

### Maak remote branch aan
```sh
git push --set-upstream origin login/story-123
```

- Maak een pull-request van `login/story-123` naar development en voeg een vereiste reviewer toe.

- Schakel terug naar development branch terwijl ik wacht tot de reviewer mijn werk in de pull-aanvraag heeft gecontroleerd.
- Maak een nieuwe branch van development met de naam `login/story-123`
