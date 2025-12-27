<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Barang - Stok Opname</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for the QR code scanner border and size */
        #reader {
            width: 100%;
            max-width: 400px; /* Limit scanner width for better mobile experience */
            margin: 0 auto; /* Center the scanner */
            border-radius: 0.75rem; /* rounded-xl */
            overflow: hidden; /* Ensure content respects border-radius */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* subtle shadow */
            background-color: #f3f4f6; /* gray-100 for scanner area */
        }
        /* Override default html5-qrcode styles for dashboard section */
        #reader__dashboard_section_csr {
            padding: 1rem; /* Adjust padding for controls */
            background-color: #ffffff; /* white background for controls */
            border-top: 1px solid #e5e7eb; /* gray-200 */
        }
        #reader__scan_region {
            min-height: 250px; /* Ensure sufficient height for scanner feed */
        }
        /* Ensure elements inside html5-qrcode are styled nicely */
        .html5-qrcode-element {
            /* Basic styling for scanner elements if needed */
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans antialiased">

    <div class="bg-white shadow-xl rounded-2xl p-6 sm:p-8 w-full max-w-4xl ring-1 ring-gray-100">

        <div class="flex items-center justify-between mb-8 border-b pb-4 border-gray-200">
            <div class="flex items-center gap-3">
                <img src="https://img.icons8.com/3d-fluency/94/qr-code.png" alt="QR Scan Icon" class="w-12 h-12">
                <h1 class="text-3xl font-extrabold text-gray-800">Scan Barang</h1>
            </div>
            <a href="home.php" class="text-blue-600 hover:text-blue-800 font-medium transition duration-150 ease-in-out flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                Kembali
            </a>
        </div>

        <div class="flex flex-col items-center gap-6 mb-8">
            <p class="text-gray-600 text-center text-lg">Arahkan kamera ke kode barang (barcode/QR code).</p>
            <div id="reader"></div>
        </div>

        <div id="result" class="bg-blue-50 border border-blue-200 p-6 rounded-lg mt-8 transition-all duration-300 ease-in-out hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-blue-800 text-xl flex items-center gap-2">
                    <img src="https://img.icons8.com/3d-fluency/48/open-box.png" alt="Box Icon" class="w-8 h-8">
                    Data Barang Ditemukan
                </h3>
                </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-gray-700">
                <p><strong>ID Barang:</strong> <span id="id_barang_display" class="font-semibold"></span></p>
                <input type="hidden" name="id_barang" id="id_barang_hidden">

                <p><strong>Kode Barang:</strong> <span id="kode_barang" class="font-semibold"></span></p>
                <p><strong>Nama Barang:</strong> <span id="nama_barang" class="font-semibold"></span></p>
                <p><strong>Kategori:</strong> <span id="kategori" class="font-semibold"></span></p>
                <p><strong>Jumlah Saat Ini:</strong> <span id="jumlah" class="font-semibold text-xl text-indigo-700"></span></p>
            </div>
        </div>

        <div id="form-so" class="hidden mt-6 bg-gray-50 border border-gray-200 p-6 rounded-lg transition-all duration-300 ease-in-out">
            <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center gap-2">
        
                Form Stok Opname
            </h3>
            <form id="formStokOpname" class="space-y-4">
                <input type="hidden" name="id_barang" id="id_barang_hidden_form">

                <div>
                    <label for="tanggal" class="block font-semibold mb-1 text-gray-700">Tanggal Stok Opname:</label>
                    <input type="date" name="tanggal" id="tanggal" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <div>
                    <label for="jumlah_so" class="block font-semibold mb-1 text-gray-700">Jumlah Hasil Stok Opname:</label>
                    <input type="number" name="jumlah" id="jumlah_so" required min="0" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <div>
                    <label for="catatan" class="block font-semibold mb-1 text-gray-700">Catatan (Opsional):</label>
                    <textarea name="catatan" id="catatan" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-y"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Stok Opname
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
    const resultDiv = document.getElementById('result');
    const kode = document.getElementById('kode_barang');
    const nama = document.getElementById('nama_barang');
    const kategori = document.getElementById('kategori');
    const jumlah = document.getElementById('jumlah');
    const idHidden = document.getElementById('id_barang_hidden');
    const idHiddenForm = document.getElementById('id_barang_hidden_form');

    function onScanSuccess(decodedText) {
        html5QrcodeScanner.clear().then(() => {
            const kode = decodedText.trim();
            fetch('ambil_barang.php?kode=' + encodeURIComponent(kode))
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.classList.remove('hidden');
                        document.getElementById('form-so').classList.remove('hidden');
                        kode_barang.innerText = data.data.kode_barang;
                        nama.innerText = data.data.nama_barang;
                        kategori.innerText = data.data.kategori;
                        jumlah.innerText = data.data.jumlah;
                        idHidden.value = data.data.id_barang;
                        idHiddenForm.value = data.data.id_barang;
                        document.getElementById('id_barang_display').innerText = data.data.id_barang;
                    } else {
                        alert("❌ Barang tidak ditemukan.");
                    }
                })
                .catch(() => alert("❌ Gagal mengambil data barang."));
        });
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 }, false
    );
    html5QrcodeScanner.render(onScanSuccess);

    // Submit form stok opname
    document.getElementById('formStokOpname').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('simpan_stok_opname.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(res => {
            if (res.trim() === "success") {
                alert("✅ Data stok opname berhasil disimpan!");
                this.reset();
                document.getElementById('form-so').classList.add('hidden');
                resultDiv.classList.add('hidden');
                // Aktifkan kamera lagi untuk scan berikutnya
                html5QrcodeScanner.render(onScanSuccess);
            } else {
                alert("❌ Gagal menyimpan stok opname!");
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("❌ Terjadi kesalahan saat menyimpan.");
        });
    });

</script>
</body>
</html>