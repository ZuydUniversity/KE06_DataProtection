# Week 07 – Security scanning met OWASP ZAP

Deze week gebruik je de omgeving van Week 05 om een geautomatiseerde beveiligingsscan uit te voeren op de DVWA-applicatie met behulp van **OWASP ZAP** (Zed Attack Proxy).

---

## Omgeving starten

Start de Docker-omgeving van Week 05:

```bash
docker compose -f ../Week05/docker-compose-dvwa-php.yml up -d
```

De DVWA-applicatie is daarna bereikbaar op [http://localhost:4280](http://localhost:4280).

> Heb je de DVWA-database nog niet aangemaakt? Ga dan eerst naar [http://localhost:4280/setup.php](http://localhost:4280/setup.php) en klik op **Create / Reset Database**.

---

## Java installeren (Windows)

ZAP vereist op Windows **Java 17 of hoger**. Controleer eerst of Java al aanwezig is:

```powershell
java -version
```

Staat er geen versie of een versie lager dan 17? Installeer Java dan als volgt:

1. Ga naar [https://adoptium.net/](https://adoptium.net/)
2. Download de **Windows x64 Installer** voor **Temurin 21 (LTS)**
3. Voer de installer uit en doorloop de stappen — laat alle standaardinstellingen staan
4. Controleer na installatie opnieuw met `java -version` of versie 21 wordt getoond

---

## ZAP downloaden en installeren

1. Ga naar [https://www.zaproxy.org/download/](https://www.zaproxy.org/download/)
2. Download de installer voor jouw besturingssysteem
3. Voer de installer uit en doorloop de installatiestappen:


---

## ZAP opstarten

1. Start ZAP via het programma-icoon of via de terminal
2. Bij de eerste keer opstarten vraagt ZAP of je een **sessie wilt opslaan** — kies **No, I do not want to persist this session** en klik op **Start**
3. ZAP opent met de **Quick Start**-tab

---

## Scan uitvoeren op DVWA

> [!WARNING]
> **Voer op het netwerk van Zuyd Hogeschool uitsluitend scans uit op je eigen `localhost`.**
> Scan geen Zuyd-machines of machines buiten het netwerk, en scan nooit sites of systemen waar je geen expliciete toestemming voor hebt.
> Dit wordt gedetecteerd door de Zuyd-systemen, vormt een overtreding van de ICT-richtlijnen en kan disciplinaire gevolgen hebben.

1. Klik in de **Quick Start**-tab op **Automated Scan**
2. Vul bij *URL to attack* het volgende in:

   ```
   http://localhost:4280
   ```

3. Klik op **Attack** — ZAP start een Spider om de applicatie in kaart te brengen, gevolgd door een actieve scan
4. Volg de voortgang in de tabbladen **Spider** en **Active Scan** onderaan het scherm
5. Na afloop zie je de gevonden kwetsbaarheden in het tabblad **Alerts**



---

## Scan met het Automation Framework

ZAP heeft een **Automation Framework** waarmee je een volledige geauthenticeerde scan kunt uitvoeren via een configuratiebestand (YAML). Voor DVWA is zo'n plan al beschikbaar. Zie hier: https://www.zaproxy.org/faq/details/setting-up-zap-to-test-dvwa/


### Automation Framework zichtbaar maken

Het Automation Framework is standaard verborgen in ZAP. Voeg het toe via het tabblad-paneel onderaan:

1. Klik op de **+** knop rechts van de tabbladen onderaan het ZAP-scherm
2. Kies **Automation** uit de lijst
3. Het tabblad **Automation** verschijnt nu onderaan

### Automation plan downloaden

1. Download het automation plan volgens via de gegeven URL

### Plan importeren en uitvoeren

1. Importeer het plan in het tabblad **Automation** 
2. Controleer of het plan correct is geladen — je ziet de stappen in het Automation-paneel
3. Klik op de **Run**-knop (groene pijl) om het plan te starten

   > Het plan logt automatisch in op DVWA en voert daarna een volledige spider en actieve scan uit. Dit kan enkele minuten duren.

5. Volg de voortgang in het **Automation**-tabblad en in de **Spider**- en **Active Scan**-tabbladen
6. Na afloop zie je de resultaten in het tabblad **Alerts**

### Beveiligingsniveau aanpassen in het plan

In het YAML-bestand kun je het DVWA-beveiligingsniveau instellen. Zoek de volgende regel:

```yaml
level: low
```

Verander `low` naar `medium` of `high` en sla het bestand op. Importeer het plan opnieuw en voer het uit. Vergelijk de gevonden kwetsbaarheden met de vorige scan.

> Bij hogere beveiligingsniveaus beschermt DVWA zich beter en zal ZAP minder kwetsbaarheden vinden. Dit illustreert het effect van beveiligingsmaatregelen.

---

## Stoppen

```bash
docker compose -f ../Week05/docker-compose-dvwa-php.yml down
```
