# DVWA - Damn Vulnerable Web Application

## Wat is DVWA?

**DVWA** (Damn Vulnerable Web Application) is een web applicatie die opzettelijk vulnerabilities bevat. Dit is een trainingomgeving om te leren over veelvoorkomende web beveiligingsproblemen en hoe je deze kunt herkennen en oplossen.

> ⚠️ **Belangrijk:** DVWA is ALLEEN bedoeld voor leren in een gecontroleerde omgeving. Gebruik dit nooit in productie!

## Voorbereiding

Zorg ervoor dat je het volgende hebt geïnstalleerd:
- **Docker Desktop** (bevat Docker en Docker Compose)
- **Git**
- Een webbrowser (Chrome, Firefox, Edge, etc.)

## DVWA starten

### 1. Download de DVWA applicatie
Download de compose file.

### 2. Start met Docker Compose
```bash
docker-compose -f docker-compose-dvwa.yml up -d
```

Dit commando:
- Downloads de benodigde Docker images
- Start de DVWA container (web applicatie)
- Start de MySQL database
- Maakt alles beschikbaar op je lokale machine

### 3. Toegang tot DVWA
Open je webbrowser en ga naar:
```
http://localhost:4280/login.php
```

**Standaard inloggegevens:**
- Gebruikersnaam: `admin`
- Wachtwoord: `password`

## Eerste keer inloggen?

Na het eerste inloggen word je gevraagd de database in te stellen. Klik op "Create / Reset Database" en log daarna opnieuw in.


## Stoppen met DVWA

```bash
docker-compose down
```

Dit stopt en verwijdert de containers (gegevens blijven in de database).

## Meer informatie

- 📚 [DVWA GitHub Repository](https://github.com/digininja/DVWA)

---


