// ===== TIME UPDATE =====
const timeContainer = document.getElementById('time');

function updateTime() {
    const now = new Date();

    // Format hours and minutes
    let hours = now.getHours();
    const minutes = now.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12 || 12; // convert 0 -> 12
    const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;

    timeContainer.innerHTML = `<p>${hours}:${formattedMinutes} ${ampm}</p>`;
}

// Update time every second
setInterval(updateTime, 1000);
updateTime();


// ===== WEATHER UPDATE (Open-Meteo Free API) =====
const weatherContainer = document.getElementById('weather');

// Panvel coordinates
const lat = 18.9984;
const lon = 73.1120;
const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;

async function updateWeather() {
    try {
        const response = await fetch(weatherUrl);
        const data = await response.json();

        const temp = data.current_weather.temperature;

        weatherContainer.innerHTML = `
            <p>${temp}°C</p>
            <span class="material-symbols-outlined">location_on</span>
            <p>Panvel</p>
        `;
    } catch (error) {
        console.error('Error fetching weather:', error);
        weatherContainer.innerHTML = '<p>Failed to load weather.</p>';
    }
}

// Update weather every 10 minutes
setInterval(updateWeather, 10 * 60 * 1000);
updateWeather();


// ===== NEWS UPDATE (robust RSS via AllOrigins raw with fallback) =====
const newsContainer = document.getElementById('news');
let headlines = [];
let currentIndex = 0;
const newsUrl = "https://techcrunch.com/feed/"; // feed URL

function safeText(node) {
  return node ? node.textContent.trim() : null;
}

async function fetchNews() {
  try {
    // try AllOrigins raw first (returns plain text)
    const proxy = `https://api.allorigins.win/raw?url=${encodeURIComponent(newsUrl)}`;
    const resp = await fetch(proxy);
    if (!resp.ok) throw new Error('Network response not ok: ' + resp.status);
    let text = await resp.text();

    // clean BOM or stray control chars that break XML parsing
    text = text.replace(/^\uFEFF/, '').replace(/\0/g, '');

    // attempt XML parse
    const parser = new DOMParser();
    const xmlDoc = parser.parseFromString(text, "application/xml");

    // parsererror check
    const parserError = xmlDoc.querySelector('parsererror');
    if (!parserError) {
      // Good parse: extract <item> nodes
      const items = xmlDoc.querySelectorAll('item');
      headlines = []; // reset to avoid duplicates
      items.forEach(item => {
        // title might be inside <title>, link might be text content or href attribute for some feeds
        const title = safeText(item.querySelector('title')) || '';
        let link = safeText(item.querySelector('link')) || '';
        // sometimes <link> is an element with href attribute (atom) or contains CDATA
        if (!link) {
          const linkEl = item.querySelector('link[href]');
          if (linkEl) link = linkEl.getAttribute('href');
        }
        // sometimes link is inside <guid> or <enclosure url="">
        if (!link) {
          link = safeText(item.querySelector('guid')) || (item.querySelector('enclosure') ? item.querySelector('enclosure').getAttribute('url') : '');
        }
        if (title && link) headlines.push({ title, url: link });
      });

      if (headlines.length === 0) {
        newsContainer.innerHTML = '<p>No technology news available.</p>';
      } else {
        currentIndex = 0;
        showHeadline();
      }
      return;
    }

    // If parser errored, fall back to a regex-based extraction for <item> ... </item>
    console.warn('XML parsererror, falling back to regex extraction.');
    const itemBlocks = Array.from(text.matchAll(/<item[\s\S]*?<\/item>/gi), m => m[0]);
    headlines = [];
    itemBlocks.forEach(block => {
      // extract title and link with regex / handle CDATA
      const tMatch = block.match(/<title\b[^>]*>([\s\S]*?)<\/title>/i);
      const lMatch = block.match(/<link\b[^>]*>([\s\S]*?)<\/link>/i) || block.match(/<link[^>]*href=["']([^"']+)["'][^>]*>/i);
      let title = tMatch ? tMatch[1].replace(/<!\[CDATA\[|\]\]>/g, '').trim() : null;
      let link  = lMatch ? (lMatch[1] || lMatch[0]).replace(/<!\[CDATA\[|\]\]>/g, '').trim() : null;

      // additional fallback: guid tag
      if (!link) {
        const gMatch = block.match(/<guid\b[^>]*>([\s\S]*?)<\/guid>/i);
        link = gMatch ? gMatch[1].replace(/<!\[CDATA\[|\]\]>/g, '').trim() : null;
      }

      if (title && link) headlines.push({ title, url: link });
    });

    if (headlines.length === 0) {
      newsContainer.innerHTML = '<p>Could not parse feed (fallback failed).</p>';
    } else {
      currentIndex = 0;
      showHeadline();
    }

  } catch (err) {
    console.error('Error fetching/parsing news:', err);
    newsContainer.innerHTML = '<p>Failed to load news.</p>';
  }
}

function showHeadline() {
  if (!headlines || headlines.length === 0) {
    newsContainer.innerHTML = '<p>No headlines yet.</p>';
    return;
  }
  const h = headlines[currentIndex];
  newsContainer.innerHTML = `<p><a href="${h.url}" target="_blank" rel="noopener noreferrer">${h.title}</a></p>`;
  currentIndex = (currentIndex + 1) % headlines.length;
}

// Start rotation + periodic refetch
fetchNews();                           // initial fetch
setInterval(showHeadline, 5 * 1000);   // rotate headlines every 5s (adjust if needed)
setInterval(fetchNews, 5 * 60 * 1000); // re-fetch feed every 5 minutes

