<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>nvela.</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap');
    :root {
    --color-bg: #FFFBEF;
    --color-light: #A79EA3;
    --color-dark: #786B76;
    --color-beige: #CFC9C9;
    --color-black: #000000;
    --text-color: #aea8ad;
    --text-color-1: #A2999F ;
    --text-color-2: #433B42;
    --radio-color: var(--color-light);

    --border-radius: 12px;
    --card-border-radius: 1rem;
    transition: background-color 0.4s ease, color 0.4s ease;
    }
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
  background: var(--color-bg);
  min-height: 100vh;
  color: #333;
}

.navbar {
    
    display: flex;
    /* flex-wrap: wrap; */
    align-items: center;
    gap: 1rem;
    padding: 0.5rem 1rem 0rem 1rem;
}

.logo {
    font-weight: bold;
    font-size: 1.8rem;
    flex-shrink: 0;
}

/* Navigation Icons */
.nav-icons {
    height: 45px;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7rem;
    background-color: var(--color-dark);
    border-radius: var(--border-radius);
    padding: 0.5rem;
    
}

.nav-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-color);
    text-decoration: none;
}

.nav-icons span {
    color: var(--text-color);
    text-decoration: none;
}

/* Search bar */
.search {
    flex: 1;
    background-color: var(--color-beige);
    border-radius: var(--border-radius);
    height: 50px;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    min-width: 200px;
}

.search span {
    margin-right: 10px;
}

.search p {
    opacity: 50%;
    font-size: 0.9rem;
}

/* Settings button */
.settings {
    background-color: var(--color-light);
    padding: 0 1rem;
    height: 50px;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 50px;
}

/* Profile section */
.profile {
    background-color: var(--color-dark);
    border-radius: var(--border-radius);
    display: flex;
    /* align-items: center; */
    gap: 0.5rem;
    padding: 0.4rem 0.4rem 0;
    flex-shrink: 0;
    min-width: 50px;
}

.profile-photo img {
    width: 38px;
    height: 38px;
    border-radius: 50%;  
}

.profile-desc .p1 {
    font-weight: bold;
    font-size: 0.8rem;
}

.profile-desc .p2 {
    font-size: 0.9rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* .header {
  text-align: center;
  margin-bottom: 40px;
  color: #fff;
}

.header h1 {
  font-size: 3rem;
  margin-bottom: 10px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, .3);
} */

.admin-panel {
  background: var(--color-dark);
  border-radius: 20px;
  padding: 30px;
  margin-bottom: 30px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, .1);
  backdrop-filter: blur(10px);
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--text-color-1);
}

input,
textarea,
select {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e1e5e9;
  border-radius: 12px;
  font-size: 16px;
  transition: .3s all;
}

input:focus,
textarea:focus,
select:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, .1);
}

textarea {
  min-height: 100px;
  resize: vertical;
}

.priority-select {
  background: linear-gradient(45deg, #f8f9fa, #e9ecef);
}

.btn {
  background: var(--color-beige);
  color: #fff;
  border: none;
  padding: 12px 24px;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: .3s all;
  margin-right: 10px;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px var(--color-light);
}

.filters {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-bottom: 30px;
  background: rgba(255, 255, 255, .1);
  padding: 20px;
  border-radius: 15px;
  backdrop-filter: blur(10px);
}

.filter-group {
  display: flex;
  flex-direction: column;
}

.filter-group label {
  color: var(--text-color-2);
  margin-bottom: 5px;
  font-size: 14px;
}

.notices-container {
  display: grid;
  gap: 20px;
}

.notice-card {
  background: #fff;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
  transition: .3s all;
  position: relative;
  overflow: hidden;
}

.notice-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: var(--color-dark)
}

.notice-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px var(--color-dark);
}

.notice-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 15px;
}

.notice-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--text-color-2);
  margin-bottom: 5px;
}

.notice-meta {
  display: flex;
  gap: 15px;
  font-size: .9rem;
  color: #718096;
  margin-bottom: 15px;
}

.notice-content {
  color: #4a5568;
  line-height: 1.6;
  margin-bottom: 15px;
  white-space: pre-wrap;
}

.tags-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 15px;
}

.tag {
  background: var(--color-dark);
  color: #fff;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: .8rem;
  font-weight: 500;
}

