<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= $sekolah ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        
        /* Kop Surat */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            position: relative;
            min-height: 100px;
        }
        
        .logo-sekolah {
            position: absolute;
            left: 0;
            top: 0;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-sekolah img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        
        .logo-perguruan {
            position: absolute;
            right: 0;
            top: 0;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-perguruan img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
        }
        
        .kop-text {
            margin: 0 120px;
        }
        
        .kop-text h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .kop-text h3 {
            margin: 5px 0;
            font-weight: normal;
            color: #7f8c8d;
        }
        
        .kop-text p {
            margin: 5px 0;
            color: #3498db;
            font-weight: bold;
        }
        
        .alamat {
            font-size: 11px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .header {
            text-align: center;
            margin: 30px 0 20px;
        }
        
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-decoration: underline;
        }
        
        .header p {
            margin: 5px 0;
            color: #555;
        }
        
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        
        .info-section table {
            width: 100%;
        }
        
        .info-section td {
            padding: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #2c3e50;
            color: white;
            padding: 10px;
            font-size: 12px;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .text-end {
            text-align: right;
        }
        
        .text-success {
            color: #28a745;
            font-weight: bold;
        }
        
        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }
        
        /* Tanda Tangan - DIPERBAIKI JARAKNYA */
        .ttd-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        
        .ttd-box {
            width: 45%;
            text-align: center;
        }
        
        .ttd-box .jabatan {
            margin-bottom: 40px; /* Jarak diperbesar dari 15px menjadi 40px */
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2c3e50;
        }
        
        .ttd-box .nama {
            font-size: 14px;
            color: #2c3e50;
            letter-spacing: 3px;
            margin-top: 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #777;
        }
        
        .badge {
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 11px;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- KOP SURAT DENGAN LOGO -->
    <div class="kop-surat">
        <!-- Logo Sekolah (kiri) - TANPA LINGKARAN -->
        <div class="logo-sekolah">
            <img src="<?= BASE_URL ?>/assets/img/logo-sekolah.jpg" alt="Logo Sekolah">
        </div>
        
        <!-- Logo Perguruan (kanan) - DENGAN LINGKARAN -->
        <div class="logo-perguruan">
            <img src="<?= BASE_URL ?>/assets/img/logo-perguruan.jpg" alt="Logo Perguruan">
        </div>
        
        <!-- Teks Kop -->
        <div class="kop-text">
            <h1><?= $sekolah ?></h1>
            <h3><?= $perguruan ?></h3>
            <p>EKSTRAKURIKULER SILAT</p>
            <div class="alamat">
                Jl. Sunan Gunung Jati Km. 10, RT. 01 RW. 03, Desa Keraton, Kec. Suranenggala, Kabupaten Cirebon, Jawa Barat, 45159.
                <br>Email: smpn.1suranenggala@gmail.com | Telp: (0231) 8228341
            </div>
        </div>
    </div>
    
    <!-- Judul Laporan -->
    <div class="header">
        <h2><?= $title ?></h2>
        <p>Periode: <?= formatTanggal($start_date, 'date') ?> s/d <?= formatTanggal($end_date, 'date') ?></p>
    </div>
    
    <!-- Ringkasan -->
    <div class="info-section">
        <table>
            <tr>
                <td width="25%"><strong>Total Kas Masuk:</strong></td>
                <td width="25%"><?= formatRupiah($ringkasan['total_masuk'] ?? 0) ?></td>
                <td width="25%"><strong>Total Kas Keluar:</strong></td>
                <td width="25%"><?= formatRupiah($ringkasan['total_keluar'] ?? 0) ?></td>
            </tr>
            <tr>
                <td><strong>Saldo Awal:</strong></td>
                <td><?= formatRupiah($ringkasan['saldo_awal'] ?? 0) ?></td>
                <td><strong>Saldo Akhir:</strong></td>
                <td><?= formatRupiah($ringkasan['saldo_akhir'] ?? 0) ?></td>
            </tr>
        </table>
    </div>
    
    <!-- Detail Laporan -->
    <?php if ($jenis == 'kas_masuk'): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Anggota</th>
                <th>Kelas</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan)): ?>
            <tr>
                <td colspan="7" style="text-align:center">Tidak ada data</td>
            </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach ($laporan as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= formatTanggal($item['tanggal'], 'date') ?></td>
                    <td><?= $item['nama_anggota'] ?? '-' ?></td>
                    <td><?= $item['kelas'] ?? '-' ?></td>
                    <td><?= $item['keterangan'] ?? '-' ?></td>
                    <td class="text-end text-success"><?= formatRupiah($item['jumlah']) ?></td>
                    <td><?= $item['metode'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">TOTAL</th>
                <th class="text-end text-success"><?= formatRupiah($ringkasan['total_masuk'] ?? 0) ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    
    <?php elseif ($jenis == 'kas_keluar'): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Penanggung Jawab</th>
                <th>Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan)): ?>
            <tr>
                <td colspan="7" style="text-align:center">Tidak ada data</td>
            </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach ($laporan as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= formatTanggal($item['tanggal'], 'date') ?></td>
                    <td><?= $item['keterangan'] ?? '-' ?></td>
                    <td class="text-end text-danger"><?= formatRupiah($item['jumlah']) ?></td>
                    <td><?= $item['penanggung_jawab'] ?? '-' ?></td>
                    <td><?= $item['kategori'] ?? '-' ?></td>
                    <td>
                        <?php if (isset($item['penyetuju']) && $item['penyetuju']): ?>
                            <span class="badge badge-success">Disetujui</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Menunggu</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">TOTAL</th>
                <th class="text-end text-danger"><?= formatRupiah($ringkasan['total_keluar'] ?? 0) ?></th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
    
    <?php elseif ($jenis == 'rekap_anggota'): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Jumlah Bayar</th>
                <th>Total Iuran</th>
                <th>Total Sebelumnya</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan)): ?>
            <tr>
                <td colspan="7" style="text-align:center">Tidak ada data</td>
            </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php 
                $totalIuranKeseluruhan = 0;
                $totalBayarKeseluruhan = 0;
                ?>
                <?php foreach ($laporan as $item): ?>
                <?php 
                    $totalIuranKeseluruhan += $item['total_bayar'] ?? 0;
                    $totalBayarKeseluruhan += $item['jumlah_bayar'] ?? 0;
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $item['nama'] ?? '-' ?></td>
                    <td><?= $item['kelas'] ?? '-' ?></td>
                    <td><?= ($item['status_aktif'] ?? 0) ? 'Aktif' : 'Non Aktif' ?></td>
                    <td class="text-center"><?= ($item['jumlah_bayar'] ?? 0) ?>x</td>
                    <td class="text-end text-success"><?= formatRupiah($item['total_bayar'] ?? 0) ?></td>
                    <td class="text-end"><?= formatRupiah($item['total_sebelumnya'] ?? 0) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="4" class="text-end">TOTAL</td>
                <td class="text-center"><?= $totalBayarKeseluruhan ?>x</td>
                <td class="text-end text-success"><?= formatRupiah($totalIuranKeseluruhan) ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
    
    <!-- TANDA TANGAN (HANYA PEMBINA DAN BENDAHARA) -->
    <div class="ttd-section">
        <!-- Tanda Tangan Pembina -->
        <div class="ttd-box">
            <div class="jabatan">Pembina</div>
            <div class="nama">( _____________________ )</div>
        </div>
        
        <!-- Tanda Tangan Bendahara -->
        <div class="ttd-box">
            <div class="jabatan">Bendahara</div>
            <div class="nama">( _____________________ )</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?> | <?= $sekolah ?> - <?= $perguruan ?></p>
        <p class="no-print">© <?= date('Y') ?> <?= $sekolah ?>. All rights reserved.</p>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>