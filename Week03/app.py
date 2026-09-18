import ipaddress
import os

from flask import Flask, request
from werkzeug.middleware.proxy_fix import ProxyFix
import requests

app = Flask(__name__)
# Achter proxy (1 hop): herstel het echte client-IP uit X-Forwarded-For/X-Real-IP
app.wsgi_app = ProxyFix(app.wsgi_app, x_for=1, x_proto=1, x_host=1)


DOCKER_DEFAULT_RANGE = ipaddress.ip_network('172.0.0.0/8')


def is_internal(ip):
    try:
        addr = ipaddress.ip_address(ip)
    except ValueError:
        return False
    if addr in DOCKER_DEFAULT_RANGE:  # Docker-bridgenetwerk telt hier als extern
        return False
    return addr.is_loopback or addr.is_private


@app.route('/fetch')
def fetch():
    url = request.args.get('url')
    try:
        response = requests.get(url)
        return response.text
    except Exception as e:
        return f"Fout bij ophalen: {e}", 500


@app.route('/admin')
def admin():
    client_ip = request.remote_addr
    admin_content = """
    <h1>Admin Pagina</h1>
    <p>Welkom op de beheerpagina. Deze pagina is alleen bedoeld voor beheerders. Deze pagina is normaal gesproken alleen bereikbaar vanaf de server waar deze applicatie op draait.</p>
    <ul>
        <li>Gebruikersbeheer</li>
        <li>Systeeminstellingen</li>
        <li>Logbestanden</li>
    </ul>
    """ if is_internal(client_ip) else "<p>Je bevindt je op een extern adres, het beheerdersgedeelte is hier niet zichtbaar.</p>"

    return f"""
    <p>Je IP-adres: {client_ip}</p>
    {admin_content}
    """


if __name__ == '__main__':
    debug = os.environ.get('FLASK_DEBUG', 'false').lower() == 'true'
    app.run(host='0.0.0.0', debug=debug)
