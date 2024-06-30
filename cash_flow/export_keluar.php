<?php
require_once('TCPDF-main/tcpdf.php'); // Sesuaikan dengan lokasi TCPDF di proyek Anda
include './config/koneksi.php';

// Extending TCPDF untuk menyesuaikan Header dan Footer
class PDF extends TCPDF {

    // Halaman header
    public function Header() {
        // Output HTML di header
        $header = '
        <h3>Data Pengeluaran Dana</h3>
        ';
        $this->writeHTML($header, true, false, true, false, '');
    }

    // Halaman footer
    public function Footer() {
        // Informasi footer
        $footer = '
        <table border="0" width="100%" style="font-size: 10px;">
            <tr>
                <td style="text-align:left;">Footer kiri</td>
                <td style="text-align:right;">Footer kanan</td>
            </tr>
        </table>
        ';
        $this->writeHTML($footer, true, false, true, false, '');
    }
}

// Membuat instance TCPDF
$pdf = new PDF();

// Menambahkan halaman baru
$pdf->AddPage();

// CSS untuk styling tabel
$html = '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
';

// Membuat tabel untuk data pengeluaran
$html .= '
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pengeluaran</th>
            <th>Harga Barang</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>';

$query = mysqli_query($conn, "SELECT * FROM keluar");
$no = 1;
while ($row = mysqli_fetch_array($query)) {
    // Menambahkan baris untuk setiap pengeluaran
    $html .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . $row['nama'] . '</td>
        <td>' . $row['jumlah'] . '</td>
        <td>' . $row['tanggal'] . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Menuliskan HTML ke halaman PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output file PDF ke browser
$pdf->Output('Data_pengeluaran.pdf', 'I'); // 'I' untuk menampilkan di browser, 'D' untuk mengunduh langsung

?>
