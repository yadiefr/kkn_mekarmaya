<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Edukasi;

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Membuat Pupuk Kompos',
                'category' => 'Organik & Kompos',
                'icon' => 'fa-mortar-pestle',
                'content' => "Bahan & Alat Pokok:\nSampah basah (sisa sayur, buah, kopi), sampah kering (daun gugur, serbuk kayu), wadah ember berlubang bawah, tanah, dan cairan bio-aktivator EM4.\n\nAlur Eksekusi:\n1. Lubangi dasar ember komposter untuk jalur pembuangan sisa rembesan air lindi agar tidak membusuk anaerob.\n2. Cacah sampah hijau berukuran kecil (1-2 cm) guna mempercepat luas bidang kontak mikroorganisme pengurai.\n3. Tumpuk berlapis: sampah kering paling dasar, sampah basah di tengah, dan lapisan tanah penutup di atas setebal 3cm.\n4. Siram berkala dengan larutan EM4 untuk kelembaban ideal. Aduk merata seminggu sekali. Kompos matang siap panen dalam 4-6 minggu.",
            ],
            [
                'title' => 'Efisiensi & Hemat Energi',
                'category' => 'Energi Terbarukan',
                'icon' => 'fa-lightbulb',
                'content' => "Tahap 1: Kesadaran Dasar (Awareness)\nMemahami konversi daya listrik yang dominan bersumber dari fosil batu bara. Galakkan gerakan disiplin mencabut kepala stopkontak elektronik dari saklar saat kondisi standby.\n\nTahap 2: Pembiasaan Perilaku (Action)\nMaksimalkan bukaan jendela untuk pencahayaan alami siang hari, konversi ke lampu berbasis LED hemat daya, dan setel pendingin ruangan ruangan (AC) konstan pada suhu optimal 24–25°C.\n\nTahap 3: Investasi Hijau (Sustaining)\nPrioritaskan pembelian perangkat bersertifikasi bintang hemat energi, beralih ke moda transportasi publik, serta pelopori efisiensi lampu fasilitas komunal masyarakat luar.",
            ],
            [
                'title' => 'Pelestarian Ekosistem Alam',
                'category' => 'Alam & Lingkungan',
                'icon' => 'fa-tree',
                'content' => "Tahap 1: Pengenalan & Empati\nMembangun kepekaan sosial terhadap biodiversitas fauna-flora lokal di sekeliling wilayah pemukiman warga serta melarang keras tindakan perburuan satwa liar dilindungi.\n\nTahap 2: Penghidupan Rumahtangga\nPemanfaatan pekarangan terbatas via taman vertikal hidroponik dan menanam jenis vegetasi bunga lokal penarik agen polinator alami seperti lebah dan kupu-kupu.\n\nTahap 3: Konservasi Aktif\nTurut berkontribusi langsung dalam program penanaman bibit pohon penghijauan, restorasi kawasan bakau (mangrove), serta menolak keras komoditas perdagangan satwa eksotis.",
            ],
            [
                'title' => 'Pengelolaan Sampah Plastik',
                'category' => 'Daur Ulang Plastik',
                'icon' => 'fa-recycle',
                'content' => "Tahap 1: Reduksi Sumber (Reduce)\nMembudayakan penggunaan kantong belanja kain mandiri, wadah makan guna ulang, serta membawa tumbler pribadi demi menekan akumulasi wadah kemasan plastik sekali pakai.\n\nTahap 2: Pemilahan Terstruktur\nKlasifikasikan limbah minimal ke dalam dua wadah penampung primer terpisah: Sampah Organik (sisa konsumsi) dan Sampah Anorganik (plastik, kertas, kaca, alumunium).\n\nTahap 3: Sirkular Ekonomi\nKembangkan kreativitas pengolahan limbah minyak jelantah sisa dapur menjadi lilin penerangan, pembuatan larutan pembersih alami eco-enzyme, atau penyetoran berkala ke unit Bank Sampah.",
            ],
            [
                'title' => 'Konservasi & Perlindungan Air',
                'category' => 'Konservasi Air',
                'icon' => 'fa-droplet',
                'content' => "Tahap 1: Efisiensi Keran Kontrol\nDisiplin menutup laju air keran saat membersihkan sikat gigi atau pengaplikasian sabun cuci tangan, serta menyegerakan rekonstruksi teknis pipa instalasi air yang terindikasi bocor.\n\nTahap 2: Daur Ulang Domestik (Greywater)\nManfaatkan limbah air bilasan sisa cucian beras atau sayur-mayur untuk irigasi tanaman pot, dan alokasikan air bilasan akhir cucian pakaian guna membersihkan lantai garasi atau toilet.\n\nTahap 3: Retensi Air Tanah\nAktif mengimplementasikan cetakan silinder lubang biopori bioretensi atau instalasi sumur resapan dangkal di area pekarangan rumah demi menjaga pasokan cadangan air tanah lokal.",
            ]
        ];

        foreach($data as $item) {
            Edukasi::create($item);
        }
    }
}
