<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">EduAPI - Platform Kursus</span>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <h5 class="card-title text-success mb-3">➕ Tambah Kursus Baru (Uji Coba POST API)</h5>
            <form id="formTambahKursus">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Judul Kursus</label>
                        <input type="text" class="form-control" id="inputTitle" placeholder="Misal: Mahir Vue JS" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">ID Pengajar</label>
                        <input type="number" class="form-control" id="inputInstructorId" placeholder="Masukkan Angka 1" required>
                        <small class="text-danger">*Isi dengan angka 1 (Berdasarkan ID di database)</small>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label text-muted">Deskripsi Singkat</label>
                        <input type="text" class="form-control" id="inputDesc" placeholder="Materi dasar web..." required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success px-4">Kirim Data ke API</button>
            </form>
        </div>
    </div>

    <hr class="mb-4">
    <h3 class="mb-3 text-secondary">Daftar Kursus (Hasil GET API)</h3>

    <div class="row" id="course-container">
        <div class="col-12 text-center" id="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. FUNGSI UNTUK MENAMPILKAN DATA (GET)
    function loadCourses() {
        const container = document.getElementById('course-container');
        container.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary"></div></div>';

        fetch('/api/courses')
            .then(response => response.json())
            .then(result => {
                container.innerHTML = ''; // Hapus loading

                if(result.status === 'success' && result.data.length > 0) {
                    result.data.forEach(course => {
                        const cardHTML = `
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary fw-bold">${course.title}</h5>
                                            <h6 class="card-subtitle mb-3 text-muted">
                                                Pengajar: <span class="text-dark fw-semibold">${course.instructor.name}</span> <br>
                                                <span class="badge bg-secondary mt-1">${course.instructor.expertise}</span>
                                            </h6>
                                            <p class="card-text">${course.description}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        container.innerHTML += cardHTML;
                    });
                } else {
                    container.innerHTML = '<div class="col-12"><div class="alert alert-warning">Belum ada data kursus.</div></div>';
                }
            })
            .catch(err => console.error('Gagal mengambil data:', err));
    }

    // Panggil fungsi tampil data pertama kali saat web dibuka
    loadCourses();

    // 2. FUNGSI UNTUK MENAMBAH DATA (POST)
    document.getElementById('formTambahKursus').addEventListener('submit', function(e) {
        e.preventDefault(); // Cegah halaman reload saat tombol diklik

        // Ambil nilai dari inputan
        const titleData = document.getElementById('inputTitle').value;
        const instructorIdData = document.getElementById('inputInstructorId').value;
        const descData = document.getElementById('inputDesc').value;

        // Tembak API menggunakan method POST
        fetch('/api/courses', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json' // Penting agar Laravel tahu ini request API
            },
            body: JSON.stringify({
                title: titleData,
                instructor_id: instructorIdData,
                description: descData
            })
        })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Sukses! Data kursus baru berhasil disimpan via API.');
                    document.getElementById('formTambahKursus').reset(); // Kosongkan form
                    loadCourses(); // Refresh daftar kursus secara instan tanpa reload halaman!
                } else {
                    alert('Gagal menyimpan. Pastikan ID Pengajar benar-benar ada di database!');
                }
            })
            .catch(err => console.error('Gagal mengirim data:', err));
    });
</script>
</body>
</html>
