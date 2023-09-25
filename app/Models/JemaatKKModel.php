<?php

namespace App\Models;

use CodeIgniter\Model;

class JemaatKKModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jemaat_kk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['jemaat_id', 'status', 'kk_id', 'ksp_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getById($id)
    {
        $item =  $this->db->query("SELECT
            `kk`.*,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nik`,
            `jemaat_kk`.`status`,
            `jemaat_kk`.`ksp_id`
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` WHERE jemaat_kk.id = '$id' AND (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI')")->getRow();
        return $item;
    }

    public function getByUser($id)
    {
        $item =  $this->db->query("SELECT
            `anggota_jemaat`.`nama`,
            `jemaat_kk`.`jemaat_id`
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
            LEFT JOIN `users` ON `anggota_jemaat`.`users_id` = `users`.`id` WHERE users.id = '$id' AND (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI')")->getRow();
        return $item;
    }

    public function getUserJemaat($jemaat_id)
    {
        $builder = $this->builder();
        $builder->select("
        users.id,
        users.username,
        users.email,
        users.status,
        anggota_jemaat.nama,
        anggota_jemaat.id AS anggota_jemaat_id,
        kk.kode_kk,
        ksp.ksp,
        wijk.wijk");
        $builder->join("ksp", "ksp.id = jemaat_kk.ksp_id", "LEFT");
        $builder->join("wijk", "wijk.id = ksp.wijk_id", "LEFT");
        $builder->join("kk", "jemaat_kk.kk_id = kk.id", "LEFT");
        $builder->join("anggota_kk", "kk.id = anggota_kk.kk_id", "LEFT");
        $builder->join("anggota_jemaat", "anggota_kk.anggota_jemaat_id = anggota_jemaat.id", "LEFT");
        $builder->join("users", "anggota_jemaat.users_id = users.id", "LEFT");
        $builder->join("userinroles", "users.id = userinroles.users_id", "LEFT");
        $builder->join("roles", "userinroles.roles_id = roles.id", "LEFT");
        $builder->where("userinroles.roles_id ='4' AND jemaat_kk.jemaat_id = '$jemaat_id'");
        return $builder;
    }

    public function getKK($jemaat_id)
    {
        return $this->db->query("SELECT
            `kk`.*,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nik`,
            `jemaat_kk`.`status`,
            `jemaat_kk`.`id` AS jemaat_kk_id,
            `jemaat_kk`.`ksp_id`,
            `kk`.`id` AS kk_id
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` 
        WHERE (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI') AND jemaat_kk.jemaat_id='$jemaat_id' and jemaat_kk.status='Aktif' and anggota_kk.status='Aktif'")->getResult();
    }

    public function getKKAktif($q)
    {
        $jemaat_id = session()->get('jemaat_id');
        return $this->db->query("SELECT
            `kk`.`kk`,
            `kk`.`kode_kk`,
            `kk`.`users_id`,
            `kk`.`telepon`,
            `kk`.`hp`,
            `kk`.`alamat`,
            `kk`.`provinsi`,
            `kk`.`kabupaten`,
            `kk`.`kecamatan`,
            `kk`.`kelurahan`,
            `kk`.`kode_pos`,
            `kk`.`lingkungan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nama` AS text,
            `anggota_jemaat`.`nik`,
            `jemaat_kk`.`status`,
            `jemaat_kk`.`id`,
            `jemaat_kk`.`ksp_id`,
            `jemaat_kk`.`kk_id`
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` 
        WHERE (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI') AND jemaat_kk.jemaat_id='$jemaat_id' AND `anggota_jemaat`.`nama` LIKE '%" . $q . "%'")->getResult();
    }
    public function getKepalaKeluarga($jemaat_id, $kk_id)
    {
        return $this->db->query("SELECT
        `kk`.*,
        `ksp`.`ksp`,
        `ksp`.`wijk_id`,
        `wijk`.`wijk`,
        `anggota_jemaat`.`nama`,
        `anggota_jemaat`.`nik`,
        `jemaat_kk`.`status`,
        `jemaat_kk`.`id` AS jemaat_kk_id,
        `jemaat_kk`.`ksp_id`,
        `kk`.`id` AS kk_id
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` WHERE jemaat_kk.kk_id='$kk_id' AND (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI') AND jemaat_kk.jemaat_id='$jemaat_id'")->getRowObject();
    }

    public function LaporanKepalaKeluarga($jemaat_id = null, $wijk_id = null, $ksp_id = null)
    {
        $where = is_null($wijk_id) && !is_null($ksp_id) ? " AND ksp_id='" . $ksp_id . "'"
            : (!is_null($wijk_id) && is_null($ksp_id) ? " AND wijk_id='" . $wijk_id . "'"
                : (!is_null($wijk_id) && !is_null($ksp_id) ? " AND ksp_id='" . $ksp_id . "'" : ""));
        $data =  $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `ksp`.`ksp`,
            `wijk`.`wijk`,
            `jemaat_kk`.kk_id,
            timestampdiff(year,anggota_jemaat.tanggal_lahir,curdate()) as umur
        FROM
            `jemaat_kk`
            LEFT JOIN `kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `anggota_kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `anggota_jemaat` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` 
        WHERE anggota_kk.status='Aktif' AND (hubungan_keluarga='KEPALA KELUARGA' OR hubungan_keluarga='SUAMI') $where AND jemaat_kk.jemaat_id='$jemaat_id' ORDER BY kk.kode_kk ASC");
        return $data;
    }
}
