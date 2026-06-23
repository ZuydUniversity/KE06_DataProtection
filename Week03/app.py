from flask import Flask, request
import requests

app = Flask(__name__)
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
    return """
    <h1>Admin Pagina</h1>
    <p>Welkom op de beheerpagina. Deze pagina is alleen bedoeld voor beheerders. Deze pagina is normaal gesproken alleen bereikbaar vanaf de server waar deze applicatie op draait.</p>
    <ul>
        <li>Gebruikersbeheer</li>
        <li>Systeeminstellingen</li>
        <li>Logbestanden</li>
    </ul>
    """

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
