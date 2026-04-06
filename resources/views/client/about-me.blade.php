@extends('layouts.app')

@section('title', 'Youssef Azefzaf - Cybersecurity Consultant')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');

    :root {
        --bg: #0a0e17;
        --surface: #0f1522;
        --border: #1e2d45;
        --accent: #00c2ff;
        --accent2: #7b61ff;
        --text: #c9d8ef;
        --muted: #566a85;
        --danger: #ff4d6d;
        --green: #00e5a0;
    }

    .cv-root {
        background: var(--bg);
        color: var(--text);
        font-family: 'Syne', sans-serif;
        min-height: 100vh;
        padding: 0;
    }

    .cv-root * { box-sizing: border-box; }

    /* ===== LANGUAGE SWITCHER ===== */
    .lang-switcher {
        position: fixed;
        top: 80px;
        right: 24px;
        z-index: 99;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .lang-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 8px 14px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .lang-btn:hover {
        border-color: rgba(0,194,255,0.3);
        color: var(--accent);
        background: rgba(0,194,255,0.04);
    }

    .lang-btn.active {
        border-color: rgba(0,194,255,0.4);
        color: var(--accent);
        background: rgba(0,194,255,0.08);
    }

    .lang-btn .flag { font-size: 14px; }

    /* ===== RTL support for Arabic ===== */
    .cv-root[dir="rtl"] {
        font-family: 'IBM Plex Mono', sans-serif;
    }

    .cv-root[dir="rtl"] .lang-switcher {
        right: auto;
        left: 24px;
    }

    .cv-root[dir="rtl"] .cv-contacts { flex-direction: row-reverse; }
    .cv-root[dir="rtl"] .exp-header { flex-direction: row-reverse; }
    .cv-root[dir="rtl"] .exp-bullets li { padding-left: 0; padding-right: 18px; text-align: right; }
    .cv-root[dir="rtl"] .exp-bullets li::before { left: auto; right: 0; }
    .cv-root[dir="rtl"] .cv-section-header { flex-direction: row-reverse; }
    .cv-root[dir="rtl"] .edu-item { flex-direction: row-reverse; text-align: right; }
    .cv-root[dir="rtl"] .lang-row { flex-direction: row-reverse; }
    .cv-root[dir="rtl"] .cv-title { direction: rtl; text-align: right; }

    /* ===== HERO ===== */
    .cv-hero {
        position: relative;
        overflow: hidden;
        padding: 80px 0 60px;
        border-bottom: 1px solid var(--border);
    }

    .cv-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 80% 50%, rgba(0,194,255,0.07) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 20% 30%, rgba(123,97,255,0.06) 0%, transparent 70%);
    }

    .cv-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(30,45,69,0.4) 1px, transparent 1px),
            linear-gradient(90deg, rgba(30,45,69,0.4) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
    }

    .cv-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 32px;
        position: relative;
    }

    .cv-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0,194,255,0.08);
        border: 1px solid rgba(0,194,255,0.25);
        border-radius: 4px;
        padding: 5px 12px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--accent);
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .cv-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent);
        animation: blink 1.8s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.2; }
    }

    .cv-name {
        font-size: clamp(36px, 6vw, 60px);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.02em;
        color: #fff;
        margin-bottom: 12px;
    }

    .cv-name span { color: var(--accent); }

    .cv-title {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        color: var(--muted);
        letter-spacing: 0.05em;
        margin-bottom: 28px;
    }

    .cv-contacts {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .cv-contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text);
        text-decoration: none;
        transition: color 0.2s;
    }

    .cv-contact-item:hover { color: var(--accent); }

    .cv-contact-item svg {
        width: 14px;
        height: 14px;
        opacity: 0.5;
        flex-shrink: 0;
    }

    /* ===== SECTIONS ===== */
    .cv-section { padding: 56px 0 0; }

    .cv-section-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
    }

    .cv-section-label {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--accent);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .cv-section-line { flex: 1; height: 1px; background: var(--border); }

    .cv-section-title {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 16px;
    }

    /* ===== SKILLS ===== */
    .skills-grid { display: flex; flex-wrap: wrap; gap: 10px; }

    .skill-tag {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 3px;
        border: 1px solid var(--border);
        color: var(--text);
        background: var(--surface);
        transition: all 0.2s;
        cursor: default;
    }

    .skill-tag:hover { border-color: var(--accent); color: var(--accent); background: rgba(0,194,255,0.05); }
    .skill-tag.highlight { border-color: rgba(0,194,255,0.35); color: var(--accent); background: rgba(0,194,255,0.06); }

    /* ===== EXPERIENCE ===== */
    .exp-card {
        position: relative;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 28px;
        background: var(--surface);
        margin-bottom: 20px;
        transition: border-color 0.25s;
        overflow: hidden;
    }

    .exp-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
        opacity: 0;
        transition: opacity 0.25s;
    }

    .exp-card:hover { border-color: rgba(0,194,255,0.3); }
    .exp-card:hover::before { opacity: 1; }

    .exp-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .exp-role { font-size: 16px; font-weight: 700; color: #fff; }
    .exp-period { font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--muted); white-space: nowrap; padding-top: 3px; }
    .exp-company { font-size: 13px; color: var(--accent); margin-bottom: 16px; font-weight: 500; }

    .exp-bullets { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }

    .exp-bullets li {
        font-size: 14px;
        color: var(--text);
        padding-left: 18px;
        position: relative;
        line-height: 1.6;
    }

    .exp-bullets li::before {
        content: '›';
        position: absolute;
        left: 0;
        color: var(--accent);
        font-size: 16px;
        line-height: 1.5;
    }

    /* ===== HIGHLIGHT BOX ===== */
    .highlight-box {
        background: rgba(255, 77, 109, 0.05);
        border: 1px solid rgba(255,77,109,0.2);
        border-radius: 6px;
        padding: 16px 20px;
        margin-top: 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .highlight-box-icon { font-size: 18px; flex-shrink: 0; margin-top: 2px; }
    .highlight-box p { font-size: 13px; color: var(--text); line-height: 1.7; margin: 0; }
    .highlight-box strong { color: var(--danger); }

    /* ===== EDUCATION ===== */
    .edu-item { display: flex; gap: 20px; padding: 20px 0; border-bottom: 1px solid var(--border); }
    .edu-item:last-child { border-bottom: none; }
    .edu-year { font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--muted); white-space: nowrap; min-width: 80px; padding-top: 3px; }
    .edu-degree { font-size: 15px; font-weight: 600; color: #fff; margin-bottom: 4px; }
    .edu-school { font-size: 13px; color: var(--muted); }

    /* ===== CTF ===== */
    .ctf-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }

    .ctf-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 20px;
        transition: border-color 0.2s, transform 0.2s;
    }

    .ctf-card:hover { border-color: rgba(0,229,160,0.35); transform: translateY(-2px); }
    .ctf-name { font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .ctf-result { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: var(--green); margin-bottom: 8px; }
    .ctf-desc { font-size: 13px; color: var(--muted); line-height: 1.5; }

    /* ===== LANGUAGES ===== */
    .lang-row { display: flex; align-items: center; gap: 16px; padding: 12px 0; border-bottom: 1px solid var(--border); }
    .lang-row:last-child { border-bottom: none; }
    .lang-name { font-size: 14px; font-weight: 600; color: #fff; min-width: 80px; }
    .lang-level { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: var(--muted); }
    .lang-bar { flex: 1; height: 3px; background: var(--border); border-radius: 2px; overflow: hidden; }
    .lang-bar-fill { height: 100%; border-radius: 2px; background: linear-gradient(90deg, var(--accent), var(--accent2)); }

    /* ===== FOOTER ===== */
    .cv-footer { padding: 48px 0 64px; text-align: center; color: var(--muted); font-family: 'IBM Plex Mono', monospace; font-size: 12px; }
    .cv-footer a { color: var(--accent); text-decoration: none; }

    /* ===== HIDDEN CONTENT ===== */
    .cv-lang { display: none; }
    .cv-lang.active { display: block; }

    @media (max-width: 640px) {
        .cv-hero { padding: 48px 0 40px; }
        .exp-header { flex-direction: column; gap: 4px; }
        .edu-item { flex-direction: column; gap: 6px; }
        .lang-switcher { top: auto; bottom: 24px; right: 16px; flex-direction: row; }
    }
</style>

{{-- ===== LANGUAGE SWITCHER ===== --}}
<div class="lang-switcher">
    <button class="lang-btn active" onclick="switchLang('en')" id="btn-en">
        <span class="flag">🇬🇧</span> EN
    </button>
    <button class="lang-btn" onclick="switchLang('fr')" id="btn-fr">
        <span class="flag">🇫🇷</span> FR
    </button>
    <button class="lang-btn" onclick="switchLang('ar')" id="btn-ar">
        <span class="flag">🇲🇦</span> AR
    </button>
</div>

<div class="cv-root" id="cv-root">

    {{-- ===== HERO (shared) ===== --}}
    <div class="cv-hero">
        <div class="cv-hero-grid"></div>
        <div class="cv-container">
            <div class="cv-badge" id="cv-badge-text">About Me</div>

            <h1 class="cv-name">
                Youssef <span>Azefzaf</span>
            </h1>

            <p class="cv-title" id="cv-title-text">CYBERSECURITY CONSULTANT · PENETRATION TESTING & VULNERABILITY RESEARCH</p>

            <div class="cv-contacts">
                <a href="mailto:azefzafyossef@gmail.com" class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                    azefzafyossef@gmail.com
                </a>
                <a href="https://linkedin.com/in/youssef-azefzaf" target="_blank" class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                    youssef-azefzaf
                </a>
                <span class="cv-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    Permis B
                </span>
            </div>
        </div>
    </div>

    {{-- ===================== ENGLISH ===================== --}}
    <div class="cv-lang active" id="lang-en">
    <div class="cv-container">

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">01 // Skills</span><div class="cv-section-line"></div></div>
            <div class="cv-section-title">Technical Skills</div>
            <div style="display:flex;flex-direction:column;gap:20px;">
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Penetration Testing</div>
                    <div class="skills-grid">
                        <span class="skill-tag highlight">Web</span><span class="skill-tag highlight">Linux</span>
                        <span class="skill-tag highlight">Active Directory</span><span class="skill-tag highlight">Windows</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Offensive Techniques</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Privilege Escalation</span><span class="skill-tag">Lateral Movement</span>
                        <span class="skill-tag">Persistence</span><span class="skill-tag">Exfiltration</span>
                        <span class="skill-tag">EDR/AV Bypass</span><span class="skill-tag">Fuzzing</span>
                        <span class="skill-tag">Exploit Dev</span><span class="skill-tag">PoC</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Tools & Frameworks</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Metasploit</span><span class="skill-tag">Burp Suite</span>
                        <span class="skill-tag">sqlmap</span><span class="skill-tag">Impacket</span>
                        <span class="skill-tag">BloodHound</span><span class="skill-tag">Mimikatz</span>
                        <span class="skill-tag">Enum4Linux</span><span class="skill-tag">Splunk (SIEM)</span><span class="skill-tag">Docker</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Scripting & Other</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Python</span><span class="skill-tag">Bash</span>
                        <span class="skill-tag">PHP / Laravel</span><span class="skill-tag">ISO 27001 (ISMS)</span>
                        <span class="skill-tag">MySQL</span><span class="skill-tag">Oracle DB</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">02 // Experience</span><div class="cv-section-line"></div></div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">0-Day Research / Penetration Testing</div>
                    <div class="exp-period">Apr. 2025 — Sept. 2025</div>
                </div>
                <div class="exp-company">Fenrisk · Paris, France &nbsp;·&nbsp; Final Year Internship (6 months)</div>
                <ul class="exp-bullets">
                    <li>Research and identification of 0-day vulnerabilities</li>
                    <li>Design of isolated test environments</li>
                    <li>Development of exploitation scripts</li>
                    <li>Creation of <strong style="color:#fff">Atlasscan</strong> for vulnerable version detection</li>
                    <li>Active participation in penetration tests</li>
                </ul>
                <div class="highlight-box">
                    <div class="highlight-box-icon">🔴</div>
                    <p><strong>0-DAY discovered</strong>: Identified an RCE vulnerability in a major technology — technical article publication scheduled for <strong>April 8th</strong>.</p>
                </div>
            </div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">Fullstack Web Developer (PHP / Laravel)</div>
                    <div class="exp-period">Aug. 2022 — Jun. 2023</div>
                </div>
                <div class="exp-company">E-solution · Casablanca, Morocco &nbsp;·&nbsp; Full-time (11 months)</div>
                <ul class="exp-bullets">
                    <li>Development and maintenance of web applications</li>
                    <li>Stack: PHP, Laravel, MySQL</li>
                </ul>
            </div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">Web & Security Audit (Project)</div>
                    <div class="exp-period">125+ hours</div>
                </div>
                <div class="exp-company">University of Rouen · France</div>
                <ul class="exp-bullets">
                    <li>Application penetration testing</li>
                    <li>System configuration audit</li>
                    <li>Bluetooth attacks</li>
                    <li>Technical report writing</li>
                    <li>Client meetings</li>
                </ul>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">03 // CTF & Challenges</span><div class="cv-section-line"></div></div>
            <div class="ctf-grid">
                <div class="ctf-card"><div class="ctf-name">CTF Jeanne d'Hack</div><div class="ctf-result">🥇 1st individual ranking · 7,000+ pts</div><div class="ctf-desc">Team ranked 8th. 2023–2025.</div></div>
                <div class="ctf-card"><div class="ctf-name">TryHackMe</div><div class="ctf-result">Top 3% · 12,000+ pts</div><div class="ctf-desc">PWN · Web · Reverse · Crypto · OSINT · Windows</div></div>
                <div class="ctf-card"><div class="ctf-name">Root-Me</div><div class="ctf-result">4,000+ pts · Rank: Hacker</div><div class="ctf-desc">Web · System · Cryptography</div></div>
                <div class="ctf-card"><div class="ctf-name">HackTheBox</div><div class="ctf-result">Rank: Hacker</div><div class="ctf-desc">Active Directory · Linux · Windows</div></div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">04 // Education</span><div class="cv-section-line"></div></div>
            <div class="edu-item"><div class="edu-year">2023 – 2025</div><div><div class="edu-degree">Master's — Information Systems Security</div><div class="edu-school">University of Rouen · France</div></div></div>
            <div class="edu-item"><div class="edu-year">2020 – 2022</div><div><div class="edu-degree">Master's — Computer Science & Internet Engineering</div><div class="edu-school">Hassan 2 University · Morocco</div></div></div>
            <div class="edu-item"><div class="edu-year">2017 – 2020</div><div><div class="edu-degree">Bachelor's — Mathematics & Computer Science (Database option)</div><div class="edu-school">Hassan 2 University · Morocco</div></div></div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">05 // Languages</span><div class="cv-section-line"></div></div>
            <div class="lang-row"><div class="lang-name">French</div><div class="lang-level">Fluent</div><div class="lang-bar"><div class="lang-bar-fill" style="width:90%"></div></div></div>
            <div class="lang-row"><div class="lang-name">English</div><div class="lang-level">Fluent</div><div class="lang-bar"><div class="lang-bar-fill" style="width:85%"></div></div></div>
            <div class="lang-row"><div class="lang-name">Arabic</div><div class="lang-level">Native</div><div class="lang-bar"><div class="lang-bar-fill" style="width:100%"></div></div></div>
        </div>

    </div>
    </div>{{-- /lang-en --}}

    {{-- ===================== FRENCH ===================== --}}
    <div class="cv-lang" id="lang-fr">
    <div class="cv-container">

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">01 // Compétences</span><div class="cv-section-line"></div></div>
            <div class="cv-section-title">Compétences Techniques</div>
            <div style="display:flex;flex-direction:column;gap:20px;">
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Tests d'intrusion</div>
                    <div class="skills-grid">
                        <span class="skill-tag highlight">Web</span><span class="skill-tag highlight">Linux</span>
                        <span class="skill-tag highlight">Active Directory</span><span class="skill-tag highlight">Windows</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Techniques Offensives</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Escalade de privilèges</span><span class="skill-tag">Mouvement latéral</span>
                        <span class="skill-tag">Persistence</span><span class="skill-tag">Exfiltration</span>
                        <span class="skill-tag">Bypass EDR/AV</span><span class="skill-tag">Fuzzing</span>
                        <span class="skill-tag">Exploit Dev</span><span class="skill-tag">PoC</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Outils & Frameworks</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Metasploit</span><span class="skill-tag">Burp Suite</span>
                        <span class="skill-tag">sqlmap</span><span class="skill-tag">Impacket</span>
                        <span class="skill-tag">BloodHound</span><span class="skill-tag">Mimikatz</span>
                        <span class="skill-tag">Enum4Linux</span><span class="skill-tag">Splunk (SIEM)</span><span class="skill-tag">Docker</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Scripting & Autres</div>
                    <div class="skills-grid">
                        <span class="skill-tag">Python</span><span class="skill-tag">Bash</span>
                        <span class="skill-tag">PHP / Laravel</span><span class="skill-tag">ISO 27001 (SMSI)</span>
                        <span class="skill-tag">MySQL</span><span class="skill-tag">Oracle BDD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">02 // Expériences</span><div class="cv-section-line"></div></div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">Recherche des 0-Day / Test d'intrusion</div>
                    <div class="exp-period">Avr. 2025 — Sept. 2025</div>
                </div>
                <div class="exp-company">Fenrisk · Paris, France &nbsp;·&nbsp; Stage PFE (6 mois)</div>
                <ul class="exp-bullets">
                    <li>Recherche et identification de vulnérabilités 0-day</li>
                    <li>Conception d'environnements de test isolés</li>
                    <li>Développement de scripts d'exploitation</li>
                    <li>Création d'<strong style="color:#fff">Atlasscan</strong> pour la détection de versions vulnérables</li>
                    <li>Participation active à des tests d'intrusion</li>
                </ul>
                <div class="highlight-box">
                    <div class="highlight-box-icon">🔴</div>
                    <p><strong>0-DAY découverte</strong> : Identification d'une vulnérabilité RCE dans une technologie majeure — publication d'un article technique prévue le <strong>8 Avril</strong>.</p>
                </div>
            </div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">Développeur Web Fullstack (PHP / Laravel)</div>
                    <div class="exp-period">Août 2022 — Juin 2023</div>
                </div>
                <div class="exp-company">E-solution · Casablanca, Maroc &nbsp;·&nbsp; CDI (11 mois)</div>
                <ul class="exp-bullets">
                    <li>Développement et maintenance d'applications web</li>
                    <li>Stack : PHP, Laravel, MySQL</li>
                </ul>
            </div>
            <div class="exp-card">
                <div class="exp-header">
                    <div class="exp-role">Audit Web & Sécurité (Projet)</div>
                    <div class="exp-period">125+ heures</div>
                </div>
                <div class="exp-company">Université de Rouen · France</div>
                <ul class="exp-bullets">
                    <li>Tests d'intrusion applicatifs</li>
                    <li>Audit de configuration système</li>
                    <li>Attaques Bluetooth</li>
                    <li>Rédaction de rapports techniques</li>
                    <li>Réunion avec les clients</li>
                </ul>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">03 // CTF & Challenges</span><div class="cv-section-line"></div></div>
            <div class="ctf-grid">
                <div class="ctf-card"><div class="ctf-name">CTF Jeanne d'Hack</div><div class="ctf-result">🥇 1er classement individuel · 7 000+ pts</div><div class="ctf-desc">Équipe classée 8ème. 2023–2025.</div></div>
                <div class="ctf-card"><div class="ctf-name">TryHackMe</div><div class="ctf-result">Top 3% · 12 000+ pts</div><div class="ctf-desc">PWN · Web · Reverse · Crypto · OSINT · Windows</div></div>
                <div class="ctf-card"><div class="ctf-name">Root-Me</div><div class="ctf-result">4 000+ pts · Rang : Hacker</div><div class="ctf-desc">Web · Système · Cryptographie</div></div>
                <div class="ctf-card"><div class="ctf-name">HackTheBox</div><div class="ctf-result">Rang : Hacker</div><div class="ctf-desc">Active Directory · Linux · Windows</div></div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">04 // Formations</span><div class="cv-section-line"></div></div>
            <div class="edu-item"><div class="edu-year">2023 – 2025</div><div><div class="edu-degree">Master Sécurité des systèmes informatiques</div><div class="edu-school">Université de Rouen · France</div></div></div>
            <div class="edu-item"><div class="edu-year">2020 – 2022</div><div><div class="edu-degree">Master Ingénierie informatique et internet</div><div class="edu-school">Université Hassan 2 · Maroc</div></div></div>
            <div class="edu-item"><div class="edu-year">2017 – 2020</div><div><div class="edu-degree">Licence Fondamentale Sciences Mathématiques & Informatique</div><div class="edu-school">Option Base de données · Université Hassan 2 · Maroc</div></div></div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header"><span class="cv-section-label">05 // Langues</span><div class="cv-section-line"></div></div>
            <div class="lang-row"><div class="lang-name">Français</div><div class="lang-level">Courant</div><div class="lang-bar"><div class="lang-bar-fill" style="width:90%"></div></div></div>
            <div class="lang-row"><div class="lang-name">Anglais</div><div class="lang-level">Courant</div><div class="lang-bar"><div class="lang-bar-fill" style="width:85%"></div></div></div>
            <div class="lang-row"><div class="lang-name">Arabe</div><div class="lang-level">Maternelle</div><div class="lang-bar"><div class="lang-bar-fill" style="width:100%"></div></div></div>
        </div>

    </div>
    </div>{{-- /lang-fr --}}

    {{-- ===================== ARABIC ===================== --}}
    <div class="cv-lang" id="lang-ar">
    <div class="cv-container" dir="rtl" style="text-align:right;">

        <div class="cv-section">
            <div class="cv-section-header" style="flex-direction:row-reverse;"><span class="cv-section-label">٠١ // المهارات</span><div class="cv-section-line"></div></div>
            <div class="cv-section-title">المهارات التقنية</div>
            <div style="display:flex;flex-direction:column;gap:20px;">
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">اختبار الاختراق</div>
                    <div class="skills-grid" style="justify-content:flex-end;">
                        <span class="skill-tag highlight">Web</span><span class="skill-tag highlight">Linux</span>
                        <span class="skill-tag highlight">Active Directory</span><span class="skill-tag highlight">Windows</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">تقنيات الهجوم</div>
                    <div class="skills-grid" style="justify-content:flex-end;">
                        <span class="skill-tag">رفع الامتيازات</span><span class="skill-tag">الحركة الجانبية</span>
                        <span class="skill-tag">الثبات</span><span class="skill-tag">تسريب البيانات</span>
                        <span class="skill-tag">تجاوز EDR/AV</span><span class="skill-tag">Fuzzing</span>
                        <span class="skill-tag">تطوير الاستغلال</span><span class="skill-tag">PoC</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">الأدوات والأطر</div>
                    <div class="skills-grid" style="justify-content:flex-end;">
                        <span class="skill-tag">Metasploit</span><span class="skill-tag">Burp Suite</span>
                        <span class="skill-tag">sqlmap</span><span class="skill-tag">Impacket</span>
                        <span class="skill-tag">BloodHound</span><span class="skill-tag">Mimikatz</span>
                        <span class="skill-tag">Enum4Linux</span><span class="skill-tag">Splunk (SIEM)</span><span class="skill-tag">Docker</span>
                    </div>
                </div>
                <div>
                    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">البرمجة وأخرى</div>
                    <div class="skills-grid" style="justify-content:flex-end;">
                        <span class="skill-tag">Python</span><span class="skill-tag">Bash</span>
                        <span class="skill-tag">PHP / Laravel</span><span class="skill-tag">ISO 27001</span>
                        <span class="skill-tag">MySQL</span><span class="skill-tag">Oracle BDD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header" style="flex-direction:row-reverse;"><span class="cv-section-label">٠٢ // الخبرات</span><div class="cv-section-line"></div></div>
            <div class="exp-card" style="text-align:right;">
                <div class="exp-header" style="flex-direction:row-reverse;">
                    <div class="exp-role">بحث عن ثغرات 0-Day / اختبار الاختراق</div>
                    <div class="exp-period">أبر. 2025 — سبت. 2025</div>
                </div>
                <div class="exp-company">Fenrisk · باريس، فرنسا &nbsp;·&nbsp; تدريب نهاية الدراسة (6 أشهر)</div>
                <ul class="exp-bullets" style="padding-right:18px;padding-left:0;">
                    <li style="padding-right:18px;padding-left:0;">بحث وتحديد ثغرات 0-day</li>
                    <li style="padding-right:18px;padding-left:0;">تصميم بيئات اختبار معزولة</li>
                    <li style="padding-right:18px;padding-left:0;">تطوير سكريبتات الاستغلال</li>
                    <li style="padding-right:18px;padding-left:0;">إنشاء أداة <strong style="color:#fff">Atlasscan</strong> لاكتشاف الإصدارات الضعيفة</li>
                    <li style="padding-right:18px;padding-left:0;">المشاركة الفعّالة في اختبارات الاختراق</li>
                </ul>
                <div class="highlight-box">
                    <div class="highlight-box-icon">🔴</div>
                    <p style="text-align:right;"><strong>اكتشاف ثغرة 0-DAY</strong> : تحديد ثغرة تنفيذ كود عن بُعد (RCE) في تقنية كبيرة — نشر مقال تقني مقرر في <strong>8 أبريل</strong>.</p>
                </div>
            </div>
            <div class="exp-card" style="text-align:right;">
                <div class="exp-header" style="flex-direction:row-reverse;">
                    <div class="exp-role">مطوّر ويب (PHP / Laravel)</div>
                    <div class="exp-period">أغس. 2022 — يون. 2023</div>
                </div>
                <div class="exp-company">E-solution · الدار البيضاء، المغرب &nbsp;·&nbsp; عقد دائم (11 شهراً)</div>
                <ul class="exp-bullets" style="padding-right:18px;padding-left:0;">
                    <li style="padding-right:18px;padding-left:0;">تطوير وصيانة تطبيقات الويب</li>
                    <li style="padding-right:18px;padding-left:0;">Stack: PHP, Laravel, MySQL</li>
                </ul>
            </div>
            <div class="exp-card" style="text-align:right;">
                <div class="exp-header" style="flex-direction:row-reverse;">
                    <div class="exp-role">تدقيق أمني (مشروع)</div>
                    <div class="exp-period">+125 ساعة</div>
                </div>
                <div class="exp-company">جامعة روان · فرنسا</div>
                <ul class="exp-bullets" style="padding-right:18px;padding-left:0;">
                    <li style="padding-right:18px;padding-left:0;">اختبار اختراق التطبيقات</li>
                    <li style="padding-right:18px;padding-left:0;">تدقيق إعدادات الأنظمة</li>
                    <li style="padding-right:18px;padding-left:0;">هجمات Bluetooth</li>
                    <li style="padding-right:18px;padding-left:0;">كتابة تقارير تقنية</li>
                    <li style="padding-right:18px;padding-left:0;">اجتماعات مع العملاء</li>
                </ul>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header" style="flex-direction:row-reverse;"><span class="cv-section-label">٠٣ // CTF & تحديات</span><div class="cv-section-line"></div></div>
            <div class="ctf-grid">
                <div class="ctf-card" style="text-align:right;"><div class="ctf-name">CTF Jeanne d'Hack</div><div class="ctf-result">🥇 المرتبة الأولى · +7,000 نقطة</div><div class="ctf-desc">الفريق في المرتبة 8. 2023–2025.</div></div>
                <div class="ctf-card" style="text-align:right;"><div class="ctf-name">TryHackMe</div><div class="ctf-result">أفضل 3% · +12,000 نقطة</div><div class="ctf-desc">PWN · Web · Reverse · Crypto · OSINT</div></div>
                <div class="ctf-card" style="text-align:right;"><div class="ctf-name">Root-Me</div><div class="ctf-result">+4,000 نقطة · Hacker</div><div class="ctf-desc">ويب · أنظمة · تشفير</div></div>
                <div class="ctf-card" style="text-align:right;"><div class="ctf-name">HackTheBox</div><div class="ctf-result">Rank: Hacker</div><div class="ctf-desc">Active Directory · Linux · Windows</div></div>
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header" style="flex-direction:row-reverse;"><span class="cv-section-label">٠٤ // التعليم</span><div class="cv-section-line"></div></div>
            <div class="edu-item" style="flex-direction:row-reverse;text-align:right;"><div class="edu-year">2023 – 2025</div><div><div class="edu-degree">ماجستير أمن أنظمة المعلومات</div><div class="edu-school">جامعة روان · فرنسا</div></div></div>
            <div class="edu-item" style="flex-direction:row-reverse;text-align:right;"><div class="edu-year">2020 – 2022</div><div><div class="edu-degree">ماجستير هندسة الحاسوب والإنترنت</div><div class="edu-school">جامعة الحسن الثاني · المغرب</div></div></div>
            <div class="edu-item" style="flex-direction:row-reverse;text-align:right;"><div class="edu-year">2017 – 2020</div><div><div class="edu-degree">إجازة في الرياضيات والمعلوماتية (تخصص قواعد البيانات)</div><div class="edu-school">جامعة الحسن الثاني · المغرب</div></div></div>
        </div>

        <div class="cv-section">
            <div class="cv-section-header" style="flex-direction:row-reverse;"><span class="cv-section-label">٠٥ // اللغات</span><div class="cv-section-line"></div></div>
            <div class="lang-row" style="flex-direction:row-reverse;"><div class="lang-name">الفرنسية</div><div class="lang-level">طلاقة</div><div class="lang-bar"><div class="lang-bar-fill" style="width:90%"></div></div></div>
            <div class="lang-row" style="flex-direction:row-reverse;"><div class="lang-name">الإنجليزية</div><div class="lang-level">طلاقة</div><div class="lang-bar"><div class="lang-bar-fill" style="width:85%"></div></div></div>
            <div class="lang-row" style="flex-direction:row-reverse;"><div class="lang-name">العربية</div><div class="lang-level">لغة أم</div><div class="lang-bar"><div class="lang-bar-fill" style="width:100%"></div></div></div>
        </div>

    </div>
    </div>{{-- /lang-ar --}}

    <div class="cv-footer cv-container">
        <p>
            📧 <a href="mailto:azefzafyossef@gmail.com">azefzafyossef@gmail.com</a>
            &nbsp;·&nbsp;
            🔗 <a href="https://linkedin.com/in/youssef-azefzaf" target="_blank">LinkedIn</a>
        </p>
    </div>

</div>{{-- /cv-root --}}

@endsection

@section('scripts')
<script>
const titles = {
    en: 'CYBERSECURITY CONSULTANT · PENETRATION TESTING & VULNERABILITY RESEARCH',
    fr: 'CONSULTANT EN CYBERSÉCURITÉ · TESTS D\'INTRUSION & RECHERCHE DE VULNÉRABILITÉS',
    ar: 'مستشار أمن سيبراني · اختبار الاختراق وبحث الثغرات'
};

const badges = {
    en: 'About Me',
    fr: 'À Propos',
    ar: 'نبذة عني'
};

function switchLang(lang) {
    // Hide all
    document.querySelectorAll('.cv-lang').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));

    // Show selected
    document.getElementById('lang-' + lang).classList.add('active');
    document.getElementById('btn-' + lang).classList.add('active');

    // Update hero text
    document.getElementById('cv-title-text').textContent = titles[lang];
    document.getElementById('cv-badge-text').textContent = badges[lang];

    // RTL for Arabic
    const root = document.getElementById('cv-root');
    if (lang === 'ar') {
        root.setAttribute('dir', 'rtl');
        root.style.fontFamily = "'Syne', 'Segoe UI', sans-serif";
    } else {
        root.removeAttribute('dir');
        root.style.fontFamily = "'Syne', sans-serif";
    }

    // Save preference
    localStorage.setItem('cv-lang', lang);
}

document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('cv-lang') || 'en';
    switchLang(saved);
});
</script>
@endsection
