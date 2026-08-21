# Week 04 – SQL Injection

Deze oefening demonstreert een **SQL Injection**-kwetsbaarheid via de DVWA applicatie uit Week 02.
Bij SQL Injection kan een aanvaller kwaadaardige SQL-code invoegen in een invoerveld, waardoor de database onbedoelde commando's uitvoert.

---

## Voorbereiding

Zorg ervoor dat de DVWA applicatie uit Week 02 draait:

```bash
docker compose -f ../Week02/docker-compose-dvwa.yml up -d
```

Open je webbrowser en ga naar:
```
http://localhost:4280/login.php
```

**Standaard inloggegevens:**
- Gebruikersnaam: `admin`
- Wachtwoord: `password`

---

## De database structuur

De `users`-tabel in de DVWA-database ziet er als volgt uit:

```sql
CREATE TABLE `users` (
  `user_id` int(6) NOT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `avatar` varchar(70) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `failed_login` int(3) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `account_enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

---

## SQL Injection uitproberen

### 1. Navigeer naar het kwetsbare scherm
Ga in DVWA (level low) naar het menu-item **"SQL Injection"**. 

### 2. Voer een normale query in
Voer een geldig gebruikers-ID in, bijvoorbeeld:
```
1
```
Je ziet de bijbehorende gebruikersinformatie.

### 3. Probeer een SQL Injection
Voer het volgende in het invoerveld in:
```
1' OR '1'='1
```
Dit manipuleert de onderliggende SQL-query zodat **alle gebruikers** worden teruggegeven in plaats van slechts één.

> ⚠️ **Let op:** Voer deze aanvallen uitsluitend uit in deze gecontroleerde oefenomgeving. SQL Injection op echte systemen zonder toestemming is illegaal.

---

## Meer informatie

- 📚 [OWASP SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)
- 📚 [DVWA GitHub Repository](https://github.com/digininja/DVWA)

