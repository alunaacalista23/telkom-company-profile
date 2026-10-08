<?php 
require_once 'config/database.php';

// Validasi method Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// Ambil dan bersihkan data input
$nama  = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');

// Validasi kelengkapan data dan format email
if ($nama === '' || $pesan === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Data tidak valid. Silakan kembali dan periksa input.');
}

// Simpan data ke database
$stmt = $conn->prepare("INSERT INTO pesan (nama, email, pesan) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $nama, $email, $pesan);
$stmt->execute();

// Redirect dengan status sukses
header('Location: contact.php?success=1');
exit;