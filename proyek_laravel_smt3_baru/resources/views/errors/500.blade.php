<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
        }

        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #667eea;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h2>Oops! Something went wrong</h2>

        @if (isset($message))
            <div class="alert alert-danger mt-4">
                <strong>Error:</strong> {{ $message }}
            </div>
        @endif

        <div class="mt-4">
            <h5>Kemungkinan Penyebab:</h5>
            <ul class="text-start">
                <li>Database belum dibuat atau tidak terhubung</li>
                <li>Migration belum dijalankan (<code>php artisan migrate</code>)</li>
                <li>File .env belum dikonfigurasi dengan benar</li>
                <li>Tabel yang dibutuhkan tidak ada</li>
            </ul>
        </div>

        <div class="mt-4">
            <h5>Solusi:</h5>
            <ol class="text-start">
                <li>Pastikan MySQL sudah jalan</li>
                <li>Cek file .env (database name, username, password)</li>
                <li>Jalankan: <code>php artisan migrate</code></li>
                <li>Clear cache: <code>php artisan config:clear</code></li>
            </ol>
        </div>
    </div>
</body>

</html>
