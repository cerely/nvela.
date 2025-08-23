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


// ===== NEWS UPDATE (NewsAPI) =====
const newsContainer = document.getElementById('news');
// Proxy to bypass CORS

let headlines = [];
let currentIndex = 0;

const newsUrl = "https://www.techcrunch.com/feed/";
function base64ToUtf8(base64) {
    return decodeURIComponent(
        atob(base64)
        .split('')
        .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
        .join('')
    );
}
async function fetchNews() {
    try {
        const response = await fetch(`https://api.allorigins.win/get?url=${encodeURIComponent(newsUrl)}`);
        const data = await response.json();
        const base64String = data.contents.split(",")[1]
        const xmlText = base64ToUtf8(base64String);
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, "application/xml");
        const items = xmlDoc.querySelectorAll("item");
        console.log(xmlDoc)
        items.forEach(item => {
            headlines.push({
                title: item.querySelector("title").textContent,
                url: item.querySelector("link").textContent
            });
        });
        if (headlines.length > 0) {
            console.log(headlines)
            currentIndex = 0;
            showHeadline(); // You need to define this function
        } else {
            newsContainer.innerHTML = '<p>No technology news available.</p>';
        }

    } catch (error) {
        console.error('Error fetching news:', error);
        newsContainer.innerHTML = '<p>Failed to load news.</p>';
    }
}


// Display one headline at a time
function showHeadline() {
    console.log(headlines)
    const headline = headlines[currentIndex];
    newsContainer.innerHTML = `<p><a href="${headline.url}" target="_blank">${headline.title}</a></p>`;

    currentIndex = (currentIndex + 1) % headlines.length;
}
// Rotate headlines every 60 seconds
function startNewsRotation() {
    showHeadline(); // show first headline immediately
    setInterval(showHeadline, 20 * 1000);
}

// Initialize
fetchNews()
