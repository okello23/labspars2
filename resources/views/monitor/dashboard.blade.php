<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Facility Deployment Monitor</title>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0a0c10;
    --surface: #10141c;
    --surface2: #161b26;
    --border: #1e2535;
    --text: #c9d1e0;
    --muted: #4a5568;
    --accent: #3b82f6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --running: #8b5cf6;
    --mono: 'JetBrains Mono', monospace;
    --sans: 'Syne', sans-serif;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: var(--sans);
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* Grid texture */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(59,130,246,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(59,130,246,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
  }

  .wrapper { position: relative; z-index: 1; }

  /* ── Header ── */
  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 32px;
    border-bottom: 1px solid var(--border);
    background: rgba(10,12,16,0.8);
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .logo-icon {
    width: 36px; height: 36px;
    background: var(--accent);
    border-radius: 8px;
    display: grid;
    place-items: center;
    font-size: 18px;
  }

  .logo-text { font-size: 16px; font-weight: 700; letter-spacing: -0.3px; }
  .logo-sub { font-size: 11px; color: var(--muted); font-family: var(--mono); margin-top: 1px; }

  .header-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .live-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: var(--mono);
    font-size: 11px;
    color: var(--success);
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.2);
    padding: 4px 10px;
    border-radius: 20px;
  }

  .live-dot {
    width: 6px; height: 6px;
    background: var(--success);
    border-radius: 50%;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
  }

  .last-updated {
    font-family: var(--mono);
    font-size: 11px;
    color: var(--muted);
  }

  /* ── Main layout ── */
  main { padding: 32px; max-width: 1400px; margin: 0 auto; }

  /* ── Summary cards ── */
  .summary-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
  }

  .stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px 24px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.2s;
  }

  .stat-card:hover { border-color: rgba(59,130,246,0.3); }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
  }

  .stat-card.total::before { background: var(--accent); }
  .stat-card.success::before { background: var(--success); }
  .stat-card.failed::before { background: var(--danger); }
  .stat-card.running::before { background: var(--running); }

  .stat-label {
    font-family: var(--mono);
    font-size: 10px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 10px;
  }

  .stat-value {
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -2px;
    line-height: 1;
  }

  .stat-card.total .stat-value { color: var(--accent); }
  .stat-card.success .stat-value { color: var(--success); }
  .stat-card.failed .stat-value { color: var(--danger); }
  .stat-card.running .stat-value { color: var(--running); }

  .stat-sub {
    font-family: var(--mono);
    font-size: 11px;
    color: var(--muted);
    margin-top: 6px;
  }

  /* ── Section title ── */
  .section-title {
    font-size: 11px;
    font-family: var(--mono);
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
  }

  /* ── Facility grid ── */
  .facility-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    margin-bottom: 40px;
  }

  .facility-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    transition: all 0.2s;
    cursor: pointer;
  }

  .facility-card:hover {
    border-color: rgba(59,130,246,0.3);
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
  }

  .facility-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .facility-name {
    font-size: 14px;
    font-weight: 700;
    letter-spacing: -0.3px;
  }

  .facility-label {
    font-family: var(--mono);
    font-size: 10px;
    color: var(--muted);
    margin-top: 3px;
  }

  .runner-status {
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: var(--mono);
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 20px;
  }

  .runner-status.online {
    color: var(--success);
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.2);
  }

  .runner-status.offline {
    color: var(--danger);
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.2);
  }

  .runner-status.idle {
    color: var(--muted);
    background: rgba(74,85,104,0.2);
    border: 1px solid rgba(74,85,104,0.3);
  }

  .runner-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
  .runner-status.online .runner-dot { animation: pulse 2s infinite; }

  .facility-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 16px;
  }

  .fstat {
    background: var(--surface2);
    border-radius: 8px;
    padding: 10px;
    text-align: center;
  }

  .fstat-val {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -1px;
  }

  .fstat-val.s { color: var(--success); }
  .fstat-val.f { color: var(--danger); }
  .fstat-val.t { color: var(--text); }

  .fstat-lbl {
    font-family: var(--mono);
    font-size: 9px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--muted);
    margin-top: 2px;
  }

  .last-deploy {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--surface2);
    border-radius: 8px;
    padding: 10px 12px;
  }

  .last-deploy-label {
    font-family: var(--mono);
    font-size: 10px;
    color: var(--muted);
  }

  .last-deploy-info {
    text-align: right;
  }

  .last-deploy-commit {
    font-family: var(--mono);
    font-size: 11px;
    color: var(--accent);
  }

  .last-deploy-time {
    font-family: var(--mono);
    font-size: 10px;
    color: var(--muted);
    margin-top: 2px;
  }

  .deploy-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: var(--mono);
    font-size: 10px;
    padding: 2px 7px;
    border-radius: 4px;
    font-weight: 600;
  }

  .pill-success { background: rgba(16,185,129,0.15); color: var(--success); }
  .pill-failed { background: rgba(239,68,68,0.15); color: var(--danger); }
  .pill-running { background: rgba(139,92,246,0.15); color: var(--running); }

  /* ── Activity log ── */
  .activity-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
  }

  .activity-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
  }

  .activity-title {
    font-size: 13px;
    font-weight: 700;
  }

  .filter-tabs {
    display: flex;
    gap: 4px;
  }

  .filter-tab {
    font-family: var(--mono);
    font-size: 10px;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.15s;
    background: none;
    color: var(--muted);
  }

  .filter-tab.active {
    background: var(--surface2);
    border-color: var(--border);
    color: var(--text);
  }

  .filter-tab:hover:not(.active) { color: var(--text); }

  .log-table { width: 100%; border-collapse: collapse; }

  .log-table th {
    font-family: var(--mono);
    font-size: 9px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    text-align: left;
    padding: 10px 20px;
    border-bottom: 1px solid var(--border);
    font-weight: 400;
  }

  .log-table td {
    padding: 12px 20px;
    font-size: 13px;
    border-bottom: 1px solid rgba(30,37,53,0.5);
    vertical-align: middle;
  }

  .log-table tr:last-child td { border-bottom: none; }

  .log-table tr {
    transition: background 0.15s;
  }

  .log-table tr:hover td { background: var(--surface2); }

  .log-table tr.running-row td { background: rgba(139,92,246,0.04); }

  .commit-hash {
    font-family: var(--mono);
    font-size: 12px;
    color: var(--accent);
  }

  .actor-name { font-size: 12px; color: var(--muted); }

  .duration-badge {
    font-family: var(--mono);
    font-size: 11px;
    color: var(--muted);
  }

  .spinning { animation: spin 1s linear infinite; display: inline-block; }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* ── Healthchecks row ── */
  .hc-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
    margin-bottom: 40px;
  }

  .hc-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .hc-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    font-size: 14px;
    flex-shrink: 0;
  }

  .hc-icon.up { background: rgba(16,185,129,0.15); }
  .hc-icon.down { background: rgba(239,68,68,0.15); }
  .hc-icon.unknown { background: rgba(74,85,104,0.2); }

  .hc-name { font-size: 12px; font-weight: 600; }
  .hc-meta { font-family: var(--mono); font-size: 10px; color: var(--muted); margin-top: 2px; }

  /* ── Empty/loading ── */
  .empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--muted);
    font-family: var(--mono);
    font-size: 12px;
  }

  /* ── Responsive ── */
  @media (max-width: 768px) {
    .summary-row { grid-template-columns: repeat(2, 1fr); }
    main { padding: 16px; }
    header { padding: 14px 16px; }
  }
