<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['jemaat_kk_id', 'layanan_id', 'status', 'pesan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getProsesAll($layanan_id)
    {
        $jemaat_id = session()->get('jemaat_id');
        return $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`id` AS anggotakk_id,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran.status='1' AND pendaftaran.layanan_id='$layanan_id' AND jemaat_kk.jemaat_id='$jemaat_id'")->getResult();
    }

    public function getPengajuanAll($layanan_id)
    {
        $jemaat_id = session()->get('jemaat_id');
        return $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran.status='0' AND pendaftaran.layanan_id='$layanan_id' AND jemaat_kk.jemaat_id='$jemaat_id'")->getResult();
    }

    public function getSelesaiAll($layanan_id)
    {
        $jemaat_id = session()->get('jemaat_id');
        return $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran.status='2' AND pendaftaran.layanan_id='$layanan_id' AND jemaat_kk.jemaat_id='$jemaat_id'")->getResult();
    }

    public function getProsesByUser($layanan_id)
    {
        $uid = session()->get('uid');
        $dataUser = $this->db->query("SELECT
            `anggota_kk`.`kk_id`,
            `anggota_jemaat`.`nama`
        FROM
            `users`
            LEFT JOIN `anggota_jemaat` ON `users`.`id` = `anggota_jemaat`.`users_id`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
        WHERE users.id='$uid'")->getRow();
        return $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran.status='1' AND pendaftaran.layanan_id='$layanan_id' AND kk.id = '$dataUser->kk_id'")->getResult();
    }

    public function getPengajuanByUser($layanan_id)
    {
        $uid = session()->get('uid');
        $dataUser = $this->db->query("SELECT
            `anggota_kk`.`kk_id`,
            `anggota_jemaat`.`nama`
        FROM
            `users`
            LEFT JOIN `anggota_jemaat` ON `users`.`id` = `anggota_jemaat`.`users_id`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
        WHERE users.id='$uid'")->getRow();
        $data = $this->db->query("SELECT
            `anggota_jemaat`.`id` AS jemaat_kk_id,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`,
            `pendaftaran`.`status`
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
        WHERE (pendaftaran.status='0' || pendaftaran.status='3') AND pendaftaran.layanan_id='$layanan_id' AND kk.id='$dataUser->kk_id'")->getResult();
        foreach ($data as $key => $value) {
            $value->persyaratans = $this->db->query("SELECT
                `kelengkapan`.`id`,
                `kelengkapan`.`persyaratan_id`,
                `kelengkapan`.`pendaftaran_id`,
                `kelengkapan`.`berkas`,
                `persyaratan`.`layanan_id`,
                `persyaratan`.`jemaat_id`,
                `persyaratan`.`nama`
            FROM
                `kelengkapan`
                LEFT JOIN `persyaratan` ON `kelengkapan`.`persyaratan_id` = `persyaratan`.`id`
            WHERE `kelengkapan`.`pendaftaran_id`='$value->id'")->getResult();
        }
        return $data;
    }

    public function getSelesaiByUser($layanan_id)
    {
        $uid = session()->get('uid');
        $dataUser = $this->db->query("SELECT
            `anggota_kk`.`kk_id`,
            `anggota_jemaat`.`nama`
        FROM
            `users`
            LEFT JOIN `anggota_jemaat` ON `users`.`id` = `anggota_jemaat`.`users_id`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
        WHERE users.id='$uid'")->getRow();
        return $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`kode_kk`,
            `pendaftaran`.`id`
        FROM
            `pendaftaran`
            LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` = `pendaftaran_detail`.`pendaftaran_id`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran.status='2' AND kk.id = '$dataUser->kk_id'")->getResult();
    }

    public function getById($layanan_id, $id)
    {
        $item = $this->db->query("SELECT
            `pendaftaran`.`id`,
            `pendaftaran`.`jemaat_kk_id`,
            `pendaftaran`.`layanan_id`,
            `pendaftaran`.`status`
        FROM
            `pendaftaran`
        WHERE id='$id' AND layanan_id='$layanan_id'")->getRow();

        $item->anggotas = $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `kk`.`alamat`,
            `kk`.`kode_kk`
        FROM
            `pendaftaran_detail`
            LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
        WHERE pendaftaran_detail.pendaftaran_id = '$id'")->getRow();

        $item->persyaratans = $this->db->query("SELECT
            `kelengkapan`.`id`,
            `kelengkapan`.`persyaratan_id`,
            `kelengkapan`.`pendaftaran_id`,
            `kelengkapan`.`berkas`,
            `persyaratan`.`nama`
        FROM
            `kelengkapan`
            LEFT JOIN `persyaratan` ON `kelengkapan`.`persyaratan_id` = `persyaratan`.`id`
        WHERE kelengkapan.pendaftaran_id = '$id'")->getResult();
        return $item;
    }
}
