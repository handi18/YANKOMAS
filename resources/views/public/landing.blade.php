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
            margin: 0;
        }

        /* Background Layer Sama Dengan Login Petugas (Gambar + Gelap Transparan + Blur Ringan) */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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
    </style>
</head>
<body>
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
                                        <label class="form-label fw-medium">Nomor WhatsApp/Telepon</label>
                                        <input type="text" class="form-control" name="no_telp" value="{{ old('no_telp') }}" placeholder="Misal: 08xxxxxxxxxx">
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
                                            <option value="informasi" {{ old('jenis') == 'informasi' ? 'selected' : '' }}>Permintaan Informasi</option>
                                            <option value="pengaduan" {{ old('jenis') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                            <option value="custom" {{ old('jenis') == 'custom' ? 'selected' : '' }}>Lainnya (Kustom)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6" id="jenis_custom_div" style="display: none;">
                                        <label class="form-label fw-medium text-info">Sebutkan Jenis Kustom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border-info" name="jenis_custom" value="{{ old('jenis_custom') }}">
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
                                    </div>
                                    
                                    <div class="col-md-6" id="kategori_custom_div" style="display: none;">
                                        <label class="form-label fw-medium text-warning">Sebutkan Kategori Kustom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border-warning" name="kategori_custom" value="{{ old('kategori_custom') }}">
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
                                    </div>

                                    <div class="col-md-6" id="layanan_custom_div" style="display: none;">
                                        <label class="form-label fw-medium text-info">Sebutkan Layanan Kustom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border-info" name="layanan_custom" value="{{ old('layanan_custom') }}">
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
                            
                            <!-- Notifikasi Nomor Tiket Terakhir (Dari LocalStorage) -->
                            <div id="lastTicketAlert" class="alert d-none mb-4" style="background: rgba(0, 153, 255, 0.1); border: 1px solid rgba(0, 153, 255, 0.3); color: #e6f2ff; border-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-history me-2 text-info"></i> Tiket Terakhir Anda: <strong id="lastTicketNumberText" class="text-info fs-5 tracking-wide"></strong>
                                    </div>
                                    <button class="btn btn-sm btn-outline-info rounded-pill px-3" onclick="useLastTicket()">
                                        <i class="fas fa-check-circle me-1"></i> Gunakan
                                    </button>
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
            // Simpan ke localStorage secara otomatis
            localStorage.setItem('yankomas_last_ticket', '{{ session('success_ticket') }}');
            
            Swal.fire({
                title: 'Berhasil Dikirim!',
                html: 'Laporan Anda telah diterima.<br><br>Mohon simpan/salin Nomor Tiket Anda:<br><strong style="font-size: 28px; color: #0066cc; display: block; margin: 15px 0;">{{ session('success_ticket') }}</strong>',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-copy me-1"></i> Salin Nomor',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#0066cc',
                cancelButtonColor: '#6c757d',
                background: '#fff',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    navigator.clipboard.writeText('{{ session('success_ticket') }}');
                    Swal.fire({
                        title: 'Tersalin!',
                        text: 'Nomor tiket {{ session('success_ticket') }} berhasil disalin ke clipboard.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#fff'
                    });
                }
            });
        @endif

        // Cek LocalStorage untuk Tiket Terakhir
        document.addEventListener('DOMContentLoaded', function() {
            var lastTicket = localStorage.getItem('yankomas_last_ticket');
            if (lastTicket) {
                document.getElementById('lastTicketNumberText').innerText = lastTicket;
                document.getElementById('lastTicketAlert').classList.remove('d-none');
            }
        });

        function useLastTicket() {
            var lastTicket = localStorage.getItem('yankomas_last_ticket');
            if(lastTicket) {
                document.querySelector('input[name="tiket"]').value = lastTicket;
                // Optional: langsung submit otomatis
                // document.querySelector('input[name="tiket"]').closest('form').submit();
            }
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
            
            if(jenis === 'pengaduan' || jenis === 'custom') {
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
