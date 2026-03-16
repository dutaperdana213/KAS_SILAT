-- Database: kas_silat (VERSI FINAL - TANPA NO TRANSAKSI & NO ANGGOTA)
-- Nama Sekolah: SMPN 1 Suranenggala
-- Perguruan: Singa Barwang
-- Version: 4.0 (Final Version - No Transaction Number & No Member Number)

CREATE DATABASE IF NOT EXISTS kas_silat;
USE kas_silat;

-- ======================================================
-- TABEL USERS
-- ======================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'bendahara', 'pembina') NOT NULL DEFAULT 'pembina',
    foto_profil VARCHAR(255) DEFAULT 'default.jpg',
    remember_token VARCHAR(255) NULL,
    token_expiry DATETIME NULL,
    reset_token VARCHAR(255) NULL,
    reset_expiry DATETIME NULL,
    last_login DATETIME NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABEL ANGGOTA (TANPA NO_ANGGOTA)
-- ======================================================
CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas ENUM('7', '8', '9') NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    no_hp VARCHAR(15),
    tanggal_gabung DATE NOT NULL,
    status_aktif TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABEL KAS MASUK (TANPA NO_TRANSAKSI)
-- ======================================================
CREATE TABLE kas_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    anggota_id INT NOT NULL,
    jumlah DECIMAL(15,2) NOT NULL,
    metode ENUM('Tunai', 'Transfer Bank', 'E-Wallet') NOT NULL,
    keterangan TEXT,
    bukti_transfer VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (anggota_id) REFERENCES anggota(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABEL KAS KELUAR (TANPA NO_TRANSAKSI)
-- ======================================================
CREATE TABLE kas_keluar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan TEXT NOT NULL,
    jumlah DECIMAL(15,2) NOT NULL,
    penanggung_jawab VARCHAR(100) NOT NULL,
    kategori ENUM('Operasional', 'Peralatan', 'Konsumsi', 'Dokumentasi', 'Lainnya') NOT NULL,
    bukti_pengeluaran VARCHAR(255),
    approved_by INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABEL LOG AKTIVITAS
-- ======================================================
CREATE TABLE log_aktivitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    aktivitas VARCHAR(255) NOT NULL,
    tabel VARCHAR(50),
    data_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- INSERT DATA AWAL USERS (password: admin123)
-- ======================================================
INSERT INTO users (username, password, nama_lengkap, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@smpn1suranenggala.sch.id', 'admin'),
('bendahara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bendahara', 'bendahara@smpn1suranenggala.sch.id', 'bendahara'),
('pembina', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pembina Silat', 'pembina@smpn1suranenggala.sch.id', 'pembina');

-- ======================================================
-- INSERT DATA ANGGOTA CONTOH (TANPA NO_ANGGOTA)
-- ======================================================
INSERT INTO anggota (nama, kelas, jenis_kelamin, no_hp, tanggal_gabung, status_aktif) VALUES
('Ahmad Fauzi', '7', 'L', '081234567890', '2024-01-15', 1),
('Budi Santoso', '7', 'L', '081234567891', '2024-01-15', 1),
('Citra Dewi', '7', 'P', '081234567892', '2024-01-16', 1),
('Dian Permata', '8', 'P', '081234567893', '2024-01-16', 1),
('Eko Prasetyo', '8', 'L', '081234567894', '2024-01-17', 1),
('Fitri Handayani', '8', 'P', '081234567895', '2024-01-17', 1),
('Galih Pratama', '9', 'L', '081234567896', '2024-01-18', 1),
('Hesti Nuraini', '9', 'P', '081234567897', '2024-01-18', 1),
('Indra Wijaya', '9', 'L', '081234567898', '2024-01-19', 1),
('Joko Susilo', '7', 'L', '081234567899', '2024-01-19', 1);

-- ======================================================
-- INSERT DATA KAS MASUK - JANUARI 2026 (12 PERTEMUAN × Rp 2.000)
-- ======================================================
-- ANGGOTA 1 (Ahmad Fauzi) - ID akan otomatis 1
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 1, 2000, 'Tunai', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 1, 2000, 'Tunai', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 1, 2000, 'Tunai', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 1, 2000, 'Tunai', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 1, 2000, 'Tunai', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 1, 2000, 'Tunai', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 1, 2000, 'Tunai', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 1, 2000, 'Tunai', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 1, 2000, 'Tunai', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 1, 2000, 'Tunai', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 1, 2000, 'Tunai', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 1, 2000, 'Tunai', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 2 (Budi Santoso) - ID 2
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 2, 2000, 'Tunai', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 2, 2000, 'Tunai', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 2, 2000, 'Tunai', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 2, 2000, 'Tunai', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 2, 2000, 'Tunai', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 2, 2000, 'Tunai', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 2, 2000, 'Tunai', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 2, 2000, 'Tunai', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 2, 2000, 'Tunai', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 2, 2000, 'Tunai', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 2, 2000, 'Tunai', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 2, 2000, 'Tunai', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 3 (Citra Dewi) - ID 3
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 3, 2000, 'Transfer Bank', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 4 (Dian Permata) - ID 4
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 4, 2000, 'Tunai', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 4, 2000, 'Tunai', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 4, 2000, 'Tunai', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 4, 2000, 'Tunai', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 4, 2000, 'Tunai', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 4, 2000, 'Tunai', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 4, 2000, 'Tunai', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 4, 2000, 'Tunai', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 4, 2000, 'Tunai', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 4, 2000, 'Tunai', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 4, 2000, 'Tunai', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 4, 2000, 'Tunai', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 5 (Eko Prasetyo) - ID 5
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 5, 2000, 'E-Wallet', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 6 (Fitri Handayani) - ID 6
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 6, 2000, 'E-Wallet', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 7 (Galih Pratama) - ID 7
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 7, 2000, 'Tunai', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 7, 2000, 'Tunai', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 7, 2000, 'Tunai', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 7, 2000, 'Tunai', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 7, 2000, 'Tunai', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 7, 2000, 'Tunai', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 7, 2000, 'Tunai', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 7, 2000, 'Tunai', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 7, 2000, 'Tunai', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 7, 2000, 'Tunai', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 7, 2000, 'Tunai', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 7, 2000, 'Tunai', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 8 (Hesti Nuraini) - ID 8
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 8, 2000, 'Transfer Bank', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 9 (Indra Wijaya) - ID 9
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 9, 2000, 'E-Wallet', 'Iuran pertemuan ke-12 Januari 2026');

-- ANGGOTA 10 (Joko Susilo) - ID 10
INSERT INTO kas_masuk (tanggal, anggota_id, jumlah, metode, keterangan) VALUES
('2026-01-05', 10, 2000, 'Tunai', 'Iuran pertemuan ke-1 Januari 2026'),
('2026-01-06', 10, 2000, 'Tunai', 'Iuran pertemuan ke-2 Januari 2026'),
('2026-01-07', 10, 2000, 'Tunai', 'Iuran pertemuan ke-3 Januari 2026'),
('2026-01-08', 10, 2000, 'Tunai', 'Iuran pertemuan ke-4 Januari 2026'),
('2026-01-09', 10, 2000, 'Tunai', 'Iuran pertemuan ke-5 Januari 2026'),
('2026-01-12', 10, 2000, 'Tunai', 'Iuran pertemuan ke-6 Januari 2026'),
('2026-01-13', 10, 2000, 'Tunai', 'Iuran pertemuan ke-7 Januari 2026'),
('2026-01-14', 10, 2000, 'Tunai', 'Iuran pertemuan ke-8 Januari 2026'),
('2026-01-15', 10, 2000, 'Tunai', 'Iuran pertemuan ke-9 Januari 2026'),
('2026-01-16', 10, 2000, 'Tunai', 'Iuran pertemuan ke-10 Januari 2026'),
('2026-01-19', 10, 2000, 'Tunai', 'Iuran pertemuan ke-11 Januari 2026'),
('2026-01-20', 10, 2000, 'Tunai', 'Iuran pertemuan ke-12 Januari 2026');

-- ======================================================
-- INSERT DATA KAS KELUAR CONTOH (TANPA NO_TRANSAKSI)
-- ======================================================
INSERT INTO kas_keluar (tanggal, keterangan, jumlah, penanggung_jawab, kategori, approved_by) VALUES
('2026-01-25', 'Pembelian alat tulis untuk administrasi', 150000, 'Budi Santoso', 'Operasional', 2),
('2026-01-28', 'Konsumsi rapat koordinasi', 200000, 'Ahmad Fauzi', 'Konsumsi', 2),
('2026-02-05', 'Pembelian properti latihan', 350000, 'Galih Pratama', 'Peralatan', 2),
('2026-02-15', 'Dokumentasi kegiatan', 100000, 'Citra Dewi', 'Dokumentasi', NULL),
('2026-02-20', 'Biaya transportasi lomba', 250000, 'Eko Prasetyo', 'Lainnya', 2);

-- ======================================================
-- TRIGGER UNTUK KAS MASUK & KELUAR (DIHAPUS - TIDAK DIGUNAKAN)
-- ======================================================
DROP TRIGGER IF EXISTS trg_before_insert_anggota$$
DROP TRIGGER IF EXISTS trg_before_insert_kas_masuk$$
DROP TRIGGER IF EXISTS trg_before_insert_kas_keluar$$

-- ======================================================
-- VIEW UNTUK LAPORAN (TANPA NO_TRANSAKSI)
-- ======================================================
DROP VIEW IF EXISTS v_ringkasan_kas_harian;
CREATE VIEW v_ringkasan_kas_harian AS
SELECT 
    DATE(tanggal) as tgl,
    SUM(CASE WHEN jenis = 'masuk' THEN jumlah ELSE 0 END) as total_masuk,
    SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END) as total_keluar,
    SUM(CASE WHEN jenis = 'masuk' THEN jumlah ELSE -jumlah END) as saldo_akhir
FROM (
    SELECT tanggal, jumlah, 'masuk' as jenis FROM kas_masuk
    UNION ALL
    SELECT tanggal, jumlah, 'keluar' as jenis FROM kas_keluar
) AS semua_transaksi
GROUP BY DATE(tanggal)
ORDER BY tgl DESC;

DROP VIEW IF EXISTS v_statistik_anggota;
CREATE VIEW v_statistik_anggota AS
SELECT 
    kelas,
    COUNT(*) as jumlah_anggota,
    SUM(CASE WHEN status_aktif = 1 THEN 1 ELSE 0 END) as anggota_aktif,
    SUM(CASE WHEN status_aktif = 0 THEN 1 ELSE 0 END) as anggota_nonaktif
FROM anggota
GROUP BY kelas
ORDER BY kelas;

-- ======================================================
-- PROCEDURE UNTUK LAPORAN BULANAN (TANPA NO_TRANSAKSI)
-- ======================================================
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_laporan_bulanan$$
CREATE PROCEDURE sp_laporan_bulanan(
    IN p_tahun INT,
    IN p_bulan INT
)
BEGIN
    -- Kas Masuk Bulanan
    SELECT 
        'MASUK' as tipe,
        km.tanggal,
        a.nama as anggota,
        km.keterangan,
        km.jumlah,
        km.metode,
        u.nama_lengkap as petugas
    FROM kas_masuk km
    JOIN anggota a ON km.anggota_id = a.id
    LEFT JOIN users u ON km.created_by = u.id
    WHERE YEAR(km.tanggal) = p_tahun AND MONTH(km.tanggal) = p_bulan
    
    UNION ALL
    
    -- Kas Keluar Bulanan
    SELECT 
        'KELUAR' as tipe,
        kk.tanggal,
        kk.penanggung_jawab as anggota,
        kk.keterangan,
        -kk.jumlah as jumlah,
        kk.kategori as metode,
        u.nama_lengkap as petugas
    FROM kas_keluar kk
    LEFT JOIN users u ON kk.created_by = u.id
    WHERE YEAR(kk.tanggal) = p_tahun AND MONTH(kk.tanggal) = p_bulan
    
    ORDER BY tanggal;
END$$

-- ======================================================
-- FUNCTION UNTUK MENGHITUNG SALDO
-- ======================================================
DROP FUNCTION IF EXISTS f_hitung_saldo$$
CREATE FUNCTION f_hitung_saldo(
    p_tanggal DATE
)
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    DECLARE total_masuk DECIMAL(15,2);
    DECLARE total_keluar DECIMAL(15,2);
    
    SELECT COALESCE(SUM(jumlah), 0) INTO total_masuk
    FROM kas_masuk
    WHERE tanggal <= p_tanggal;
    
    SELECT COALESCE(SUM(jumlah), 0) INTO total_keluar
    FROM kas_keluar
    WHERE tanggal <= p_tanggal;
    
    RETURN total_masuk - total_keluar;
END$$

DELIMITER ;

-- ======================================================
-- INDEX UNTUK OPTIMASI
-- ======================================================
CREATE INDEX idx_anggota_kelas ON anggota(kelas);
CREATE INDEX idx_anggota_status ON anggota(status_aktif);
CREATE INDEX idx_kas_masuk_tanggal ON kas_masuk(tanggal);
CREATE INDEX idx_kas_masuk_anggota ON kas_masuk(anggota_id);
CREATE INDEX idx_kas_keluar_tanggal ON kas_keluar(tanggal);
CREATE INDEX idx_kas_keluar_kategori ON kas_keluar(kategori);
CREATE INDEX idx_log_aktivitas_created ON log_aktivitas(created_at);