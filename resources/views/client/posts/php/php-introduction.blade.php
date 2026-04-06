@extends('layouts.app')
@section('title', 'Introduction to PHP Security - Notes')
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
    .callout-success{background:rgba(0,229,160,0.05);border:1px solid rgba(0,229,160,0.25);} .callout-success p{color:#7ff3cd;} .callout-success strong{color:var(--green);}
    .callout-danger{background:rgba(255,77,109,0.05);border:1px solid rgba(255,77,109,0.25);} .callout-danger p{color:#ffb3c0;} .callout-danger strong{color:var(--red);}
    @media(max-width:768px){.post-body{padding:24px 16px 60px;}.article-card-inner{padding:24px;}.post-topbar-inner{padding:0 16px;}}
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
                <span class="breadcrumb-current">Introduction to PHP Security</span>
            </nav>
        </div>
    </div>

    <div class="post-body">
        <div class="article-card">
            <div class="article-card-inner">
                <div><span class="cat-badge">PHP Security</span></div>
                <h1 class="article-title">Introduction to PHP Security</h1>
                <div class="meta-row">
                    <div class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Youssef
                    </div>
                    <div class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ now()->format('d M Y') }}
                    </div>
                    <div class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        0 views
                    </div>
                </div>

                <button id="read-btn" class="read-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                    Read Aloud
                </button>

                <div class="article-prose" id="article-content">

                    <h2>Introduction to PHP Security</h2>

                    <h3>What is PHP?</h3>
                    <p>PHP (Hypertext Preprocessor) is a server-side scripting language designed primarily for web development. First released in 1994, it powers an enormous portion of the web — including WordPress, Drupal, Joomla, and countless custom applications. This massive adoption makes PHP applications a prime and historically rich attack surface.</p>
                    <p>PHP is interpreted, weakly typed, and runs with direct access to the filesystem, database, and system commands. These characteristics, while flexible for developers, introduce significant security risks when code is written carelessly.</p>

                    <h3>PHP Execution Model</h3>
                    <p>Understanding how PHP executes is fundamental to understanding its attack surface:</p>
                    <ul>
                        <li>PHP receives a request from a web server (Apache, Nginx, etc.)</li>
                        <li>The interpreter parses and executes the PHP file</li>
                        <li>User input flows through <code>$_GET</code>, <code>$_POST</code>, <code>$_COOKIE</code>, <code>$_SERVER</code>, <code>$_FILES</code></li>
                        <li>Output is sent back as HTML to the client</li>
                        <li>The process runs with the web server's OS user privileges</li>
                    </ul>

                    <div class="callout callout-danger">
                        <div class="callout-icon">🔴</div>
                        <p><strong>Key Risk:</strong> PHP runs with OS-level privileges. If an attacker achieves Remote Code Execution in a PHP application, they control the machine at the web server user level — often leading to full system compromise.</p>
                    </div>

                    <h3>Dangerous Functions</h3>
                    <p>PHP exposes a rich set of functions that are dangerous when fed with user-controlled input. These are the functions every security researcher should know by heart:</p>

                    <pre><code>// Command execution
system()       exec()        passthru()
shell_exec()   popen()       proc_open()
`backtick`

// Code evaluation
eval()         assert()      preg_replace()  // with /e flag (deprecated)
call_user_func()   call_user_func_array()
create_function()  // deprecated but still encountered

// File operations
include()      require()     include_once()   require_once()
file_get_contents()  file_put_contents()  readfile()
fopen()        unlink()      rename()

// Serialization
unserialize()  // extremely dangerous with user input

// Network
curl_exec()    file_get_contents()  // with URLs enabled
fsockopen()    stream_socket_client()</code></pre>

                    <h3>Unsafe Defaults</h3>
                    <p>Older PHP configurations (and many production servers still running them) have dangerous default settings:</p>
                    <ul>
                        <li><strong>register_globals</strong> (removed in PHP 5.4) — automatically created variables from GET/POST</li>
                        <li><strong>magic_quotes_gpc</strong> (removed in PHP 5.4) — false sense of security</li>
                        <li><strong>allow_url_include</strong> — enables RFI attacks</li>
                        <li><strong>allow_url_fopen</strong> — enables SSRF via file functions</li>
                        <li><strong>display_errors = On</strong> — leaks stack traces and paths</li>
                        <li><strong>open_basedir</strong> not set — no filesystem restriction</li>
                        <li><strong>disable_functions</strong> empty — all dangerous functions available</li>
                    </ul>

                    <pre><code>; php.ini - dangerous configuration