</style>
</head>
<body>
<div class="wrapper">

  <header>
    <div class="logo">
      <div class="logo-icon">🏥</div>
      <div>
        <div class="logo-text">DeployWatch</div>
        <div class="logo-sub">multi-facility · laravel</div>
      </div>
    </div>
    <div class="header-right">
      <div class="live-badge">
        <div class="live-dot"></div>
        LIVE
      </div>
      <div class="last-updated" id="last-updated">Updated just now</div>
    </div>
  </header>

  <main>

    <!-- Summary stats -->
    <div class="summary-row">
      <div class="stat-card total">
        <div class="stat-label">Total Deployments</div>
        <div class="stat-value" id="stat-total">—</div>
        <div class="stat-sub" id="stat-period">last 30 days</div>
      </div>
      <div class="stat-card success">
        <div class="stat-label">Successful</div>
        <div class="stat-value" id="stat-success">—</div>
        <div class="stat-sub" id="stat-rate">success rate</div>
      </div>
      <div class="stat-card failed">
        <div class="stat-label">Failed</div>
        <div class="stat-value" id="stat-failed">—</div>
        <div class="stat-sub">need attention</div>
      </div>
      <div class="stat-card running">
        <div class="stat-label">In Progress</div>
        <div class="stat-value" id="stat-running">—</div>
        <div class="stat-sub">active now</div>
      </div>
    </div>

    <!-- Runner health -->
    <div class="section-title">Runner Health</div>
    <div class="hc-row" id="hc-row">
      <!-- populated by JS -->
    </div>

    <!-- Per-facility cards -->
    <div class="section-title">Facilities</div>
    <div class="facility-grid" id="facility-grid">
      <!-- populated by JS -->
    </div>

    <!-- Activity log -->
    <div class="section-title">Deployment Log</div>
    <div class="activity-section">
      <div class="activity-header">
        <div class="activity-title">Recent Activity</div>
        <div class="filter-tabs">
          <button class="filter-tab active" onclick="filterLog('all', this)">All</button>
          <button class="filter-tab" onclick="filterLog('success', this)">Success</button>
          <button class="filter-tab" onclick="filterLog('failed', this)">Failed</button>
          <button class="filter-tab" onclick="filterLog('running', this)">Running</button>
        </div>
      </div>
      <table class="log-table">
        <thead>
          <tr>
            <th>Status</th>
            <th>Facility</th>
            <th>Commit</th>
            <th>Triggered by</th>
            <th>Started</th>
            <th>Duration</th>
            <th>GitHub</th>
          </tr>
        </thead>
        <tbody id="log-body">
          <tr><td colspan="7" class="empty-state">Loading deployments…</td></tr>
        </tbody>
      </table>
    </div>

  </main>
