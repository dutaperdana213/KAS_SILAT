<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'kas_silat';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Password yang akan digunakan (admin123)
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    
    echo "Hash password untuk 'admin123': " . $hashed_password . "<br><br>";
    
    // Update semua user
    $sql = "UPDATE users SET password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':password' => $hashed_password]);
    
    echo "✅ Password semua user berhasil diupdate menjadi 'admin123'<br>";
    echo "Jumlah user terupdate: " . $stmt->rowCount() . " user<br><br>";
    
    // Tampilkan data users
    $users = $pdo->query("SELECT id, username, nama_lengkap, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
    echo "Data Users:<br>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Nama</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['nama_lengkap'] . "</td>";
        echo "<td>" . $user['role'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>