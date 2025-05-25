function fetchEvents(classificationName, containerId) {
    const currentUrl = window.location.href;

    fetch(`/api/events?classificationName=${encodeURIComponent(classificationName)}&url=${encodeURIComponent(currentUrl)}`)
        .then(response => response.json())
        .then(data => displayEvents(data, containerId))
        .catch(error => {
            console.error("Etkinlik verileri alınamadı:", error);
            document.getElementById(containerId).innerHTML = "<p>Etkinlikler yüklenemedi.</p>";
        });
}

function fetchWeather(city, date, weatherContainer) {
    fetch(`/api/weather?city=${encodeURIComponent(city)}&date=${encodeURIComponent(date)}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.condition) {
                weatherContainer.textContent = `${data.condition} - ${data.avgtempC}°C`;
            } else {
                weatherContainer.textContent = "Hava durumu bulunamadı";
            }
        })
        .catch(error => {
            console.error('Weather API error:', error);
            weatherContainer.textContent = "Hava durumu alınamadı";
        });
}

function displayEvents(events, containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = "";

    events.forEach(event => {
        const eventElement = document.createElement("div");
        eventElement.className = "event border rounded p-4 bg-white shadow mb-4";

        eventElement.innerHTML = `
            <h3 class="text-lg font-bold mb-1">${event.name}</h3>
            <p><strong>Tarih:</strong> ${event.date}</p>
            <p><strong>Şehir:</strong> ${event.city}</p>
            <p><strong>Mekan:</strong> ${event.venue}</p>
            <p><strong>Fiyat:</strong> ${event.price ? event.price + "₺" : "Bilinmiyor"}</p>
            <p><strong>Hava Durumu:</strong> <span class="weather text-sm italic">Yükleniyor...</span></p>
            <form method="POST" action="/add-to-cart" class="mt-2">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                <input type="hidden" name="event_id" value="${event.id}">
                <input type="hidden" name="name" value="${event.name}">
                <input type="hidden" name="price" value="${event.price}">
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Sepete Ekle</button>
            </form>
        `;

        container.appendChild(eventElement);

        const weatherContainer = eventElement.querySelector(".weather");
        fetchWeather(event.city, event.date, weatherContainer);
    });
}
