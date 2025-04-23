<?php
date_default_timezone_set("Asia/Jakarta");

// Koordinat lokasi Kecamatan Klojen
$latitude = -7.982;  
$longitude = 112.630;
$timezone = "Asia/Bangkok";

// API URL Open-Meteo
$url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone={$timezone}&forecast_days=3";

// Ambil data dari API
$response = file_get_contents($url);
$data = json_decode($response, true);

$dates = $data['daily']['time'];
$temp_max = $data['daily']['temperature_2m_max'];
$temp_min = $data['daily']['temperature_2m_min'];
$precip = $data['daily']['precipitation_sum'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Perkiraan Cuaca 3 Hari</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style> 
    body { font-family: Arial, sans-serif; padding: 20px; } 
    h1 { text-align: center; color: #333; }
    h2 { text-align: center; color: #333; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    canvas { max-width: 100%; margin-top: 40px; }
  </style>
</head>
<body>
  <h1>Cuaca 3 Hari ke Depan</h1>
  <h2>Koordinat: <?= $latitude ?>, <?= $longitude ?></h2>

  <table>
    <tr>
      <th>Tanggal</th>
      <th>Suhu Maksimum (°C)</th>
      <th>Suhu Minimum (°C)</th>
      <th>Curah Hujan (mm)</th>
    </tr>
    <?php for ($i = 0; $i < count($dates); $i++): ?>
      <tr>
        <td><?= date('d M Y', strtotime($dates[$i])) ?></td>
        <td><?= $temp_max[$i] ?></td>
        <td><?= $temp_min[$i] ?></td>
        <td><?= $precip[$i] ?></td>
      </tr>
    <?php endfor; ?>
  </table>

  <canvas id="weatherChart" height="100"></canvas>

  <script>
    const ctx = document.getElementById('weatherChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [
          {
            label: 'Suhu Maksimum (°C)',
            data: <?= json_encode($temp_max) ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.6)'
          },
          {
            label: 'Suhu Minimum (°C)',
            data: <?= json_encode($temp_min) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
          },
          {
            label: 'Curah Hujan (mm)',
            data: <?= json_encode($precip) ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Grafik Cuaca 3 Hari ke Depan'
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Nilai'
            }
          }
        }
      }
    });
  </script>
</body>
</html>
