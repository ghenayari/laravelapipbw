<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h1">EduAPI - Platform Kursus</span>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-secondary">Daftar Kursus Tersedia</h2>

    <div class="row" id="course-container">
        <div class="col-12 text-center" id="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Mengambil data dari API...</p>
        </div>
    </div>
</div>

<script>
    // 1. Menembak URL API yang sudah kamu buat
    fetch('/api/courses')
        .then(response => response.json()) // 2. Mengubah respons menjadi format JSON
        .then(result => {
            const courseContainer = document.getElementById('course-container');
            courseContainer.innerHTML = ''; // 3. Hapus animasi loading

            // 4. Jika statusnya success, lakukan perulangan untuk setiap data kursus
            if(result.status === 'success') {
                result.data.forEach(course => {

                    // 5. Membuat desain Card (Kartu) untuk setiap kursus
                    const cardHTML = `
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold">${course.title}</h5>
                                        <h6 class="card-subtitle mb-3 text-muted">
                                            Pengajar: <span class="text-dark fw-semibold">${course.instructor.name}</span> <br>
                                            <span class="badge bg-secondary mt-1">${course.instructor.expertise}</span>
                                        </h6>
                                        <hr>
                                        <p class="card-text">${course.description}</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 pt-0">
                                        <button class="btn btn-outline-primary w-100">Daftar Sekarang</button>
                                    </div>
                                </div>
                            </div>
                        `;

                    // 6. Masukkan kartu yang sudah jadi ke dalam container
                    courseContainer.innerHTML += cardHTML;
                });
            }
        })
        .catch(error => {
            // Jika terjadi error (misal server mati)
            console.error('Error fetching data:', error);
            document.getElementById('course-container').innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">Gagal memuat data kursus dari API.</div>
                    </div>
                `;
        });
</script>
</body>
</html>
