<?php

namespace App\Models;

use CodeIgniter\Model;

class KkModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kk', 'kode_kk', 'users_id', 'telepon', 'hp', 'alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kode_pos', 'lingkungan', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getDetail($id)
    {
        $data = $this->db->query("SELECT
            `kk`.*,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `jemaat`.`jemaat`,
            `klasis`.`klasis`,
            `jemaat_kk`.`ksp_id`,
            `jemaat_kk`.`id` AS jemaat_kk_id
        FROM
            `kk`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
            LEFT JOIN `jemaat` ON `jemaat_kk`.`jemaat_id` = `jemaat`.`id`
            LEFT JOIN `klasis` ON `jemaat`.`klasis_id` = `klasis`.`id` 
        where kk.id='$id'")->getRow();
        return $data;
    }

    public function getAll()
    {
        $jemaat_id = session()->get('jemaat_id');
        $data = $this->db->query("SELECT
            `kk`.`id`,
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
            `jemaat_kk`.`ksp_id`,
            `jemaat_kk`.`status`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `wijk`.`inisial`
        FROM
            `kk`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id` WHERE jemaat_kk.jemaat_id='$jemaat_id'")->getResult();
        return $data;
    }

    public function all()
    {
        $jemaat_id = session()->get('jemaat_id');
        $data = $this->db->query("SELECT
            `kk`.*,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `jemaat`.`jemaat`,
            `klasis`.`klasis`
        FROM
            `kk`
            LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
            LEFT JOIN `jemaat` ON `jemaat`.`id` = `jemaat_kk`.`jemaat_id`
            LEFT JOIN `klasis` ON `jemaat`.`klasis_id` = `klasis`.`id` 
        where jemaat_kk.jemaat_id='$jemaat_id'")->getResultArray();
        return $data;
    }

    public function laporanKeluarga($wijk_id = null, $ksp_id = null)
    {
        $where = is_null($wijk_id) && !is_null($ksp_id) ? " AND ksp_id='" . $ksp_id . "'"
            : (!is_null($wijk_id) && is_null($ksp_id) ? " AND wijk_id='" . $wijk_id . "'" : "");
        $jemaat_id = session()->get('jemaat_id');
        $data = $this->db->query("SELECT
            `kk`.*,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `jemaat`.`jemaat`,
            `klasis`.`klasis`
        FROM
            `kk`
            LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
            LEFT JOIN `jemaat` ON `jemaat`.`id` = `jemaat_kk`.`jemaat_id`
            LEFT JOIN `klasis` ON `jemaat`.`klasis_id` = `klasis`.`id` 
        where jemaat_kk.jemaat_id='$jemaat_id' $where")->getResultArray();
        return $data;
    }
}
