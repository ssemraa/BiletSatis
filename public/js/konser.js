let currentPage = 1;

async function fetchConcerts(page = 1) {
    const apiKey = "GmtuhAeXE2g54hjoICBPDlVavYICJ1MJ";
    const url = `https://app.ticketmaster.com/discovery/v2/events.json?classificationName=Music&apikey=${apiKey}&countryCode=TR&size=7&sort=date,asc&page=${page - 1}`;

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Veri çekilemedi!");
        const data = await response.json();
        const events = data._embedded?.events || [];
        const pageCount = data.page?.totalPages || 1;
        return { events, pageCount };
    } catch (error) {
        console.error("Hata:", error);
        return { events: [], pageCount: 1 };
    }
}

async function fetchWeather(lat, lon) {
    const weatherApiKey = "8d617816426bc116b8e4637d172a2d18";
    const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${weatherApiKey}&lang=tr`;

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Hava durumu alınamadı");
        const data = await response.json();
        return `${data.weather[0].description}, ${data.main.temp}°C`;
    } catch (error) {
        console.error("Hava Durumu Hatası:", error);
        return "Hava durumu alınamadı";
    }
}

async function loadConcerts() {
    const { events, pageCount } = await fetchConcerts(currentPage);
    const eventsList = document.getElementById("events-list");
    const pagination = document.getElementById("pagination");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    eventsList.innerHTML = "";
    pagination.innerHTML = "";

    for (const event of events) {
        const dateObj = new Date(event.dates.start.dateTime);
        const eventDate = dateObj.toLocaleDateString("tr-TR");
        const eventTime = dateObj.toLocaleTimeString("tr-TR", { hour: "2-digit", minute: "2-digit" });

        const venue = event._embedded.venues[0].name;
        const lat = event._embedded.venues[0].location.latitude;
        const lon = event._embedded.venues[0].location.longitude;
        const price = event.priceRanges ? `${event.priceRanges[0].min} ${event.priceRanges[0].currency}` : "Fiyat bilgisi yok";
        const rawPrice = event.priceRanges ? event.priceRanges[0].min : 0;
        const weather = await fetchWeather(lat, lon);

        const eventElement = document.createElement("div");
        eventElement.className = "event border rounded p-4 bg-white shadow";
        eventElement.innerHTML = `
            <div class="event-date font-semibold text-sm mb-2">
                <span>${eventDate}</span> - <span>${eventTime}</span>
            </div>
            <div class="event-content">
                <h3 class="text-lg font-bold mb-1">${event.name}</h3>
                <p class="mb-1">Mekan: ${venue}</p>
                <p class="mb-1">Hava Durumu: ${weather}</p>
                <p class="mb-2">Fiyat: ${price}</p>
                <form action="/cart/api-add" method="POST">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="name" value="${event.name}">
                    <input type="hidden" name="price" value="${rawPrice}">
                    <input type="hidden" name="url" value="${event.url}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sepete Ekle</button>
                </form>
            </div>
        `;
        eventsList.appendChild(eventElement);
    }

    for (let i = 1; i <= Math.min(pageCount, 10); i++) {
        const btn = document.createElement("button");
        btn.className = "px-3 py-1 rounded border";
        btn.innerText = i;

        btn.onclick = () => {
            currentPage = i;
            loadConcerts();
            window.scrollTo({ top: 0, behavior: "smooth" });
        };

        if (i === currentPage) {
            btn.style.backgroundColor = "#0056b3";
            btn.style.color = "white";
        }

        pagination.appendChild(btn);
    }
}