display_errors = On
allow_url_include = On
allow_url_fopen = On
; open_basedir =          ; not set = no restriction
; disable_functions =     ; not set = everything allowed</code></pre>

                    <h3>The Weak Type System</h3>
                    <p>PHP's type system is notoriously loose. The <code>==</code> operator performs type coercion before comparison, which leads to a class of vulnerabilities known as <strong>Type Juggling</strong>. This is one of PHP's most unique and dangerous quirks from a security perspective.</p>

                    <pre><code>// PHP loose comparison surprises
var_dump(0 == "a");         // true (in PHP < 8)
var_dump("1" == "01");      // true
var_dump("10" == "1e1");    // true
var_dump(100 == "1e2");     // true
var_dump("0e1234" == "0e5678"); // true — magic hash collision!</code></pre>

                    <div class="callout callout-warning">
                        <div class="callout-icon">⚠️</div>
                        <p><strong>PHP 8 Note:</strong> PHP 8 changed the behavior of <code>==</code> when comparing strings to numbers. Many type juggling attacks that worked in PHP 7 and below no longer work in PHP 8. Always check the PHP version when testing.</p>
                    </div>

                    <h3>Why PHP is a Prime Attack Surface</h3>
                    <ul>
                        <li><strong>Massive deployment</strong> — millions of outdated PHP applications running in production</li>
                        <li><strong>Historical baggage</strong> — decades of insecure code patterns taught in tutorials</li>
                        <li><strong>Flexible include system</strong> — LFI/RFI vulnerabilities are unique to PHP</li>
                        <li><strong>Complex serialization</strong> — PHP object deserialization is notoriously exploitable</li>
                        <li><strong>Shared hosting</strong> — misconfigured environments everywhere</li>
                        <li><strong>CMS ecosystem</strong> — WordPress plugins alone represent thousands of potential entry points</li>
                    </ul>

                    <h3>PHP Version Landscape</h3>
                    <p>As of 2025, a significant portion of PHP deployments still run unsupported versions. PHP 5.x reached end-of-life in December 2018, yet remains in production on many servers. PHP 7.x EOL was November 2022. Only PHP 8.1, 8.2, 8.3, and 8.4 receive active support.</p>

                    <div class="callout callout-info">
                        <div class="callout-icon">📋</div>
                        <p><strong>During a pentest:</strong> Always identify the PHP version first. Running <code>phpinfo()</code> exposure, error messages, or HTTP headers (<code>X-Powered-By: PHP/7.x</code>) can reveal it. Old versions mean known CVEs you can leverage directly.</p>
                    </div>

                    <h3>What's Next</h3>
                    <p>This introduction sets the foundation. The following articles dive deep into each vulnerability class:</p>
                    <ul>
                        <li>Exhaustive list of PHP vulnerabilities</li>
                        <li>SQL Injection in PHP</li>
                        <li>LFI / RFI — Local and Remote File Inclusion</li>
                        <li>PHP Object Deserialization & POP Chains</li>
                        <li>Type Juggling & Loose Comparisons</li>
                        <li>RCE via dangerous PHP functions</li>
                        <li>XSS in PHP applications</li>
                        <li>SSRF in PHP</li>
                    </ul>

                    <div class="callout callout-success">
                        <div class="callout-icon">✅</div>
                        <p><strong>Mindset:</strong> When auditing a PHP application, always follow the data. Trace every user-controlled input from entry point (<code>$_GET</code>, <code>$_POST</code>, headers, cookies) through all transformations, to every sink (function that acts on it). That path is where vulnerabilities live.</p>
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
        const btn = document.createElement('button');
        btn.className = 'copy-code'; btn.textContent = 'copy';
        pre.appendChild(btn);
        btn.addEventListener('click', () => {
            const code = pre.querySelector('code')?.textContent ?? pre.textContent;
            navigator.clipboard.writeText(code).then(() => {
                btn.textContent = 'copied!'; btn.classList.add('copied');
                setTimeout(() => { btn.textContent = 'copy'; btn.classList.remove('copied'); }, 2000);
            });
        });
    });
    const readBtn = document.getElementById('read-btn');
    const content = document.getElementById('article-content');
    if (readBtn && content) {
        let reading = false;
        readBtn.addEventListener('click', () => {
            if (!reading) {
                const u = new SpeechSynthesisUtterance(content.innerText);
                u.lang = 'en-US'; speechSynthesis.speak(u); reading = true;
                readBtn.textContent = 'Stop';
                u.onend = () => { reading = false; readBtn.textContent = 'Read Aloud'; };
            } else { speechSynthesis.cancel(); reading = false; readBtn.textContent = 'Read Aloud'; }
        });
    }
});
</script>
@endsection
