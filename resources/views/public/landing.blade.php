<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YANKOMAS - Layanan Pengaduan Imigrasi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_imigrasi_Bandung.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            overflow-y: scroll; /* FIX PC: Mencegah layar bergeser/mengecil saat scrollbar muncul */
            margin: 0;
        }

        /* Background Layer Sama Dengan Login Petugas (Gambar + Gelap Transparan + Blur Ringan) */
        body::before {
            content: "";
            position: fixed;
            top: -5%;
            left: -5%;
            width: 110%;
            /* FIX HP: Gunakan lvh/svh agar background tidak melar/membesar saat address bar HP otomatis sembunyi waktu scroll */
            height: 110vh; 
            height: 110lvh; 
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.4) 100%), 
                        url('{{ asset('assets/img/Ditjen_Imigrasi.jpeg') }}') no-repeat center center;
            background-size: cover;
            filter: blur(4px);
            transform: scale(1.05);
            z-index: -1;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
            color: #fff;
        }

        .nav-tabs {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            padding: 15px 25px;
            transition: all 0.3s;
        }
        
        .nav-tabs .nav-link:hover {
            color: #fff;
            border-color: transparent;
        }
        
        .nav-tabs .nav-link.active {
            background: transparent;
            color: #fff;
            border-color: transparent;
            border-bottom: 3px solid #0099ff;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #0099ff;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(0, 153, 255, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Specifically for dropdown options */
        option {
            background: rgba(30, 30, 30, 0.95); /* Gelap transparan */
            color: #fff;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #0066cc 0%, #0099ff 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 153, 255, 0.4);
            color: white;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .hero-section img {
            height: 80px;
            margin-bottom: 20px;
        }

        .ticket-result {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            border-left: 5px solid #0099ff;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-baru { background: rgba(0, 153, 255, 0.2); color: #66b3ff; border: 1px solid rgba(102, 179, 255, 0.5); }
        .status-diproses { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.5); }
        .status-selesai { background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.5); }
        
        .login-petugas-icon {
            position: absolute;
            top: 20px;
            right: 25px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 1.3rem;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .login-petugas-icon:hover {
            color: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Ikon Rahasia untuk Login Petugas (Pojok Kanan Atas) -->
    <a href="{{ route('login') }}" class="login-petugas-icon" title="Login Petugas">
        <i class="fas fa-user-shield"></i>
    </a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="glass-container">
                    
                    <div class="hero-section">
                        <div class="d-flex justify-content-center gap-4 align-items-center">
                            <img src="{{ asset('assets/img/logo_imigrasi_RI.png') }}" alt="Logo Imigrasi">
                            <img src="{{ asset('assets/img/logo_imigrasi_Bandung.png') }}" alt="Logo Imigrasi Bandung">
                        </div>
                        <h2 class="mt-3 fw-bold">YANKOMAS</h2>
                        <p class="text-white-50">Sistem Pelayanan Saran, Informasi, dan Pengaduan Internal<br>Kantor Imigrasi Kelas I TPI Kota Bandung</p>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs justify-content-center" id="yankomasTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $searchPerformed ? '' : 'active' }}" id="lapor-tab" data-bs-toggle="tab" data-bs-target="#lapor" type="button" role="tab">
                                <i class="fas fa-edit me-2"></i> Buat Laporan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $searchPerformed ? 'active' : '' }}" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" type="button" role="tab">
                                <i class="fas fa-search me-2"></i> Cek Status
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="yankomasTabsContent">
                        
                        <!-- TAB: LAPOR -->
                        <div class="tab-pane fade {{ $searchPerformed ? '' : 'show active' }}" id="lapor" role="tabpanel">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.2); color: #ffcccc; border: 1px solid rgba(220, 53, 69, 0.5);">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('public.store') }}" method="POST">
                                @csrf
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_pengadu" value="{{ old('nama_pengadu') }}" placeholder="Masukkan nama Anda" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Nomor WhatsApp/Telepon (opsional)</label>
                                        <input type="tel" class="form-control" name="no_telp" value="{{ old('no_telp') }}" placeholder="Misal: 081234567890" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Tanggal Kejadian <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="tanggal_kejadian" id="tanggal_kejadian" value="{{ old('tanggal_kejadian', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Waktu/Jam Kejadian <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" name="jam_kejadian" value="{{ old('jam_kejadian', date('H:i')) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Jenis Laporan <span class="text-danger">*</span></label>
                                        <select class="form-select" name="jenis" id="jenis" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="saran" {{ old('jenis') == 'saran' ? 'selected' : '' }}>Saran</option>
                                            <option value="informasi" {{ old('jenis') == 'informasi' ? 'selected' : '' }}>Informasi</option>
                                            <option value="pengaduan" {{ old('jenis') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                            <option value="custom" {{ old('jenis') == 'custom' ? 'selected' : '' }}>Lainnya (Kustom)</option>
                                        </select>
                                        
                                        <div id="jenis_custom_div" style="display: none;" class="mt-3">
                                            <label class="form-label fw-medium text-info">Sebutkan Jenis Kustom <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control border-info" name="jenis_custom" value="{{ old('jenis_custom') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="kategori_div" style="display: none;">
                                        <label class="form-label fw-medium text-warning">Kategori (Khusus Pengaduan) <span class="text-danger">*</span></label>
                                        <select class="form-select border-warning" name="kategori" id="kategori">
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="ringan" {{ old('kategori') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                            <option value="sedang" {{ old('kategori') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                            <option value="berat" {{ old('kategori') == 'berat' ? 'selected' : '' }}>Berat</option>
                                            <option value="custom" {{ old('kategori') == 'custom' ? 'selected' : '' }}>Lainnya (Kustom)</option>
                                        </select>
                                        
                                        <div id="kategori_custom_div" style="display: none;" class="mt-3">
                                            <label class="form-label fw-medium text-warning">Sebutkan Kategori Kustom <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control border-warning" name="kategori_custom" value="{{ old('kategori_custom') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Terkait Layanan <span class="text-danger">*</span></label>
                                        <select class="form-select" name="layanan_id" id="layanan_id" required>
                                            <option value="">-- Pilih Layanan --</option>
                                            @foreach($layanan as $l)
                                                <option value="{{ $l->id }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>{{ $l->nama_layanan }}</option>
                                            @endforeach
                                            <option value="custom" {{ old('layanan_id') == 'custom' ? 'selected' : '' }}>Lainnya (Kustom)</option>
                                        </select>
                                        
                                        <div id="layanan_custom_div" style="display: none;" class="mt-3">
                                            <label class="form-label fw-medium text-info">Sebutkan Layanan Kustom <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control border-info" name="layanan_custom" value="{{ old('layanan_custom') }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-medium">Detail / Isi Laporan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="isi_aspirasi" rows="4" placeholder="Ceritakan secara detail terkait saran, informasi, atau pengaduan Anda..." required>{{ old('isi_aspirasi') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5">
                                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB: CEK STATUS -->
                        <div class="tab-pane fade {{ $searchPerformed ? 'show active' : '' }}" id="status" role="tabpanel">
                            
                            <!-- Notifikasi Riwayat Tiket (Dari LocalStorage Array) -->
                            <div id="historyContainer" class="d-none mb-4">
                                <button class="btn btn-outline-light w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; padding: 12px 15px;">
                                    <span class="text-white-50"><i class="fas fa-history me-2"></i> Riwayat Laporan di Perangkat Ini</span>
                                    <i class="fas fa-chevron-down text-white-50"></i>
                                </button>
                                
                                <div class="collapse mt-2" id="collapseHistory">
                                    <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 15px;">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm mb-0 align-middle">
                                                <tbody id="historyList">
                                                    <!-- List history akan dimunculkan oleh Javascript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('home') }}" method="GET" class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" name="tiket" value="{{ $tiket_query }}" placeholder="Masukkan Nomor Tiket (cth: ASP-2026...)" required>
                                    <button class="btn btn-primary-custom" type="submit" style="border-radius: 0 10px 10px 0;">
                                        <i class="fas fa-search"></i> Cek Status
                                    </button>
                                </div>
                            </form>

                            @if($searchPerformed)
                                @if($aspirasiChecked)
                                    <div class="ticket-result">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="mb-0 fw-bold">{{ $aspirasiChecked->nomor_tiket }}</h4>
                                            
                                            @if($aspirasiChecked->status == 'Baru')
                                                <span class="status-badge status-baru"><i class="fas fa-inbox me-1"></i> Diterima</span>
                                            @elseif($aspirasiChecked->status == 'Diproses')
                                                <span class="status-badge status-diproses"><i class="fas fa-spinner fa-spin me-1"></i> Sedang Diproses</span>
                                            @else
                                                <span class="status-badge status-selesai"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                            @endif
                                        </div>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="mb-1 text-white-50">Tanggal Pelaporan</p>
                                                <p class="fw-medium">{{ $aspirasiChecked->created_at->format('d F Y') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-white-50">Jenis Laporan</p>
                                                <p class="fw-medium text-capitalize">{{ $aspirasiChecked->jenis == 'pengaduan' && $aspirasiChecked->jenis_custom ? $aspirasiChecked->jenis_custom : $aspirasiChecked->jenis }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-white-50">Layanan Terkait</p>
                                                <p class="fw-medium">{{ $aspirasiChecked->layanan ? $aspirasiChecked->layanan->nama_layanan : $aspirasiChecked->layanan_custom }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1 text-white-50">Petugas Penanggung Jawab</p>
                                                <p class="fw-medium">{{ $aspirasiChecked->petugas ? $aspirasiChecked->petugas->nama : 'Menunggu Penugasan' }}</p>
                                            </div>
                                        </div>
                                        
                                        <hr style="border-color: rgba(255,255,255,0.2);">
                                        <p class="mb-1 text-white-50">Isi Laporan:</p>
                                        <p class="fst-italic">"{{ $aspirasiChecked->isi_aspirasi }}"</p>
                                        
                                        @if($aspirasiChecked->jawaban)
                                            <div class="mt-4 p-3 rounded" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28a745;">
                                                <p class="mb-1 fw-bold text-success"><i class="fas fa-reply me-1"></i> Tanggapan / Jawaban Resmi:</p>
                                                <p class="mb-0" style="white-space: pre-wrap;">{{ $aspirasiChecked->jawaban }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center" style="background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.5); color: #ffe69c;">
                                        <i class="fas fa-exclamation-triangle fs-3 mb-2 d-block"></i>
                                        Nomor tiket <strong>{{ $tiket_query }}</strong> tidak ditemukan. Pastikan Anda memasukkan nomor tiket yang benar.
                                    </div>
                                @endif
                            @endif
                        </div>

                    </div> <!-- End Tab Content -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Flatpickr for Indonesian Date Format -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    
    <script>
        // Inisialisasi Flatpickr untuk input tanggal dengan format Hari-Bulan-Tahun
        flatpickr("#tanggal_kejadian", {
            altInput: true,
            altFormat: "d-m-Y",      // Tampilan yang dilihat pengguna (indo format)
            dateFormat: "Y-m-d",     // Format yang disubmit ke database
            locale: "id",            // Bahasa Indonesia
            maxDate: "today"         // Tidak bisa melebihi hari ini
        });
        // SweetAlert untuk pop up nomor tiket jika berhasil
        @if(session('success_ticket'))
            // Simpan ke localStorage secara otomatis sebagai array (Riwayat)
            var tickets = JSON.parse(localStorage.getItem('yankomas_tickets') || '[]');
            var newTicket = '{{ session('success_ticket') }}';
            if(!tickets.includes(newTicket)) {
                tickets.push(newTicket);
                localStorage.setItem('yankomas_tickets', JSON.stringify(tickets));
            }
            
            Swal.fire({
                title: 'Berhasil Dikirim!',
                html: 'Laporan Anda telah diterima.<br><br>Mohon simpan/salin Nomor Tiket Anda:<br><strong style="font-size: 28px; color: #0066cc; display: block; margin: 15px 0;">' + newTicket + '</strong>',
                icon: 'success',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-copy me-1"></i> Salin',
                denyButtonText: '<i class="fab fa-whatsapp me-1"></i> Kirim ke WA',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#0066cc',
                denyButtonColor: '#25D366',
                cancelButtonColor: '#6c757d',
                background: '#fff',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    navigator.clipboard.writeText(newTicket);
                    Swal.fire({
                        title: 'Tersalin!',
                        text: 'Nomor tiket ' + newTicket + ' berhasil disalin ke clipboard.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#fff'
                    });
                } else if (result.isDenied) {
                    var waText = "Halo, ini adalah Nomor Tiket laporan saya di YANKOMAS Imigrasi Bandung:\n\n*" + newTicket + "*\n\nSimpan pesan ini agar tiket tidak hilang saat Anda ingin mengecek statusnya di kemudian hari.";
                    window.open('https://wa.me/?text=' + encodeURIComponent(waText), '_blank');
                }
            });
        @endif

        // Cek LocalStorage untuk Riwayat Tiket
        document.addEventListener('DOMContentLoaded', function() {
            var tickets = JSON.parse(localStorage.getItem('yankomas_tickets') || '[]');
            
            // Migrasi dari memori versi lama jika masih ada tiket tunggal
            var oldTicket = localStorage.getItem('yankomas_last_ticket');
            if(oldTicket && !tickets.includes(oldTicket)) {
                tickets.push(oldTicket);
                localStorage.setItem('yankomas_tickets', JSON.stringify(tickets));
                localStorage.removeItem('yankomas_last_ticket'); // Bersihkan yang lama
            }

            if (tickets.length > 0) {
                document.getElementById('historyContainer').classList.remove('d-none');
                var historyList = document.getElementById('historyList');
                historyList.innerHTML = '';
                
                // Urutkan array agar tiket terbaru ada di atas
                tickets.slice().reverse().forEach(function(ticket) {
                    var tr = document.createElement('tr');
                    tr.className = 'bg-transparent';
                    tr.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
                    tr.innerHTML = `
                        <td class="text-white fw-bold py-3 fs-5 bg-transparent">${ticket}</td>
                        <td class="text-end py-3 bg-transparent">
                            <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-4" onclick="useTicket('${ticket}')">
                                <i class="fas fa-search me-1"></i> Cek Status
                            </button>
                        </td>
                    `;
                    historyList.appendChild(tr);
                });
            }
        });

        function useTicket(ticketNumber) {
            document.querySelector('input[name="tiket"]').value = ticketNumber;
            // Langsung klik tombol submit secara otomatis agar instan
            document.querySelector('input[name="tiket"]').closest('form').submit();
        }

        // Dynamic Form Logic (Menampilkan field custom jika dipilih)
        document.getElementById('jenis').addEventListener('change', function() {
            var jenis = this.value;
            
            // Tampilkan/Sembunyikan Jenis Custom
            document.getElementById('jenis_custom_div').style.display = (jenis === 'custom') ? 'block' : 'none';
            if(jenis === 'custom') document.querySelector('input[name="jenis_custom"]').required = true;
            else document.querySelector('input[name="jenis_custom"]').required = false;

            // Tampilkan/Sembunyikan Kategori (khusus pengaduan)
            var kategoriDiv = document.getElementById('kategori_div');
            var kategoriSelect = document.getElementById('kategori');
            
            if(jenis === 'pengaduan') {
                kategoriDiv.style.display = 'block';
                kategoriSelect.required = true;
            } else {
                kategoriDiv.style.display = 'none';
                kategoriSelect.required = false;
                kategoriSelect.value = '';
                document.getElementById('kategori_custom_div').style.display = 'none';
                document.querySelector('input[name="kategori_custom"]').required = false;
            }
        });

        document.getElementById('kategori').addEventListener('change', function() {
            var kategoriCustomDiv = document.getElementById('kategori_custom_div');
            var inputKategoriCustom = document.querySelector('input[name="kategori_custom"]');
            if(this.value === 'custom') {
                kategoriCustomDiv.style.display = 'block';
                inputKategoriCustom.required = true;
            } else {
                kategoriCustomDiv.style.display = 'none';
                inputKategoriCustom.required = false;
            }
        });

        document.getElementById('layanan_id').addEventListener('change', function() {
            var layananCustomDiv = document.getElementById('layanan_custom_div');
            var inputLayananCustom = document.querySelector('input[name="layanan_custom"]');
            if(this.value === 'custom') {
                layananCustomDiv.style.display = 'block';
                inputLayananCustom.required = true;
            } else {
                layananCustomDiv.style.display = 'none';
                inputLayananCustom.required = false;
            }
        });
        
        // Trigger event pada saat load (untuk handle old() input)
        document.getElementById('jenis').dispatchEvent(new Event('change'));
        document.getElementById('kategori').dispatchEvent(new Event('change'));
        document.getElementById('layanan_id').dispatchEvent(new Event('change'));
    </script>
</body>
</html>