</div>

<script>
// ─────────────────────────────────────────────────────────
// CONFIGURATION
// Replace MONITOR_URL and MONITOR_API_KEY with your values,
// or wire this up to your real API endpoint.
// ─────────────────────────────────────────────────────────
const CONFIG = {
  monitorUrl: 'https://testspars.cphluganda.org',  // ← your monitoring server
  apiKey: 'your-api-key-here',                      // ← your MONITOR_API_KEY
  refreshInterval: 30000,  // poll every 30 seconds
  githubRepo: 'https://github.com/okello23/labspars2',                 // ← your repo
};

// ─────────────────────────────────────────────────────────
// DEMO DATA (remove this block when wiring to a real API)
// ─────────────────────────────────────────────────────────
const DEMO_MODE = true;

const FACILITIES = [
  { id: 'facility-mulago',   name: 'Mulago Hospital',    location: 'Kampala' },
  { id: 'facility-kawempe',  name: 'Kawempe HC IV',      location: 'Kampala North' },
  { id: 'facility-entebbe',  name: 'Entebbe Hospital',   location: 'Entebbe' },
  { id: 'facility-masaka',   name: 'Masaka RRH',         location: 'Masaka' },
  { id: 'facility-mbarara',  name: 'Mbarara RRGH',       location: 'Mbarara' },
  { id: 'facility-gulu',     name: 'Gulu RRH',           location: 'Gulu' },
];

