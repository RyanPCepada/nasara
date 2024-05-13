<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voice Recording Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #recording-container {
            text-align: center;
        }

        #start-button, #stop-button, #play-button, #send-button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }

        #send-button {
            background-color: #4caf50;
            color: white;
        }

        #status {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }

        #timer {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="recording-container">
        <h2>Voice Recording Page</h2>
        <button id="start-button">Start Recording</button>
        <button id="stop-button" disabled>Stop Recording</button>
        <button id="play-button" disabled>Play Recording</button>
        <button id="send-button" disabled>Send Voice Feedback</button>
        <p id="status"></p>
        <p id="timer"></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButton = document.getElementById('start-button');
            const stopButton = document.getElementById('stop-button');
            const playButton = document.getElementById('play-button');
            const sendButton = document.getElementById('send-button');
            const status = document.getElementById('status');
            const timer = document.getElementById('timer');

            let mediaRecorder;
            let audioChunks = [];
            let timerInterval;

            startButton.addEventListener('click', startRecording);
            stopButton.addEventListener('click', stopRecording);
            playButton.addEventListener('click', playRecording);
            sendButton.addEventListener('click', sendVoiceFeedback);

            function startRecording() {
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then((stream) => {
                        mediaRecorder = new MediaRecorder(stream);

                        mediaRecorder.ondataavailable = (event) => {
                            if (event.data.size > 0) {
                                audioChunks.push(event.data);
                            }
                        };

                        mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                            const audioUrl = URL.createObjectURL(audioBlob);

                            playButton.disabled = false;
                            stopButton.disabled = true;
                            sendButton.disabled = false;
                            status.textContent = 'Recording stopped. Ready to send.';
                            clearInterval(timerInterval);
                        };

                        mediaRecorder.start();
                        startButton.disabled = true;
                        stopButton.disabled = false;
                        playButton.disabled = true;
                        sendButton.disabled = true;
                        status.textContent = 'Recording...';
                        startTimer();
                    })
                    .catch((error) => {
                        console.error('Error accessing microphone:', error);
                    });
            }

            function stopRecording() {
                mediaRecorder.stop();
            }

            function playRecording() {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const audioUrl = URL.createObjectURL(audioBlob);

                const audioElement = new Audio(audioUrl);
                audioElement.play();
            }

            function sendVoiceFeedback() {
                const formData = new FormData();
                formData.append('audio', audioChunks);

                fetch('actions/store_audio.php', {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.text())
                .then((message) => {
                    status.textContent = message;
                })
                .catch((error) => {
                    console.error('Error sending voice feedback:', error);
                });
            }

            function startTimer() {
                let seconds = 0;
                timerInterval = setInterval(() => {
                    seconds++;
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    timer.textContent = `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
                }, 1000);
            }
        });
    </script>
</body>
</html>
