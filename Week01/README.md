# Week 01 – Kennismaking met Docker Compose

Deze week maak je kennis met **Docker Compose** door een eenvoudige nginx-webserver op te zetten die een statische HTML-pagina serveert.

---

## Omgeving starten

Start de Docker-omgeving:

```bash
docker compose -f docker-compose-nginx.yml up -d
```

De webpagina is daarna bereikbaar op [http://localhost:8080](http://localhost:8080).

---

## Wat draait er?

De compose-file start één container:

| Service | Image | Poort |
|---|---|---|
| `web` | `nginx:stable` | `8080 → 80` |

De map `html/` wordt als volume in de container gemount. Het bestand `html/index.html` is de pagina die nginx serveert.

---

## Stoppen

```bash
docker compose -f docker-compose-nginx.yml down
```
