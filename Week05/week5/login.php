<?php
/**
 * INTENTIONALLY VULNERABLE LOGIN – uitsluitend voor educatief gebruik
 * Data Protection module – Week 5
 *
 * Bekende kwetsbaarheden (opdracht: repareer deze):
 *  1. SQL Injection via string-concatenatie in de query
 *  2. MD5-wachtwoordhashing (geen salting, cryptografisch zwak)
 *  3. SQL-foutmeldingen worden blootgesteld aan de gebruiker
 */

$host   = 'db';
$dbname = 'dvwa';
$dbuser = 'dvwa';
$dbpass = 'p@ssw0rd';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

$message  = '';
$rows     = [];
$last_sql = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // ⚠ KWETSBAAR: directe string-concatenatie – vatbaar voor SQL Injection
    $last_sql = "SELECT user_id, first_name, last_name, user, password "
              . "FROM users "
              . "WHERE user='" . $user . "' AND password=MD5('" . $pass . "')";

    // PHP 8 gooit een exception bij SQL-fouten; catch zodat de fout zichtbaar wordt
    try {
        $res = $conn->query($last_sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
            $message = 'success:Welkom, ' . htmlspecialchars($rows[0]['first_name'])
                     . ' ' . htmlspecialchars($rows[0]['last_name']) . '!';
        } else {
            $message = 'error:Ongeldige gebruikersnaam of wachtwoord';
        }
    } catch (mysqli_sql_exception $e) {
        // ⚠ KWETSBAAR: SQL-fout direct teruggeven aan de browser
        $message = 'error:SQL-fout: ' . htmlspecialchars($e->getMessage());
    }
}

// Splits type en tekst
$msg_type = '';
$msg_text = '';
if ($message !== '') {
    [$msg_type, $msg_text] = explode(':', $message, 2);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Data Protection Week 5</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #1a1a2e;
            color: #eee;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #16213e;
            border: 1px solid #0f3460;
            border-radius: 8px;
            padding: 32px 40px;
            width: 100%;
            max-width: 440px;
        }
        h1 {
            font-size: 1.4rem;
            color: #e94560;
            margin-bottom: 4px;
        }
        .subtitle {
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 4px;
            margin-top: 16px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #0f3460;
            border-radius: 4px;
            background: #0f3460;
            color: #eee;
            font-size: 0.95rem;
        }
        input:focus { outline: 2px solid #e94560; border-color: transparent; }
        button {
            margin-top: 24px;
            width: 100%;
            padding: 11px;
            background: #e94560;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover { background: #c73652; }
        .alert {
            margin-top: 20px;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 0.9rem;
            word-break: break-word;
        }
        .alert.success { background: #1b4332; border: 1px solid #2d6a4f; color: #95d5b2; }
        .alert.error   { background: #4a1a1a; border: 1px solid #c0392b; color: #e57373; }
        .sql-debug {
            margin-top: 20px;
            background: #0d0d1a;
            border: 1px solid #333;
            border-radius: 4px;
            padding: 10px 14px;
            font-family: monospace;
            font-size: 0.78rem;
            color: #facc15;
            word-break: break-all;
        }
        .sql-debug span { color: #888; }
        .results-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }
        .results-table th {
            background: #0f3460;
            color: #e94560;
            padding: 6px 10px;
            text-align: left;
        }
        .results-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #1e2a4a;
            color: #ccc;
        }
        .warn-banner {
            background: #3d2000;
            border: 1px solid #f59e0b;
            color: #fcd34d;
            border-radius: 4px;
            padding: 8px 14px;
            font-size: 0.78rem;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="warn-banner">⚠ INTENTIONALLY VULNERABLE – educatief gebruik</div>
        <h1>Inloggen</h1>
        <p class="subtitle">Data Protection – Week 5 | DVWA database</p>

        <form method="POST" action="">
            <label for="username">Gebruikersnaam</label>
            <input type="text" id="username" name="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   autocomplete="off" autofocus>

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password">

            <button type="submit">Inloggen</button>
        </form>

        <?php if ($msg_text !== ''): ?>
            <div class="alert <?= $msg_type ?>">
                <?= htmlspecialchars($msg_text) ?>
            </div>
        <?php endif; ?>

        <?php if ($last_sql !== ''): ?>
            <!-- ⚠ KWETSBAAR: uitgevoerde SQL zichtbaar in de browser -->
            <div class="sql-debug">
                <span>Uitgevoerde query:</span><br>
                <?= htmlspecialchars($last_sql) ?>
            </div>
        <?php endif; ?>

        <?php if (count($rows) > 1): ?>
            <!-- Meerdere rijen = UNION injection geslaagd -->
            <table class="results-table">
                <thead>
                    <tr>
                        <th>user_id</th>
                        <th>user</th>
                        <th>first_name</th>
                        <th>last_name</th>
                        <th>password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['user_id'])    ?></td>
                            <td><?= htmlspecialchars($r['user'])        ?></td>
                            <td><?= htmlspecialchars($r['first_name'])  ?></td>
                            <td><?= htmlspecialchars($r['last_name'])   ?></td>
                            <td><?= htmlspecialchars($r['password'])    ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