function generateDemoData() {
  const now = Date.now();
  const actors = ['benson.okello', 'admin', 'ci-bot'];
  const commits = ['a3f1c2d', 'b7e4f91', 'c12d3a5', 'd9a7b3c', 'e5f2a1b'];
  const statuses = ['success', 'success', 'success', 'success', 'failed', 'running'];

  const deployments = [];
  let id = 1000;

  FACILITIES.forEach(f => {
    const count = Math.floor(Math.random() * 8) + 3;
    for (let i = 0; i < count; i++) {
      const status = i === 0 && Math.random() < 0.15
        ? 'running'
        : statuses[Math.floor(Math.random() * statuses.length)];
      const started = now - (i * 3600000 * (Math.random() * 12 + 1));
      const duration = status === 'running' ? null : Math.floor(Math.random() * 120 + 30);
      deployments.push({
        id: id++,
        run_id: `run_${id}`,
        facility: f.id,
        status,
        commit: commits[Math.floor(Math.random() * commits.length)],
        branch: 'main',
        actor: actors[Math.floor(Math.random() * actors.length)],
        started_at: new Date(started).toISOString(),
        finished_at: status === 'running' ? null : new Date(started + duration * 1000).toISOString(),
        duration_seconds: duration,
      });
    }
  });

  deployments.sort((a, b) => new Date(b.started_at) - new Date(a.started_at));

  const runners = FACILITIES.map(f => ({
    facility: f.id,
    status: Math.random() < 0.85 ? 'online' : (Math.random() < 0.5 ? 'offline' : 'idle'),
    last_seen: new Date(now - Math.random() * 300000).toISOString(),
  }));

  return { deployments, runners };
}

// ─────────────────────────────────────────────────────────
// STATE
// ─────────────────────────────────────────────────────────
let allDeployments = [];
let runners = [];
let currentFilter = 'all';

// ─────────────────────────────────────────────────────────
// FETCH DATA
// ─────────────────────────────────────────────────────────
async function fetchData() {
  if (DEMO_MODE) {
    const data = generateDemoData();
    allDeployments = data.deployments;
    runners = data.runners;
    return;
  }

  try {
    const [depRes, runRes] = await Promise.all([
      fetch(`${CONFIG.monitorUrl}/api/deployments`, {
        headers: { 'X-Monitor-Key': CONFIG.apiKey }
      }),
      fetch(`${CONFIG.monitorUrl}/api/runners`, {
        headers: { 'X-Monitor-Key': CONFIG.apiKey }
      }),
    ]);
    allDeployments = await depRes.json();
    runners = await runRes.json();
  } catch (e) {
    console.error('Failed to fetch data:', e);
  }
}

// ─────────────────────────────────────────────────────────
// RENDER
// ─────────────────────────────────────────────────────────
function getFacilityMeta(id) {
  return FACILITIES.find(f => f.id === id) || { name: id, location: '' };
}

function timeAgo(iso) {
  const diff = (Date.now() - new Date(iso)) / 1000;
  if (diff < 60) return `${Math.floor(diff)}s ago`;
  if (diff < 3600) return `${Math.floor(diff/60)}m ago`;
  if (diff < 86400) return `${Math.floor(diff/3600)}h ago`;
  return `${Math.floor(diff/86400)}d ago`;
}

function fmtDuration(secs) {
  if (!secs) return '—';
  if (secs < 60) return `${secs}s`;
  return `${Math.floor(secs/60)}m ${secs%60}s`;
}

function statusPill(status) {
  const map = {
    success: ['pill-success', '✓', 'SUCCESS'],
    failed:  ['pill-failed',  '✕', 'FAILED'],
    running: ['pill-running', '◌', 'RUNNING'],
  };
  const [cls, icon, label] = map[status] || ['', '', status];
  return `<span class="deploy-status-pill ${cls}">${icon} ${label}</span>`;
}

function renderSummary() {
  const total   = allDeployments.length;
  const success = allDeployments.filter(d => d.status === 'success').length;
  const failed  = allDeployments.filter(d => d.status === 'failed').length;
  const running = allDeployments.filter(d => d.status === 'running').length;
  const rate    = total ? Math.round(success / (total - running) * 100) || 0 : 0;

  document.getElementById('stat-total').textContent   = total;
  document.getElementById('stat-success').textContent = success;
  document.getElementById('stat-failed').textContent  = failed;
  document.getElementById('stat-running').textContent = running;
  document.getElementById('stat-rate').textContent    = `${rate}% success rate`;
}

function renderRunners() {
  const container = document.getElementById('hc-row');
  container.innerHTML = runners.map(r => {
    const meta = getFacilityMeta(r.facility);
    const iconMap = { online: '🟢', offline: '🔴', idle: '⚪' };
    return `
      <div class="hc-card">
        <div class="hc-icon ${r.status}">${iconMap[r.status] || '❓'}</div>
        <div>
          <div class="hc-name">${meta.name}</div>
          <div class="hc-meta">${r.status.toUpperCase()} · seen ${timeAgo(r.last_seen)}</div>
        </div>
      </div>`;
  }).join('');
}

