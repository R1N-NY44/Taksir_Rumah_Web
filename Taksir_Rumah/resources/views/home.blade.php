@extends('layouts.app')

@section('title', 'Home | TaksirRumah')

@section('content')

    <!-- Hero Section -->
    <div class="container text-center hero-section">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 id="typingText" class="fw-bold"></h1>
            </div>
        </div>
    </div>

    <!-- Form Prediksi -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card p-4 shadow">
                <h3 class="text-center">Prediksi Harga Rumah</h3>
                <form id="predictionForm">
                    <div class="mb-3">
                        <label>Luas Tanah (m²)</label>
                        <input type="number" class="form-control" id="luas_tanah" name="luas_tanah" required>
                    </div>
                    <div class="mb-3">
                        <label>Luas Bangunan (m²)</label>
                        <input type="number" class="form-control" id="luas_bangunan" name="luas_bangunan" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Kamar Tidur</label>
                        <input type="number" class="form-control" id="kamar_tidur" name="kamar_tidur" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Kamar Mandi</label>
                        <input type="number" class="form-control" id="kamar_mandi" name="kamar_mandi" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Lantai</label>
                        <input type="number" class="form-control" id="jumlah_lantai" name="jumlah_lantai" required>
                    </div>
                    <div class="mb-3">
                        <label>Pilih Wilayah</label>
                        <select class="form-control" id="region" name="region" required>
                            <option value="jakarta">Jakarta</option>
                            <option value="bandung">Bandung</option>
                            <option value="yogya">Yogyakarta</option>
                            <option value="surabaya">Surabaya</option>
                            <option value="bali">Bali</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Predict Price</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Hasil Prediksi -->
    <div id="predictionResult" class="container mt-4" style="display: none;">
        <div class="row justify-content-center">
            <div class="col-md-12 col-md-6">
                <div class="alert alert-primary text-center">
                    <h4>Hasil Prediksi</h4>
                    <p>Estimasi Harga:</p>
                    <h5 id="predictedPrice"></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div id="grafikSection" class="container mt-5" style="display: none;">
        <h4 class="text-center">Visualisasi Data</h4>
        <div id="grafikImages" class="row justify-content-center text-center gap-3">
            <!-- Dynamic Images Injected Here -->
        </div>
    </div>

    <!-- Styling -->
    <style>
        #typingText {
            font-size: 2rem;
            white-space: nowrap;
            overflow: hidden;
            border-right: .15em solid orange;
            width: fit-content;
            margin: 0 auto;
        }

        .hero-section {
            padding-top: 100px;
        }

        @media (max-width: 910px) {
            #typingText {
                font-size: 1.5rem;
                white-space: normal;
                word-break: break-word;
                border-right: none;
                animation: none;
            }
        }
    </style>

    <!-- Typing Effect -->
    <script>
        const text = "MULAI TAKSIR HARGA UNTUK RUMAH IMPIANMU";
        const typingElement = document.getElementById("typingText");
        let index = 0;
        let isDeleting = false;

        function type() {
            if (isDeleting) {
                typingElement.textContent = text.substring(0, index--);
            } else {
                typingElement.textContent = text.substring(0, index++);
            }

            if (!isDeleting && index === text.length) {
                setTimeout(() => isDeleting = true, 1000);
            } else if (isDeleting && index === 0) {
                isDeleting = false;
            }

            const speed = isDeleting ? 60 : 100;
            setTimeout(type, speed);
        }

        document.addEventListener("DOMContentLoaded", type);
    </script>

    <!-- Prediction Script -->
    <script>
        document.getElementById('predictionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const data = {
                luas_tanah: document.getElementById('luas_tanah').value,
                luas_bangunan: document.getElementById('luas_bangunan').value,
                kamar_tidur: document.getElementById('kamar_tidur').value,
                kamar_mandi: document.getElementById('kamar_mandi').value,
                jumlah_lantai: document.getElementById('jumlah_lantai').value,
                region: document.getElementById('region').value
            };

            try {
                const response = await fetch('https://api-taksirrumah.zero-dev.my.id/predict', {
                // const response = await fetch('http://127.0.0.1:5000/predict', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.predicted_price) {
                    document.getElementById('predictedPrice').textContent = '~ Rp ' + parseInt(result.predicted_price).toLocaleString();
                    document.getElementById('predictionResult').style.display = 'block';

                    const wilayah = data.region;
                    const wilayahCapitalized = wilayah.charAt(0).toUpperCase() + wilayah.slice(1);

                    const prefixMap = {
                        jakarta: "jkt",
                        bandung: "bdg",
                        yogya: "ygy",
                        surabaya: "sby",
                        bali: "bali"
                    };

                    const titleMap = {
                        'corr.png': `Korelasi Heatmap di ${wilayahCapitalized}`,
                        'LT_scatterlog.png': `Luas Tanah vs Harga di ${wilayahCapitalized}`,
                        'LB_scatterlog.png': `Luas Bangunan vs Harga di ${wilayahCapitalized}`
                    };

                    const imagesToShow = ['corr.png', 'LT_scatterlog.png', 'LB_scatterlog.png'];
                    const prefix = prefixMap[wilayah.toLowerCase()];
                    const grafikImages = document.getElementById('grafikImages');
                    grafikImages.innerHTML = ""; // Clear previous

                    imagesToShow.forEach((imgFile) => {
                        const imgPath = `/viz/${wilayah}/${prefix}_${imgFile}`;

                        const container = document.createElement('div');
                        container.className = 'col-md-6'; // Ensures image + title are aligned

                        const titleEl = document.createElement('h5');
                        titleEl.textContent = titleMap[imgFile] || "Visualisasi Data";
                        titleEl.className = 'mt-4 mb-2 text-start';

                        // Create the link to open image in full screen (new tab)
                        const linkEl = document.createElement('a');
                        linkEl.href = imgPath;    // Image path for the link
                        linkEl.target = '_blank'; // Open in a new tab

                        const imgEl = document.createElement('img');
                        imgEl.src = imgPath;
                        imgEl.className = 'img-fluid'; // Ensures responsive resizing

                        // const pathEl = document.createElement('p');
                        // pathEl.textContent = `Path: ${imgPath}`;
                        // pathEl.className = 'text-muted mt-2';

                        linkEl.appendChild(imgEl); // Add the image inside the link
                        container.appendChild(titleEl);
                        container.appendChild(linkEl);  // Append the link to container
                        // container.appendChild(pathEl);
                        grafikImages.appendChild(container);
                    });

                    document.getElementById('grafikSection').style.display = 'block';

                } else {
                    document.getElementById('predictedPrice').textContent =
                        'Terjadi kesalahan: ' + (result.error || 'Unknown error');
                }
            } catch (error) {
                document.getElementById('predictedPrice').textContent =
                    'Gagal menghubungi server Flask.';
                console.error(error);
            }
        });
    </script>

@endsection
