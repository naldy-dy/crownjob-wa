<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sendMessage($userkey, $passkey, $telepon, $message) {
        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
        $curlHandle = curl_init();
        
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to' => $telepon,
            'message' => $message
        ));
        
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        
        return $results;
    }

    $userkey = 'faf31859267a';
    $passkey = '11wvy1w2xa';
    $telepon = '08988423825'; //08988423825
    $message = 'Kak jangan lupa bawak web cam ye...';
    $response = sendMessage($userkey, $passkey, $telepon, $message);

    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Real-Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .time-display {
            font-size: 3rem;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin-top: 20%;
        }
    </style>
</head>
<body>


    <div class="time-display" id="clock">
        00:00:00 
    </div>


    <script>

        function formatTime(time) {
            return time < 10 ? "0" + time : time;
        }

        function updateClock() {
            const now = new Date();
            const hours = formatTime(now.getHours());
            const minutes = formatTime(now.getMinutes());
            const seconds = formatTime(now.getSeconds());

            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('clock').textContent = timeString;

            console.log(seconds);

            if (hours == '14' && minutes == '56' && seconds == '05') {
                sendMessage();  
            }
        }

        function sendMessage() {
            fetch('crownjob.php', {
                method: 'POST',
                body: new URLSearchParams({
                    userkey: 'faf31859267a',
                    passkey: '11wvy1w2xa',
                    to: '08988423825',
                    message: 'Testing pesan otomatis pengingat terjadwal'
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Pesan terkirim:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        setInterval(updateClock, 1000);
        
        updateClock();
    </script>

</body>
</html>
