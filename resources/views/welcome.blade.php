<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenPlant - Добро пожаловать</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .container {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h1 { font-size: 48px; margin-bottom: 20px; }
        p { font-size: 18px; margin-bottom: 30px; opacity: 0.9; }
        .links { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        a {
            display: inline-block;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .status {
            margin-top: 30px;
            padding: 20px;
            background: rgba(76, 175, 80, 0.2);
            border-radius: 10px;
            border: 1px solid rgba(76, 175, 80, 0.5);
        }
        .status p { margin: 5px 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌲 GreenPlant</h1>
        <p>CMS успешно установлена и готова к работе!</p>
        
        <div class="links">
            <a href="{{ route('home') }}">Главная страница</a>
            <a href="{{ route('admin.dashboard') }}">Админ-панель</a>
            <a href="{{ route('login') }}">Вход</a>
        </div>

        <div class="status">
            <p><strong>✅ Laravel {{ app()->version() }}</strong></p>
            <p>✅ База данных: {{ config('database.default') }}</p>
            <p>✅ Окружение: {{ config('app.env') }}</p>
        </div>
    </div>
</body>
</html>

