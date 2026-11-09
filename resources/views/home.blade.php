<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinyhop</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: #05070D;
            color: #F1F5F9;
            font-family: system-ui, -apple-system, Segoe UI, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .wrap { width: 100%; max-width: 620px; text-align: center; }
        h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .tagline { color: #94A3B8; margin: 8px 0 32px; }
        form { display: flex; gap: 8px; }
        input[type="url"] {
            flex: 1;
            padding: 16px;
            border-radius: 14px;
            border: 1px solid #1E293B;
            background: #0B1020;
            color: #F1F5F9;
            font-size: 1rem;
            outline: none;
        }
        input[type="url"]:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.25); }
        button {
            padding: 16px 24px;
            border: none;
            border-radius: 14px;
            background: #3B82F6;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background: #2563EB; }
        .error { color: #F87171; margin-top: 16px; }
        
                .result { margin-top: 24px; padding: 20px; border-radius: 14px; background: #0B1020; border: 1px solid #1E293B; }
        .result a { color: #60A5FA; font-weight: 600; word-break: break-all; }

                .copy-btn { margin-top: 12px; padding: 10px 18px; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Tinyhop</h1>
        <p class="tagline">Paste a long link. Get a tiny hop.</p>

        <form method="POST" action="/">
            @csrf
            <input type="url" name="original_url" placeholder="https://" value="{{ old('original_url') }}" required>
            <button type="submit">Shorten</button>
        </form>
        @if (session('short_url'))
                        <div class="result">
                <p>Your short link:</p>
                <a href="{{ session('short_url') }}" target="_blank" id="short-link">{{ session('short_url') }}</a>
                <button type="button" id="copy-btn" class="copy-btn">Copy</button>
            </div>

            <script>
                document.getElementById('copy-btn')?.addEventListener('click', function () {
                    const link = document.getElementById('short-link').href;
                    navigator.clipboard.writeText(link).then(() => {
                        this.textContent = 'Copied!';
                        setTimeout(() => this.textContent = 'Copy', 2000);
                    });
                });
            </script>
        @endif

        @error('original_url')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</body>
</html>