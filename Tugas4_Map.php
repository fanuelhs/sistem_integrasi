<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cuaca Kecamatan di Malang</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
      flex-direction: column;
      height: 100vh;
      background-color: #fef4f8;
    }

    header {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 20px;
    }

    header h1 {
      margin: 0;
      font-size: 24px;
    }

    #map {
      flex: 1;
      width: 100vw;
      height: calc(100vh - 110px); /* 70 header + 40 footer */
      z-index: 1;
    }

    footer {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 10px;
      font-size: 14px;
      margin-top: auto;
    }
  </style>
</head>
<body>
  <header>
    <h1>Peta & Cuaca 5 Kecamatan Kota Malang</h1>
  </header>

  <div id="map"></div>

  <footer>
    Dibuat oleh Kukuh Y - FTI Unmer Malang - Sistem Integrasi 2025
  </footer>

  <script>
    // Inisialisasi peta
    const map = L.map('map').setView([-7.975, 112.633], 12);
    
    // Tambahkan layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
      maxZoom: 18,
      minZoom: 10
    }).addTo(map);

    // Custom icon
    const weatherIcon = L.icon({
      iconUrl: 'https://cdn-icons-png.flaticon.com/512/1116/1116453.png',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    });

    // Data kecamatan
    const districts = [
      { name: 'Klojen', coords: [-7.982, 112.630] },
      { name: 'Blimbing', coords: [-7.939, 112.647] },
      { name: 'Lowokwaru', coords: [-7.952, 112.611] },
      { name: 'Sukun', coords: [-8.003, 112.614] },
      { name: 'Kedungkandang', coords: [-7.978, 112.664] }
    ];

    // Tambahkan marker dan fetch cuaca saat diklik
    districts.forEach(district => {
      const marker = L.marker(district.coords, { icon: weatherIcon }).addTo(map);

      marker.on('click', async () => {
        const { coords, name } = district;
        const lat = coords[0];
        const lon = coords[1];

        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,precipitation&timezone=Asia%2FBangkok`;

        try {
          const response = await fetch(url);
          const data = await response.json();

          const temp = data.current.temperature_2m;
          const rain = data.current.precipitation;

          const popupContent = `
            <b>📍 ${name}</b><br>
            🌡️ Suhu Saat Ini: ${temp}°C<br>
            🌧️ Curah Hujan: ${rain} mm
          `;

          marker.bindPopup(popupContent).openPopup();
        } catch (err) {
          marker.bindPopup("Gagal memuat data cuaca.").openPopup();
        }
      });
    });
  </script>
</body>
</html>
