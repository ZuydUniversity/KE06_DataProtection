# Week 06 – Databasebeveiliging met DBeaver

Deze week gebruik je de omgeving van Week 05 om databasebeveiligingsmaatregelen te implementeren en te testen via **DBeaver**.

---

## Omgeving starten

Start de Docker-omgeving van Week 05:

```bash
docker compose -f ../Week05/docker-compose-dvwa-php.yml up -d
```

De MariaDB-database is daarna bereikbaar op `localhost:3306`.

> Heb je de DVWA-database nog niet aangemaakt? Ga dan eerst naar [http://localhost:4280/setup.php](http://localhost:4280/setup.php) en klik op **Create / Reset Database**.

---

## DBeaver installeren

1. Ga naar [https://dbeaver.io/download/](https://dbeaver.io/download/)
2. Download de **Community Edition** voor jouw besturingssysteem
3. Installeer DBeaver via de installer (standaardinstellingen zijn voldoende)

---

## Verbinding maken met de database

Start DBeaver en maak een nieuwe verbinding aan:

1. Klik op **Database → New Database Connection** (of het stopcontact-icoon linksboven)
2. Kies **MariaDB** en klik op **Next**
3. Vul de volgende gegevens in:

| Instelling | Waarde |
|---|---|
| Server Host | `localhost` |
| Port | `3306` |
| Database | `dvwa` |
| Username | `root` |
| Password | `dvwa` |

4. Klik op **Test Connection** — DBeaver vraagt eventueel om de JDBC-driver te downloaden, klik dan op **Download**
5. Klik op **Finish**

Je ziet nu in het linker paneel de `dvwa`-database met daarin de tabellen, waaronder `users`.

---

## Stoppen

```bash
docker compose -f ../Week05/docker-compose-dvwa-php.yml down
```
