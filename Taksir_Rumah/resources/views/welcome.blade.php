<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | TaksirRumah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset("images/Bg.png") }}') no-repeat center center/cover;
            height: 100vh; 
        }
        .overlay {
            background: rgba(0, 0, 0, 0.5);
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
            color: white;
            padding-left: 10%;
            padding-top: 55vh;
        }
        .start-btn {
            position: absolute;
            top: 25px; 
            right: 50px;
            background: rgb(30, 166, 71);
            color: black;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
        }
        .start-btn:hover {
            background: white;
            color: black;
        }
        .custom-font {
            font-family: 'Holtwood One SC', serif;
            font-weight: bold;
            color: transparent;
            background: linear-gradient(white, black);
            -webkit-background-clip: text;
            background-clip: text;
            text-shadow: 0px 0px 8px rgba(0, 0, 0, 0.05);
        }
        .description {
            font-size: 18px;
            max-width: 600px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div>
            <h1 class="fw-bold custom-font">TAKSIRRUMAH</h1>
            <h2 class="fw-normal description">
                Platform inovatif berbasis Machine Learning yang<br>
                merevolusi cara Anda menilai properti. Dengan teknologi<br>
                cerdas dan prediksi akurat, temukan estimasi harga rumah<br>
                secara instan, elegan, dan terpercaya. Masa depan investasi<br>
                properti dimulai di sini.
            </h2>
        </div>
        <a href="{{ url('/home') }}" class="start-btn">Mulai</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
