@extends('layouts.app')

@section('title', 'Tiyatrolar')

@section('content')
<h2 id="yaklasantiyatrolar" class="text-2xl font-bold my-4">Yaklaşan Tiyatrolar</h2>

{{-- CSRF token meta --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="events-list" class="space-y-6"></div>
<div class="pagination flex justify-center gap-2 mt-6" id="pagination"></div>

<script>
    let currentPage = 1;

  async function fetchEvents(page = 1) {
    try {
        const response = await fetch(
            `https://app.ticketmaster.com/discovery/v2/events.json?classificationName=Theatre&apikey=GmtuhAeXE2g54hjoICBPDlVavYICJ1MJ&countryCode=TR&size=7&sort=date,asc&page=${page - 1}`
        );
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
        try {
            const response = await fetch(
                `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=8d617816426bc116b8e4637d172a2d18&lang=tr`
                
            );
            if (!response.ok) throw new Error("Hava durumu çekilemedi!");
            const data = await response.json();
            return `${data.weather[0].description}, ${data.main.temp}°C`;
        } catch (error) {
            console.error("Hava Durumu Hatası:", error);
            return "Hava durumu alınamadı";
        }
    }

    async function displayEvents() {
    const { events, pageCount } = await fetchEvents(currentPage);
    const eventsList = document.getElementById("events-list");
    const pagination = document.getElementById("pagination");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
eventsList.innerHTML = "";  

async function getCapacity(eventId) {
    try {
        const res = await fetch(`/api/event-capacity?id=${eventId}`);
        if (!res.ok) throw new Error("Capacity fetch error");
        const data = await res.json();
        return data.capacity ?? 50; 
    } catch {
        return 50; 
    }
}

for (const event of events) {
    const utcDate = new Date(event.dates.start.dateTime);
    const options = {
        timeZone: "Europe/Istanbul",
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
    };
    const eventDateTime = utcDate.toLocaleString("tr-TR", options);
    const [eventDate, eventTime] = eventDateTime.split(" ");

    const venueObj = event._embedded.venues[0];
    const venueName = venueObj?.name || "Mekan bilgisi yok";
    const lat = venueObj?.location?.latitude;
    const lon = venueObj?.location?.longitude;

    let weather = "Hava durumu alınamadı";
    if (lat && lon) {
        weather = await fetchWeather(lat, lon);
    }

    
    const capacity = await getCapacity(event.id);

    const price = "100₺";      
    const rawPrice = 100;      

    const eventElement = document.createElement("div");
    eventElement.className = "event border rounded p-4 bg-white shadow";

    eventElement.innerHTML = `
        <div class="event-date font-semibold text-sm mb-2">
            <span>${eventDate}</span> - <span>${eventTime}</span>
        </div>
        <div class="event-content">
            <h3 class="text-lg font-bold mb-1">${event.name}</h3>
            <p class="mb-1">Mekan: ${venueName}</p>
            <p class="mb-1">Hava Durumu: ${weather}</p>
           
            <p class="mb-2">Fiyat: ${price}</p>

            <form action="/cart/api-add" method="POST">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="id" value="${event.id}">
                <input type="hidden" name="name" value="${event.name}">
                <input type="hidden" name="price" value="${rawPrice}">
                <input type="hidden" name="capacity" value="${capacity}">
                <input type="hidden" name="url" value="${event.url}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sepete Ekle</button>
            </form>
        </div>
    `;

    eventsList.appendChild(eventElement);
}

    
    pagination.innerHTML = "";
    for (let i = 1; i <= Math.min(pageCount, 10); i++) {
        const btn = document.createElement("button");
        btn.className = "px-3 py-1 rounded border";
        btn.innerText = i;

        ((page) => {
            btn.addEventListener("click", () => {
                currentPage = page;
                displayEvents();
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        })(i);

        if (i === currentPage) {
            btn.style.backgroundColor = "#0056b3";
            btn.style.color = "white";
        }

        pagination.appendChild(btn);
    }
}



    window.addEventListener('load', displayEvents);

</script>
@endsection