.priority-badge {
  padding: 6px 12px;
  border-radius: 20px;
  font-size: .8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.priority-high {
  background: #fed7d7;
  color: #c53030;
}

.priority-medium {
  background: #feebc8;
  color: #d69e2e;
}

.priority-low {
  background: #c6f6d5;
  color: #38a169;
}

.delete-btn {
  background: #e53e3e;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-size: .8rem;
  transition: .3s all;
}

.delete-btn:hover {
  background: #c53030;
  transform: scale(1.05);
}

.no-notices {
  text-align: center;
  color: var(--text-color-1);
  font-size: 1.2rem;
  padding: 40px;
  background: rgba(255, 255, 255, .1);
  border-radius: 15px;
  backdrop-filter: blur(10px);
}

.toggle-section {
  background: var(--color-light);
  color: var(--text-color-2);
  border: 2px solid var(--color-dark);
  padding: 12px 24px;
  border-radius: 12px;
  cursor: pointer;
  margin-bottom: 20px;
  transition: .3s all;
}

.toggle-section:hover {
  background: rgba(255, 255, 255, .2);
}

.hidden {
  display: none;
}

.status {
  color: #fff;
  margin-bottom: 12px;
}

@media (max-width: 768px) {
  .header h1 {
    font-size: 2rem;
  }

  .container {
    padding: 10px;
  }

  .admin-panel,
  .notice-card {
    padding: 20px;
  }

  .filters {
    grid-template-columns: 1fr;
  }

  .notice-header {
    flex-direction: column;
    gap: 10px;
  }
}

  </style>
</head>
<body>
  <header>
        <nav class="navbar">
            <div class="logo">
                <p>nvela.</p>
            </div>
            
            <div class="nav-icons">
                <a href="localhost/NVELAMAIN/main.html" class="nav-ico">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <a href="http://localhost/NVELAMAIN/document/nvela.php" class="nav-ico">
                    <span class="material-symbols-outlined">description</span>
                </a>
                <a href="#control" class="nav-ico">
                    <span class="material-symbols-outlined">discover_tune</span>
                </a>
                <a href="#database" class="nav-ico">
                    <span class="material-symbols-outlined">database</span>
                </a>
            </div>

            <div class="search">
                <span class="material-symbols-outlined">search</span>
                <p class="search-txt">Search in dashboard</p>
            </div>

            <div class="settings">
                <span class="material-symbols-outlined">settings</span>
            </div>

            <div class="profile">
                <div class="profile-photo">
                    <img src="../images/pfp.jpg" alt="Profile">
                </div>
                <div class="profile-desc">
                    <p class="p1">Logged in as,</p>
                    <p class="p2">Admin</p>
                    
                </div>
            </div>
        </nav>
    </header>
  <div class="container">

    <div class="status" id="status"></div>

    <button class="toggle-section" onclick="toggleAdminPanel()">Add New Notice</button>

    <div class="admin-panel" id="adminPanel">
      <h2 style="margin-bottom:25px;color:var(--text-color);">Create New Notice</h2>
      <form id="noticeForm">
        <div class="form-group">
          <label for="title">Notice Title</label>
          <input type="text" id="title" required placeholder="Enter notice title...">
        </div>

        <div class="form-group">
          <label for="content">Notice Content</label>
          <textarea id="content" required placeholder="Enter detailed content of the notice..."></textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div class="form-group">
            <label for="priority">Priority Level</label>
            <select id="priority" class="priority-select">
              <option value="low">🟢 Low Priority</option>
              <option value="medium" selected>🟡 Medium Priority</option>
              <option value="high">🔴 High Priority</option>
            </select>
          </div>

          <div class="form-group">
            <label for="category">Category</label>
            <select id="category">
              <option value="general">📋 General</option>
              <option value="urgent">⚡ Urgent</option>
              <option value="event">🎉 Event</option>
              <option value="maintenance">🔧 Maintenance</option>
              <option value="academic">📚 Academic</option>
              <option value="administrative">🏢 Administrative</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="tags">Tags (comma separated)</label>
          <input type="text" id="tags" placeholder="e.g., important, deadline, meeting, exam">
        </div>

        <button type="submit" class="btn" id="publishBtn">📝 Publish Notice</button>
        <button type="button" class="btn" onclick="clearForm()" style="background:var(--color-light);">🗑️ Clear Form</button>
      </form>
    </div>

    <div class="filters">
      <div class="filter-group">
        <label>🔍 Search</label>
        <input type="text" id="searchFilter" placeholder="Search notices..." onkeyup="filterNotices()">
      </div>
      <div class="filter-group">
        <label>📂 Category</label>
        <select id="categoryFilter" onchange="filterNotices()">
          <option value="">All Categories</option>
          <option value="general">General</option>
          <option value="urgent">Urgent</option>
          <option value="event">Event</option>
          <option value="maintenance">Maintenance</option>
          <option value="academic">Academic</option>
          <option value="administrative">Administrative</option>
        </select>
      </div>
      <div class="filter-group">
        <label>⭐ Priority</label>
        <select id="priorityFilter" onchange="filterNotices()">
          <option value="">All Priorities</option>
          <option value="high">High Priority</option>
          <option value="medium">Medium Priority</option>
          <option value="low">Low Priority</option>
        </select>
      </div>
      <div class="filter-group">
        <label>📅 Sort By</label>
        <select id="sortBy" onchange="sortNotices()">
          <option value="newest">Newest First</option>
          <option value="oldest">Oldest First</option>
          <option value="priority">Priority Level</option>
          <option value="title">Title (A–Z)</option>
        </select>
      </div>
    </div>

    <div class="notices-container" id="noticesContainer">
      <div class="no-notices">Loading notices… ⏳</div>
    </div>
  </div>

  <script>
    let notices = [];
    const statusEl = document.getElementById('status');

    function setStatus(msg, type='info'){
      statusEl.textContent = msg || '';
      statusEl.style.opacity = msg ? 1 : 0;
      statusEl.style.transition = 'opacity .2s';
      statusEl.style.color = type==='error' ? '#ffecec' : '#ffffff';
    }

    function toggleAdminPanel(){
      document.getElementById('adminPanel').classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', fetchNotices);

    async function fetchNotices(){
      try{
        setStatus('Fetching notices…');
        const res = await fetch('get_notices.php', { headers: { 'Accept':'application/json' }});
        if(!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();
        // Normalize: ensure tags is an array
        notices = (Array.isArray(data) ? data : []).map(n => ({
          ...n,
          category: n.category || 'general',
          priority: n.priority || 'medium',
          tags: Array.isArray(n.tags) ? n.tags : (n.tags ? String(n.tags).split(',').map(t=>t.trim()).filter(Boolean) : []),
          timestamp: n.timestamp || new Date().toISOString()
        }));
        renderNotices();
        setStatus('');
      }catch(err){
        setStatus('Failed to load notices: ' + err.message, 'error');
        document.getElementById('noticesContainer').innerHTML =
          '<div class="no-notices">Could not load notices from the server. ❌</div>';
      }
    }

    document.getElementById('noticeForm').addEventListener('submit', async function(e){
      e.preventDefault();
      const title = document.getElementById('title').value.trim();
      const content = document.getElementById('content').value.trim();
      const priority = document.getElementById('priority').value;
      const category = document.getElementById('category').value;
      const tagsInput = document.getElementById('tags').value.trim();
      if(!title || !content){ alert('Please fill in both title and content fields.'); return; }
      const tags = tagsInput ? tagsInput.split(',').map(t=>t.trim()).filter(Boolean) : [];

      const payload = { title, content, priority, category, tags };
      const btn = document.getElementById('publishBtn');
      const original = btn.textContent;
      btn.disabled = true; btn.textContent = 'Publishing…';

      try{
        const res = await fetch('add_notices.php', {
          method:'POST',
          headers:{'Content-Type':'application/json','Accept':'application/json'},
          body: JSON.stringify(payload)
        });
        const out = await res.json();
        if(!out.success){ throw new Error(out.error || 'Unknown error'); }
        clearForm();
        await fetchNotices();
        btn.textContent = '✅ Notice Published!';
        btn.style.background = '#38a169';
        setTimeout(()=>{ btn.textContent = original; btn.style.background = ''; btn.disabled = false; }, 900);
      }catch(err){
        btn.disabled = false; btn.textContent = original;
        alert('Error adding notice: ' + err.message);
      }
    });

    function clearForm(){ document.getElementById('noticeForm').reset(); }

    async function deleteNotice(id){
      if(!confirm('Are you sure you want to delete this notice?')) return;
      try{
        const res = await fetch('delete_notices.php?id='+encodeURIComponent(id), { headers:{'Accept':'application/json'} });
        const out = await res.json();
        if(!out.success){ throw new Error(out.error || 'Unknown error'); }
        await fetchNotices();
      }catch(err){
        alert('Error deleting notice: ' + err.message);
      }
    }

    function renderNotices(){
      const container = document.getElementById('noticesContainer');
      if(!notices.length){
        container.innerHTML = '<div class="no-notices">No notices available. Create your first notice using the form above! 🎯</div>';
        return;
      }
      const filtered = filterAndSortNotices();
      if(!filtered.length){
        container.innerHTML = '<div class="no-notices">No notices match your current filters. Try adjusting your search criteria. 🔍</div>';
        return;
      }
      container.innerHTML = filtered.map(notice => `
        <div class="notice-card" data-id="${notice.id}" data-category="${notice.category}" data-priority="${notice.priority}">
          <div class="notice-header">
            <div>
              <h3 class="notice-title">${escapeHtml(notice.title)}</h3>
              <div class="notice-meta">
                <span>📅 ${formatDate(notice.timestamp)}</span>
                <span>📂 ${getCategoryIcon(notice.category)} ${capitalize(notice.category)}</span>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
              <span class="priority-badge priority-${notice.priority}">
                ${getPriorityIcon(notice.priority)} ${notice.priority}
              </span>
              <button class="delete-btn" onclick="deleteNotice(${Number(notice.id)})">🗑️</button>
            </div>
          </div>
          <div class="notice-content">${escapeHtml(notice.content)}</div>
          ${notice.tags && notice.tags.length ? `
            <div class="tags-container">
              ${notice.tags.map(t=>`<span class="tag">#${escapeHtml(t)}</span>`).join('')}
            </div>` : ``}
        </div>
      `).join('');
    }

    function filterAndSortNotices(){
      let filtered = [...notices];
      const searchTerm = document.getElementById('searchFilter').value.toLowerCase().trim();
      if(searchTerm){
        filtered = filtered.filter(n =>
          (n.title||'').toLowerCase().includes(searchTerm) ||
          (n.content||'').toLowerCase().includes(searchTerm) ||
          (n.tags||[]).some(tag => (tag||'').toLowerCase().includes(searchTerm))
        );
      }
      const categoryFilter = document.getElementById('categoryFilter').value;
      if(categoryFilter){ filtered = filtered.filter(n => n.category === categoryFilter); }
      const priorityFilter = document.getElementById('priorityFilter').value;
      if(priorityFilter){ filtered = filtered.filter(n => n.priority === priorityFilter); }

      const sortBy = document.getElementById('sortBy').value;
      filtered.sort((a,b)=>{
        switch(sortBy){
          case 'oldest': return new Date(a.timestamp) - new Date(b.timestamp);
          case 'priority':
            const order = {high:3, medium:2, low:1};
            return (order[b.priority]||0) - (order[a.priority]||0);
          case 'title': return String(a.title).localeCompare(String(b.title));
          case 'newest':
          default: return new Date(b.timestamp) - new Date(a.timestamp);
        }
      });
      return filtered;
    }

    function filterNotices(){ renderNotices(); }
    function sortNotices(){ renderNotices(); }

    function formatDate(ts){
      const date = new Date(ts);
      const now = new Date();
      const diffMs = Math.abs(now - date);
      const diffDays = Math.floor(diffMs / (1000*60*60*24));
      if(diffDays === 0) return 'Today at ' + date.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
      if(diffDays === 1) return 'Yesterday';
      if(diffDays < 7) return `${diffDays} days ago`;
      return date.toLocaleDateString();
    }
    function getCategoryIcon(c){
      const icons = {general:'📋', urgent:'⚡', event:'🎉', maintenance:'🔧', academic:'📚', administrative:'🏢'};
      return icons[c] || '📋';
    }
    function getPriorityIcon(p){ return ({high:'🔴', medium:'🟡', low:'🟢'})[p] || '🟡'; }
    function capitalize(s){ return (s||'').charAt(0).toUpperCase() + (s||'').slice(1); }
    function escapeHtml(str){
      return String(str || '')
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;')
        .replace(/'/g,'&#039;');
    }
  </script>
</body>
</html>