<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>


    <title>Kehadiran Kalender</title>
</head>
<body>
    <div id='calendar'></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/attendance-data', // URL untuk mengambil data kehadiran
            });

            calendar.render();
        });
    </script>
</body>

{{-- <body>
    <!-- Kontrol untuk tampilan (Dropdown atau Button) -->
    <div style="margin-bottom: 20px;">
        <button id="yearView">Tahun</button>
        <button id="monthView">Bulan</button>
        <button id="weekView">Minggu</button>
        <button id="dayView">Hari</button>
    </div>

    <div id='calendar'></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan awal
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: '' // Akan diubah dengan tombol kustom
                },
                views: {
                    dayGridMonth: { // Tampilan bulan
                        buttonText: 'Bulan'
                    },
                    timeGridWeek: { // Tampilan minggu
                        buttonText: 'Minggu'
                    },
                    timeGridDay: { // Tampilan hari
                        buttonText: 'Hari'
                    },
                },
                events: '/attendance-data', // Mengambil data kehadiran
            });

            // Tombol untuk mengubah tampilan
            document.getElementById('yearView').addEventListener('click', function() {
                calendar.changeView('dayGridYear'); // Anda bisa buat custom view untuk tahunan
            });
            document.getElementById('monthView').addEventListener('click', function() {
                calendar.changeView('dayGridMonth');
            });
            document.getElementById('weekView').addEventListener('click', function() {
                calendar.changeView('timeGridWeek');
            });
            document.getElementById('dayView').addEventListener('click', function() {
                calendar.changeView('timeGridDay');
            });

            calendar.render();
        });
    </script>
</body> --}}
</html>
