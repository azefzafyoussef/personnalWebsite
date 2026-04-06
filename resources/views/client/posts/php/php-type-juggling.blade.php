@extends('layouts.app')
@section('title', 'PHP Type Juggling - Notes')
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
            <span class="breadcrumb-current">Type Juggling</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">PHP Type Juggling & Loose Comparisons</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>PHP Type Juggling & Loose Comparisons</h2>

            <h3>The Root Cause</h3>
            <p>PHP is a weakly typed language. The <code>==</code> operator does not compare types — it converts both operands to a common type first, then compares values. This "type juggling" behavior leads to surprising and exploitable results, especially in authentication and token validation code.</p>

            <div class="callout callout-danger">
                <div class="callout-icon">🔴</div>
                <p><strong>Critical Note:</strong> PHP 7 and below are much more vulnerable to type juggling. PHP 8 changed the behavior of <code>==</code> when comparing strings to integers, fixing many classic attacks. Always check the PHP version.</p>
            </div>

            <h3>== vs === — The Key Difference</h3>
            <pre><code>// == (loose) — performs type coercion
var_dump(0 == "a");          // TRUE  in PHP 7, FALSE in PHP 8
var_dump(0 == "");           // TRUE  in PHP 7, FALSE in PHP 8
var_dump(0 == "0");          // TRUE  in both
var_dump("1" == "01");       // TRUE  (both numeric strings)
var_dump("10" == "1e1");     // TRUE  (1e1 = 10)
var_dump(100 == "1e2");      // TRUE  (1e2 = 100)
var_dump(true == "admin");   // TRUE
var_dump(null == false);     // TRUE
var_dump(null == 0);         // TRUE

// === (strict) — checks type AND value
var_dump(0 === "a");         // FALSE — always safe
var_dump("1" === "01");      // FALSE — different strings</code></pre>

            <h3>Magic Hashes — The Classic Attack</h3>
            <p>PHP's loose comparison treats strings starting with <code>0e</code> followed by digits as scientific notation — i.e., <code>0 × 10^n = 0</code>. If two different MD5 hashes both start with <code>0e[digits]</code>, they compare as equal!</p>
            <pre><code>// "Magic" MD5 hashes — all equal 0 under ==
md5("240610708")   = "0e462097431906509019562988736854"
md5("QNKCDZO")    = "0e830400451993494058024219903391"
md5("aabg7XSs")   = "0e087386482136013740957780965295"

// SHA1 magic hashes
sha1("aaroZmOk")  = "0e66507019969427134894567494305185566735"
sha1("aaK1STfY")  = "0e76658526655756207688271159624026011393"

// Attack scenario:
$hash = "0e462097431906509019562988736854"; // stored in DB for user
if (md5($_POST['password']) == $hash) {      // loose comparison!
    // login success
}
// Send password = "QNKCDZO" → md5 = "0e830..." == "0e462..." → TRUE → bypassed!</code></pre>

            <h3>strcmp() Bypass</h3>
            <p>In PHP, <code>strcmp()</code> returns 0 if equal, non-zero if different. When an array is passed instead of a string, <code>strcmp()</code> returns <code>NULL</code> — and <code>NULL == 0</code> is true!</p>
            <pre><code>// VULNERABLE
if (strcmp($_POST['password'], $secret) == 0) {
    // logged in
}

// Attack: send password as array
// POST: password[]=anything
// strcmp(["anything"], "secret") → NULL → NULL == 0 → TRUE → bypassed!</code></pre>

            <h3>in_array() Loose Comparison</h3>
            <pre><code>// in_array() uses == by default
$whitelist = [1, 2, 3, 4];
var_dump(in_array("1 malicious string", $whitelist)); // TRUE! "1 malicious" == 1

// Also dangerous:
$blocked = ["admin", "root"];
var_dump(in_array(0, $blocked)); // TRUE in PHP 7! 0 == "admin" → TRUE

// SAFE — use strict mode (third parameter)
in_array($value, $whitelist, true); // strict comparison</code></pre>

            <h3>switch() Type Juggling</h3>
            <pre><code>// switch uses == internally
$role = $_GET['role']; // attacker sends: "0"

switch ($role) {
    case "admin":
        grant_admin();  // 0 == "admin" → TRUE in PHP 7!
        break;
    case "user":
        grant_user();
        break;
}</code></pre>

            <h3>JSON Deserialization Type Confusion</h3>
            <pre><code>// JSON decode returns typed values
$data = json_decode('{"admin": true}', true);
$data = json_decode('{"admin": 1}', true);

// Vulnerable check
if ($data['admin'] == "true") { /* true == "true" → TRUE */ }

// Attack via JSON: send {"password": true}
// if (json['password'] == $hash) → true == "0e123..." → TRUE in PHP 7</code></pre>

            <h3>Prevention</h3>
            <pre><code>// ALWAYS use strict comparison ===
if ($password === $stored_hash) { }

// ALWAYS use strict in_array
in_array($val, $arr, true);

// Use password_verify() for passwords — never raw == comparison
if (password_verify($_POST['password'], $stored_hash)) { }

// Use hash_equals() for token comparison — also timing-safe
if (hash_equals($token, $_GET['token'])) { }

// strcmp with ===
if (strcmp($a, $b) === 0) { }</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Rule:</strong> Always use <code>===</code> in security-sensitive comparisons. Never use <code>==</code> to compare passwords, tokens, hashes, or roles. Use <code>password_verify()</code> and <code>hash_equals()</code> where applicable.</p>
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