function renderFacilities() {
  const container = document.getElementById('facility-grid');
  container.innerHTML = FACILITIES.map(f => {
    const deps = allDeployments.filter(d => d.facility === f.id);
    const success = deps.filter(d => d.status === 'success').length;
    const failed  = deps.filter(d => d.status === 'failed').length;
    const total   = deps.length;
    const last    = deps[0];
    const runner  = runners.find(r => r.facility === f.id);
    const rStatus = runner?.status || 'unknown';

    return `
      <div class="facility-card">
        <div class="facility-header">
          <div>
            <div class="facility-name">${f.name}</div>
            <div class="facility-label">${f.location} · ${f.id}</div>
          </div>
          <div class="runner-status ${rStatus}">
            <div class="runner-dot"></div>
            ${rStatus}
          </div>
        </div>
        <div class="facility-stats">
          <div class="fstat">
            <div class="fstat-val t">${total}</div>
            <div class="fstat-lbl">Total</div>
          </div>
          <div class="fstat">
            <div class="fstat-val s">${success}</div>
            <div class="fstat-lbl">OK</div>
          </div>
          <div class="fstat">
            <div class="fstat-val f">${failed}</div>
            <div class="fstat-lbl">Failed</div>
          </div>
        </div>
        <div class="last-deploy">
          <div class="last-deploy-label">Last deploy</div>
          ${last ? `
            <div class="last-deploy-info">
              <div>${statusPill(last.status)}</div>
              <div class="last-deploy-commit">${last.commit}</div>
              <div class="last-deploy-time">${timeAgo(last.started_at)}</div>
            </div>
          ` : `<div class="last-deploy-time" style="color:var(--muted)">No deployments yet</div>`}
        </div>
      </div>`;
  }).join('');
}

function renderLog() {
  const tbody = document.getElementById('log-body');
  const filtered = currentFilter === 'all'
    ? allDeployments
    : allDeployments.filter(d => d.status === currentFilter);

  if (!filtered.length) {
    tbody.innerHTML = `<tr><td colspan="7" class="empty-state">No deployments found.</td></tr>`;
    return;
  }

  tbody.innerHTML = filtered.slice(0, 50).map(d => {
    const meta = getFacilityMeta(d.facility);
    const isRunning = d.status === 'running';
    return `
      <tr class="${isRunning ? 'running-row' : ''}">
        <td>${statusPill(d.status)}</td>
        <td>
          <div style="font-size:13px;font-weight:600">${meta.name}</div>
          <div style="font-family:var(--mono);font-size:10px;color:var(--muted)">${d.facility}</div>
        </td>
        <td>
          <div class="commit-hash">${d.commit}</div>
          <div style="font-family:var(--mono);font-size:10px;color:var(--muted)">${d.branch}</div>
        </td>
        <td><span class="actor-name">${d.actor}</span></td>
        <td style="font-family:var(--mono);font-size:11px;color:var(--muted)">${timeAgo(d.started_at)}</td>
        <td class="duration-badge">
          ${isRunning
            ? `<span class="spinning" style="color:var(--running)">◌</span> running`
            : fmtDuration(d.duration_seconds)}
        </td>
        <td>
          <a href="https://github.com/${CONFIG.githubRepo}/actions/runs/${d.run_id}"
             target="_blank"
             style="font-family:var(--mono);font-size:10px;color:var(--accent);text-decoration:none;">
            #${d.run_id?.replace('run_', '') || '—'} ↗
          </a>
        </td>
      </tr>`;
  }).join('');
}

function filterLog(status, btn) {
  currentFilter = status;
  document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderLog();
}

function updateTimestamp() {
  document.getElementById('last-updated').textContent =
    `Updated ${new Date().toLocaleTimeString()}`;
}

async function refresh() {
  await fetchData();
  renderSummary();
  renderRunners();
  renderFacilities();
  renderLog();
  updateTimestamp();
}

// Initial load + polling
refresh();
setInterval(refresh, CONFIG.refreshInterval);
</script>
</body>
</html>