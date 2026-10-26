<?php
class Buku {
    private $judul;
    private $penulis;
    private $stok;

    public function __construct($judul, $penulis, $stok) {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->stok = $stok;
    }
    public function getJudul() { return $this->judul; }
    public function getStok() { return $this->stok; }
    public function setStok($stok) {
        if ($stok >= 0) {
            $this->stok = $stok;
        }
    }
    public function tampilkanInfo() {
        echo "Buku: $this->judul, Penulis: $this->penulis, Stok: $this->stok<br>";
    }
}

class Anggota {
    private $nama;
    private $jumlahPinjam = 0;

    public function __construct($nama) {
        $this->nama = $nama;
    }
    public function getNama() { return $this->nama; }
    public function getJumlahPinjam() { return $this->jumlahPinjam; }
    public function setJumlahPinjam($jumlah) {
        if ($jumlah >= 0) {
            $this->jumlahPinjam = $jumlah;
        }
    }
    public function getBatasPinjam() {
        return 2;
    }
    public function tampilkanInfo() {
        echo "Anggota: $this->nama, Batas Pinjam: {$this->getBatasPinjam()}<br>";
    }
}

class Mahasiswa extends Anggota {
    private $prodi;

    public function __construct($nama, $prodi) {
        parent::__construct($nama);
        $this->prodi = $prodi;
    }
    public function getBatasPinjam() {
        return 3;
    }
    public function tampilkanInfo() {
        parent::tampilkanInfo();
        echo "Prodi: $this->prodi<br>";
    }
}

class Dosen extends Anggota {
    private $nidn;

    public function __construct($nama, $nidn) {
        parent::__construct($nama);
        $this->nidn = $nidn;
    }
    public function getBatasPinjam() {
        return 5;
    }
    public function tampilkanInfo() {
        parent::tampilkanInfo();
        echo "NIDN: $this->nidn<br>";
    }
}

class Peminjaman {
    private $buku;
    private $anggota;
    private $tanggal;
    private $status = "Menunggu";

    public function __construct($buku, $anggota, $tanggal) {
        $this->buku = $buku;
        $this->anggota = $anggota;
        $this->tanggal = $tanggal;
    }
    public function pinjam() {
        if ($this->buku->getStok() <= 0) {
            echo "Gagal: stok buku {$this->buku->getJudul()} habis<br>";
        } elseif ($this->anggota->getJumlahPinjam() >= $this->anggota->getBatasPinjam()) {
            echo "Gagal: {$this->anggota->getNama()} sudah mencapai batas pinjam<br>";
        } else {
            $this->buku->setStok($this->buku->getStok() - 1);
            $this->anggota->setJumlahPinjam($this->anggota->getJumlahPinjam() + 1);
            $this->status = "Dipinjam";
            echo "Berhasil: {$this->anggota->getNama()} meminjam {$this->buku->getJudul()}<br>";
        }
    }
    public function kembalikan() {
        if ($this->status == "Dipinjam") {
            $this->buku->setStok($this->buku->getStok() + 1);
            $this->anggota->setJumlahPinjam($this->anggota->getJumlahPinjam() - 1);
            $this->status = "Dikembalikan";
            echo "Berhasil: {$this->anggota->getNama()} mengembalikan {$this->buku->getJudul()}<br>";
        } else {
            echo "Gagal: buku tidak sedang dipinjam<br>";
        }
    }
    public function tampilkanInfo() {
        echo "Peminjaman: {$this->anggota->getNama()} - {$this->buku->getJudul()}, Tanggal: $this->tanggal, Status: $this->status<br>";
    }
}

$buku1 = new Buku("Pemrograman PHP", "Andi Wijaya", 1);
$mhs1 = new Mahasiswa("Stan", "Sistem Informasi");
$dosen1 = new Dosen("Made", "0801018801");

$buku1->tampilkanInfo();
$mhs1->tampilkanInfo();
$dosen1->tampilkanInfo();

$pinjam1 = new Peminjaman($buku1, $mhs1, "2026-10-01");
$pinjam2 = new Peminjaman($buku1, $dosen1, "2026-10-02");

$pinjam1->pinjam();
$pinjam2->pinjam();
$pinjam1->tampilkanInfo();
$pinjam2->tampilkanInfo();

$pinjam1->kembalikan();
$pinjam2->pinjam();
$pinjam2->tampilkanInfo();
$buku1->tampilkanInfo();
?>