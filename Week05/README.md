# Week 05 – SQL Injection (eigen PHP applicatie)

Deze week draait naast DVWA ook een eigen, bewust kwetsbare PHP login-applicatie die gebruik maakt van de DVWA-database en `users`-tabel.

---

## Inhoud

| Bestand | Omschrijving |
|---|---|
| `docker-compose-dvwa-php.yml` | Start DVWA, de MariaDB-database én de PHP login-app |
| `week5/login.php` | Kwetsbare PHP login-applicatie |
| `week5/Dockerfile` | Bouwt het PHP-image met `mysqli`/`pdo_mysql` extensies |

---

## Starten

```bash
docker compose -f docker-compose-dvwa-php.yml up --build -d
```

`--build` is nodig omdat de `login-app` lokaal gebouwd wordt vanuit `week5/Dockerfile`.

### DVWA-database aanmaken

De PHP applicatie gebruikt de `users`-tabel van DVWA. Maak deze eerst aan:

1. Open [http://localhost:4280/login.php](http://localhost:4280/login.php) — inloggegevens: `admin` / `password`
2. Ga naar [http://localhost:4280/setup.php](http://localhost:4280/setup.php)
3. Klik op **Create / Reset Database** en log opnieuw in

De `users`-tabel bevat deze standaard gebruikers:

| Gebruikersnaam | Wachtwoord |
|---|---|
| admin | password |
| gordonb | abc123 |
| 1337 | charley |
| pablo | letmein |
| smithy | password |

### PHP login-applicatie

Open de loginpagina op: [http://localhost:8081/login.php](http://localhost:8081/login.php)

---

## login.php aanpassen

`login.php` is via een volume direct gekoppeld — wijzigingen zijn **direct zichtbaar** na een pagina-refresh, zonder rebuild.

Pas je `week5/Dockerfile` aan? Rebuild dan alleen de login-app:

```bash
docker compose -f docker-compose-dvwa-php.yml up --build -d login-app
```

---

## Stoppen

```bash
docker compose -f docker-compose-dvwa-php.yml down
```

Voeg `-v` toe om ook het database-volume te verwijderen:

```bash
docker compose -f docker-compose-dvwa-php.yml down -v
```
