<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AI Security & Governance Tool') — ImranDevBD</title>
    <meta name="description" content="@yield('meta_description', 'AI security and governance tool for policy enforcement, access reviews, risk scoring, audit logs, and continuous security posture management.')">
    <meta name="author" content="Imran Ahmed">
    <meta name="keywords" content="AI security, governance, policy enforcement, access reviews, risk scoring, audit logs, security posture, Laravel Filament">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Serif:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: {{ $accent ?? '#334155' }};
            --ink: #0f172a;
            --muted: #475569;
            --bg: #f1f5f9;
            --card: #ffffff;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "IBM Plex Sans", system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 420px at 0% -10%, rgba(51, 65, 85, 0.18), transparent 55%),
                radial-gradient(700px 360px at 100% 0%, rgba(100, 116, 139, 0.12), transparent 50%),
                linear-gradient(180deg, #e2e8f0 0%, #f1f5f9 40%, #f8fafc 100%);
            min-height: 100vh;
        }
        a { color: var(--accent); text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin: 0 auto; }
        header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 0; gap: 1rem; flex-wrap: wrap;
        }
        .brand {
            font-family: "IBM Plex Serif", Georgia, serif;
            font-size: 1.45rem; font-weight: 600; color: var(--ink);
            letter-spacing: -0.02em;
        }
        nav { display: flex; gap: 0.95rem; flex-wrap: wrap; align-items: center; }
        nav a { color: var(--muted); font-weight: 600; font-size: 0.95rem; }
        nav a:hover { color: var(--accent); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--accent); color: #fff !important; border-radius: 0.55rem;
            padding: 0.7rem 1.15rem; font-weight: 700; border: 0;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(51,65,85,.28); }
        .btn-outline {
            background: transparent; color: var(--accent) !important;
            border: 1.5px solid var(--accent);
        }
        .hero { padding: 3.2rem 0 2rem; display: grid; gap: 1.1rem; animation: rise .7s ease both; }
        .hero h1 {
            font-family: "IBM Plex Serif", Georgia, serif;
            font-size: clamp(2.05rem, 4.8vw, 3.2rem);
            line-height: 1.1; margin: 0; max-width: 16ch; letter-spacing: -0.03em;
        }
        .hero p { max-width: 58ch; color: var(--muted); font-size: 1.08rem; line-height: 1.6; margin: 0; }
        .cta-row { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 0.4rem; }
        .panel {
            background: var(--card);
            border: 1px solid rgba(51, 65, 85, 0.14);
            border-radius: 0.9rem;
            padding: 1.35rem;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.05);
            transition: transform .25s ease;
        }
        .panel:hover { transform: translateY(-3px); }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .section { padding: 2rem 0 3rem; }
        .section h2 {
            font-family: "IBM Plex Serif", Georgia, serif;
            font-size: clamp(1.5rem, 3vw, 2.05rem);
            margin: 0 0 0.75rem; letter-spacing: -0.02em;
        }
        .muted { color: var(--muted); }
        .kpi { font-size: 1.85rem; font-weight: 700; color: var(--accent); }
        .badge {
            display: inline-block; font-size: 0.78rem; font-weight: 700;
            padding: 0.2rem 0.55rem; border-radius: 999px;
            background: rgba(51,65,85,.1); color: var(--accent);
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
        th, td { text-align: left; padding: 0.65rem 0.4rem; border-bottom: 1px solid #e2e8f0; }
        footer { padding: 2rem 0 3rem; color: var(--muted); font-size: 0.92rem; }
        @keyframes rise { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
        @media (max-width: 640px) {
            .hero h1 { max-width: none; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <a class="brand" href="{{ route('home') }}">AegisGov</a>
            <nav>
                <a href="{{ route('features') }}">Features</a>
                <a href="{{ route('modules') }}">Modules</a>
                <a href="{{ route('policies') }}">Policies</a>
                <a href="{{ route('reviews') }}">Reviews</a>
                <a href="{{ route('posture') }}">Posture</a>
                <a href="{{ route('pricing') }}">Pricing</a>
                <a href="{{ route('demo') }}">Demo</a>
                <a class="btn" href="/admin">Admin</a>
            </nav>
        </header>
        @yield('content')
        <footer>
            Built by <a href="https://imrandev.bd">Imran Ahmed</a> · AI Security &amp; Governance Tool · Accent <code>#334155</code>
        </footer>
    </div>
</body>
</html>
