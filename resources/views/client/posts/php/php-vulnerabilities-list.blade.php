@extends('layouts.app')
@section('title', 'Exhaustive List of PHP Vulnerabilities - Notes')
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
    .meta-item{display:flex;align-items:center;gap:7px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--muted);} .meta-item svg{width:13px;height:13px;flex-shrink:0;}
    .read-btn{display:inline-flex;align-items:center;gap:8px;background:transparent;border:1px solid var(--border);border-radius:6px;padding:9px 18px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--text);cursor:pointer;transition:all .2s;margin-bottom:40px;} .read-btn:hover{border-color:var(--orange);color:var(--orange);} .read-btn svg{width:14px;height:14px;}
    .article-prose{line-height:1.8;font-size:15px;color:var(--text);}
    .article-prose h2{font-size:24px;font-weight:800;color:#fff;margin:48px 0 20px;}
    .article-prose h3{font-size:18px;font-weight:700;color:var(--orange);margin:40px 0 16px;font-family:'IBM Plex Mono',monospace;display:flex;align-items:center;gap:10px;} .article-prose h3::before{content:'//';color:var(--accent2);font-size:14px;opacity:.7;}
    .article-prose p{margin-bottom:16px;} .article-prose strong{color:#fff;font-weight:700;} .article-prose a{color:var(--accent);text-decoration:underline;}
    .article-prose ul{list-style:none;padding:0;margin-bottom:20px;display:flex;flex-direction:column;gap:10px;} .article-prose ul li{padding-left:20px;position:relative;color:var(--text);} .article-prose ul li::before{content:'›';position:absolute;left:0;color:var(--orange);font-size:16px;line-height:1.6;}
    .article-prose pre{background:#060a12;border:1px solid var(--border);border-radius:8px;padding:20px 24px;overflow-x:auto;margin:24px 0;position:relative;} .article-prose pre code{font-family:'IBM Plex Mono',monospace;font-size:13px;color:#00e5a0;background:none;padding:0;}
    .article-prose code{font-family:'IBM Plex Mono',monospace;font-size:13px;background:rgba(255,159,67,0.08);color:var(--orange);padding:2px 7px;border-radius:3px;border:1px solid rgba(255,159,67,0.2);}
    .copy-code{position:absolute!important;top:10px;right:10px;background:var(--surface);border:1px solid var(--border);border-radius:4px;color:var(--muted);padding:4px 10px;font-family:'IBM Plex Mono',monospace;font-size:10px;cursor:pointer;transition:all .2s;} .copy-code:hover{border-color:var(--orange);color:var(--orange);} .copy-code.copied{border-color:var(--green);color:var(--green);}
    .callout{border-radius:8px;padding:18px 22px;margin:24px 0;display:flex;gap:14px;align-items:flex-start;} .callout-icon{font-size:18px;flex-shrink:0;margin-top:2px;} .callout p{margin:0;font-size:14px;line-height:1.7;} .callout strong{font-weight:700;}
    .callout-warning{background:rgba(240,180,41,0.06);border:1px solid rgba(240,180,41,0.25);} .callout-warning p{color:#f5d67a;} .callout-warning strong{color:var(--yellow);}
    .callout-info{background:rgba(255,159,67,0.05);border:1px solid rgba(255,159,67,0.2);} .callout-info p{color:var(--text);} .callout-info strong{color:var(--orange);}
    .callout-danger{background:rgba(255,77,109,0.05);border:1px solid rgba(255,77,109,0.25);} .callout-danger p{color:#ffb3c0;} .callout-danger strong{color:var(--red);}
    .vuln-table{width:100%;border-collapse:collapse;margin:24px 0;font-family:'IBM Plex Mono',monospace;font-size:13px;}
    .vuln-table th{background:rgba(255,159,67,0.08);color:var(--orange);text-align:left;padding:10px 14px;border:1px solid var(--border);font-size:11px;text-transform:uppercase;letter-spacing:.08em;}
    .vuln-table td{padding:10px 14px;border:1px solid var(--border);color:var(--text);vertical-align:top;}
    .vuln-table tr:hover td{background:rgba(255,255,255,0.02);}
    .severity{display:inline-block;padding:2px 8px;border-radius:3px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;}
    .sev-critical{background:rgba(255,77,109,0.15);color:var(--red);border:1px solid rgba(255,77,109,0.3);}
    .sev-high{background:rgba(255,159,67,0.15);color:var(--orange);border:1px solid rgba(255,159,67,0.3);}
    .sev-medium{background:rgba(240,180,41,0.1);color:var(--yellow);border:1px solid rgba(240,180,41,0.3);}
    @media(max-width:768px){.post-body{padding:24px 16px 60px;}.article-card-inner{padding:24px;}.post-topbar-inner{padding:0 16px;}.vuln-table{font-size:11px;}}
</style>

<div class="post-root">
    <div class="post-topbar">
        <div class="post-topbar-inner">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('posts.index') }}">Notes</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('posts.index') }}?category=php">PHP Security</a>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">Exhaustive List of PHP Vulnerabilities</span>
            </nav>
        </div>
    </div>

    <div class="post-body">
        <div class="article-card">
            <div class="article-card-inner">
                <div><span class="cat-badge">PHP Security</span></div>
                <h1 class="article-title">Exhaustive List of PHP Vulnerabilities</h1>
                <div class="meta-row">
                    <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
                    <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
                    <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
                </div>

                <button id="read-btn" class="read-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                    Read Aloud
                </button>

                <div class="article-prose" id="article-content">

                    <h2>Exhaustive Reference of PHP Vulnerability Classes</h2>

                    <p>This article is a comprehensive reference covering every major PHP vulnerability class. Use it as a checklist during web application penetration tests. Each entry links to a dedicated article for deeper technical detail.</p>

                    <h3>Quick Reference Table</h3>

                    <table class="vuln-table">
                        <thead>
                            <tr>
                                <th>Vulnerability</th>
                                <th>Severity</th>
                                <th>Key Sink / Pattern</th>
                                <th>Impact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><strong>SQL Injection</strong></td><td><span class="severity sev-critical">Critical</span></td><td>mysql_query, PDO without prepared statements</td><td>Data exfiltration, auth bypass, RCE</td></tr>
                            <tr><td><strong>LFI / RFI</strong></td><td><span class="severity sev-critical">Critical</span></td><td>include($input), require($_GET['page'])</td><td>Source disclosure, RCE via log poisoning</td></tr>
                            <tr><td><strong>RCE via eval()</strong></td><td><span class="severity sev-critical">Critical</span></td><td>eval(), assert(), preg_replace /e</td><td>Full system compromise</td></tr>
                            <tr><td><strong>Object Deserialization</strong></td><td><span class="severity sev-critical">Critical</span></td><td>unserialize($userInput)</td><td>RCE, file write, SSRF via POP chains</td></tr>
                            <tr><td><strong>Command Injection</strong></td><td><span class="severity sev-critical">Critical</span></td><td>system(), exec(), shell_exec()</td><td>OS command execution</td></tr>
                            <tr><td><strong>SSRF</strong></td><td><span class="severity sev-high">High</span></td><td>curl, file_get_contents() with user URL</td><td>Internal network access, cloud metadata</td></tr>
                            <tr><td><strong>XSS (Stored/Reflected)</strong></td><td><span class="severity sev-high">High</span></td><td>echo $_GET['x'] without encoding</td><td>Session hijack, credential theft</td></tr>
                            <tr><td><strong>XXE</strong></td><td><span class="severity sev-high">High</span></td><td>simplexml_load_string() with external entities</td><td>File read, SSRF, DoS</td></tr>
                            <tr><td><strong>Type Juggling</strong></td><td><span class="severity sev-high">High</span></td><td>== with mixed types, strcmp bypass</td><td>Auth bypass, logic flaws</td></tr>
                            <tr><td><strong>CSRF</strong></td><td><span class="severity sev-medium">Medium</span></td><td>No token validation on state-changing forms</td><td>Unauthorized actions as victim</td></tr>
                            <tr><td><strong>Open Redirect</strong></td><td><span class="severity sev-medium">Medium</span></td><td>header("Location: ".$_GET['url'])</td><td>Phishing, token theft</td></tr>
                            <tr><td><strong>Path Traversal</strong></td><td><span class="severity sev-high">High</span></td><td>file_get_contents($_GET['file'])</td><td>Arbitrary file read</td></tr>
                            <tr><td><strong>Session Fixation</strong></td><td><span class="severity sev-medium">Medium</span></td><td>session_id() accepted from user</td><td>Session hijack</td></tr>
                            <tr><td><strong>Insecure File Upload</strong></td><td><span class="severity sev-critical">Critical</span></td><td>No MIME/extension validation</td><td>Webshell upload → RCE</td></tr>
                            <tr><td><strong>Mass Assignment</strong></td><td><span class="severity sev-high">High</span></td><td>extract($_POST), $$key = $value</td><td>Privilege escalation, data tampering</td></tr>
                        </tbody>
                    </table>

                    <h3>SQL Injection (SQLi)</h3>
                    <p>The most prevalent PHP vulnerability. Occurs when user input is concatenated directly into SQL queries without proper sanitization. PHP's old <code>mysql_*</code> functions (deprecated) and misused PDO are the most common culprits.</p>
                    <pre><code>// VULNERABLE
$id = $_GET['id'];
$result = mysql_query("SELECT * FROM users WHERE id = $id");

// SAFE — prepared statement
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);</code></pre>

                    <h3>Local File Inclusion (LFI) / Remote File Inclusion (RFI)</h3>
                    <p>PHP's <code>include()</code> and <code>require()</code> functions can load files from paths controlled by the user. LFI reads local files; RFI (requires <code>allow_url_include=On</code>) can execute remote PHP files.</p>
                    <pre><code>// VULNERABLE — classic LFI
$page = $_GET['page'];
include($page . '.php');

// Exploit: ?page=../../../../etc/passwd%00  (null byte, PHP < 5.3.4)
// Exploit: ?page=php://filter/convert.base64-encode/resource=config</code></pre>

                    <h3>Remote Code Execution (RCE)</h3>
                    <p>Multiple PHP functions execute OS commands or evaluate PHP code dynamically. Any user-controlled input reaching these functions leads to RCE.</p>
                    <pre><code>// Command injection sinks
system("ping " . $_GET['host']);       // VULNERABLE
exec("nslookup " . $_POST['domain']); // VULNERABLE

// Code evaluation sinks
eval($_POST['code']);                  // VULNERABLE
assert($_GET['test']);                 // VULNERABLE (PHP < 8)</code></pre>

                    <h3>PHP Object Deserialization</h3>
                    <p>When <code>unserialize()</code> processes attacker-controlled data, it can trigger magic methods (<code>__wakeup</code>, <code>__destruct</code>, <code>__toString</code>) on arbitrary classes, enabling Property-Oriented Programming (POP) chains.</p>
                    <pre><code>// VULNERABLE
$obj = unserialize($_COOKIE['data']);

// Attacker crafts a serialized payload that triggers:
// O:8:"UserData":1:{s:4:"file";s:11:"/etc/passwd";}</code></pre>

                    <h3>Cross-Site Scripting (XSS)</h3>
                    <p>PHP applications that echo user input without proper HTML encoding are vulnerable to XSS. <code>htmlspecialchars()</code> without the right flags or encoding context can still be bypassed.</p>
                    <pre><code>// VULNERABLE
echo "Hello " . $_GET['name'];

// SAFE
echo "Hello " . htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');</code></pre>

                    <h3>Server-Side Request Forgery (SSRF)</h3>
                    <p>PHP applications using <code>curl</code>, <code>file_get_contents()</code>, or other HTTP clients with user-supplied URLs can be tricked into making requests to internal services.</p>
                    <pre><code>// VULNERABLE
$url = $_GET['url'];
$data = file_get_contents($url);

// Exploit: ?url=http://169.254.169.254/latest/meta-data/  (AWS metadata)
// Exploit: ?url=file:///etc/passwd
// Exploit: ?url=http://internal-server:8080/admin</code></pre>

                    <h3>Type Juggling</h3>
                    <p>PHP's loose comparison operator <code>==</code> performs type coercion. This enables authentication bypasses and logic flaws especially in PHP 7 and below.</p>
                    <pre><code>// VULNERABLE auth bypass
if ($_POST['password'] == $hash) { /* login */ }

// Magic hash: if $hash = "0e1234567890"
// and MD5(input) = "0e9876543210"
// then "0e..." == "0e..." → both treated as 0 in scientific notation → TRUE</code></pre>

                    <h3>XML External Entity (XXE)</h3>
                    <p>PHP's XML parsing functions (<code>simplexml_load_string()</code>, <code>DOMDocument</code>) may process external entities if not explicitly disabled, leading to file disclosure or SSRF.</p>
                    <pre><code>// VULNERABLE
$xml = simplexml_load_string($_POST['xml']);

// Attacker sends:
// <?xml version="1.0"?>
// <!DOCTYPE foo [<!ENTITY xxe SYSTEM "file:///etc/passwd">]>
// <root>&xxe;</root>

// SAFE — disable external entities
libxml_disable_entity_loader(true);</code></pre>

                    <h3>Insecure File Upload</h3>
                    <p>Accepting file uploads without validating MIME type, extension, and content allows attackers to upload PHP webshells. Even checking the file extension client-side is trivially bypassed.</p>
                    <pre><code>// VULNERABLE
move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);

// Attack: upload shell.php → access /uploads/shell.php → RCE

// Double extension bypass: shell.php.jpg → depends on server config
// Null byte: shell.php%00.jpg (PHP < 5.3.4)</code></pre>

                    <h3>Mass Assignment via extract()</h3>
                    <p>Using <code>extract($_POST)</code> or <code>$$key = $value</code> patterns allows attackers to overwrite arbitrary PHP variables, including those controlling authentication state.</p>
                    <pre><code>// VULNERABLE
extract($_POST);  // $_POST['is_admin'] = 1 → $is_admin = 1

// Also dangerous:
foreach ($_GET as $key => $val) {
    $$key = $val;  // variable variables
}</code></pre>

                    <div class="callout callout-info">
                        <div class="callout-icon">📋</div>
                        <p><strong>Pentest Checklist:</strong> During a PHP application audit, systematically check each category above. Start with the input sources (<code>$_GET</code>, <code>$_POST</code>, <code>$_COOKIE</code>, <code>$_SERVER['HTTP_*']</code>, file uploads) and trace them to each sink type. Every article in this series covers one category in full depth.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('pre').forEach(pre => {
        pre.style.position = 'relative';
        const btn = document.createElement('button'); btn.className = 'copy-code'; btn.textContent = 'copy'; pre.appendChild(btn);
        btn.addEventListener('click', () => { const code = pre.querySelector('code')?.textContent ?? pre.textContent; navigator.clipboard.writeText(code).then(() => { btn.textContent = 'copied!'; btn.classList.add('copied'); setTimeout(() => { btn.textContent = 'copy'; btn.classList.remove('copied'); }, 2000); }); });
    });
    const readBtn = document.getElementById('read-btn'); const content = document.getElementById('article-content');
    if (readBtn && content) { let reading = false; readBtn.addEventListener('click', () => { if (!reading) { const u = new SpeechSynthesisUtterance(content.innerText); u.lang='en-US'; speechSynthesis.speak(u); reading=true; readBtn.textContent='Stop'; u.onend=()=>{reading=false;readBtn.textContent='Read Aloud';}; } else { speechSynthesis.cancel(); reading=false; readBtn.textContent='Read Aloud'; } }); }
});
</script>
@endsection
