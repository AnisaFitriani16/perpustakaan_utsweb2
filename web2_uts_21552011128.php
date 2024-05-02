<!DOCTYPE html>
<html>
<head>
    <title>Sistem Perpustakaan</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
}
.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
h1, h2 {
    color: #333;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
form {
    margin-bottom: 20px;
}
label {
    display: block;
    margin-bottom: 8px;
}
input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
}
.btn {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btn:hover {
    background-color: #45a049;
}
.message {
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 4px;
}
.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
    </style>
</head>
<body>

<?php
// Data buku dalam array
$books = [
    ['title' => 'Harry Potter', 'author' => 'J.K. Rowling', 'year' => '1997', 'status' => 'Available'],
    ['title' => 'Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'year' => '1954', 'status' => 'Available'],
    ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'year' => '1960', 'status' => 'Available'],
];

// Fungsi untuk mencari buku berdasarkan judul
function searchBook($title, $books) {
    foreach ($books as $book) {
        if (strtolower($book['title']) === strtolower($title)) {
            return $book;
        }
    }
    return null;
}

// Fungsi untuk meminjam buku
function borrowBook($title, &$books) {
    foreach ($books as &$book) {
        if (strtolower($book['title']) === strtolower($title)) {
            if ($book['status'] === 'Available') {
                $book['status'] = 'Borrowed';
                return true;
            } else {
                return false; // Buku sudah dipinjam
            }
        }
    }
    return false; // Buku tidak ditemukan
}

// Fungsi untuk mengembalikan buku
function returnBook($title, &$books) {
    foreach ($books as &$book) {
        if (strtolower($book['title']) === strtolower($title)) {
            if ($book['status'] === 'Borrowed') {
                $book['status'] = 'Available';
                return true;
            } else {
                return false; // Buku sudah tersedia atau tidak ada
            }
        }
    }
    return false; // Buku tidak ditemukan
}

// Proses form jika ada submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search'])) {
        $searchedBook = searchBook($_POST['title'], $books);
        if ($searchedBook) {
            echo '<h2>Hasil Pencarian</h2>';
            echo '<table>';
            echo '<tr><th>Judul</th><th>Penulis</th><th>Tahun Terbit</th><th>Status</th></tr>';
            echo '<tr><td>' . $searchedBook['title'] . '</td><td>' . $searchedBook['author'] . '</td><td>' . $searchedBook['year'] . '</td><td>' . $searchedBook['status'] . '</td></tr>';
            echo '</table>';
        } else {
            echo '<p>Buku tidak ditemukan.</p>';
        }
    } elseif (isset($_POST['borrow'])) {
        $result = borrowBook($_POST['title'], $books);
        if ($result) {
         //   echo '<p>Buku berhasil dipinjam.</p>';
        } else {
         //   echo '<p>Buku sudah dipinjam atau tidak ditemukan.</p>';
        }
    } elseif (isset($_POST['return'])) {
        $result = returnBook($_POST['title'], $books);
        if ($result) {
         //   echo '<p>Buku berhasil dikembalikan.</p>';
        } else {
         //   echo '<p>Buku sudah tersedia atau tidak ditemukan.</p>';
        }
    }
}
?>

<h1>Sistem Perpustakaan</h1>

<!-- Form Pencarian -->
<form method="POST">
    <label for="title">Judul Buku:</label>
    <input type="text" id="title" name="title" required>
    <button type="submit" name="search" class="btn">Cari</button>
</form>

<!-- Form Peminjaman -->
<form method="POST">
    <label for="title-borrow">Judul Buku untuk Dipinjam:</label>
    <input type="text" id="title-borrow" name="title" required>
    <button type="submit" name="borrow" class="btn">Pinjam</button>
</form>

<!-- Form Pengembalian -->
<form method="POST">
    <label for="title-return">Judul Buku untuk Dikembalikan:</label>
    <input type="text" id="title-return" name="title" required>
    <button type="submit" name="return" class="btn">Kembalikan</button>
</form>

<h2>Daftar Buku</h2>
<table>
    <tr>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Tahun Terbit</th>
        <th>Status</th>
    </tr>
    <?php foreach ($books as $book) : ?>
        <tr>
            <td><?= $book['title']; ?></td>
            <td><?= $book['author']; ?></td>
            <td><?= $book['year']; ?></td>
            <td><?= $book['status']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>