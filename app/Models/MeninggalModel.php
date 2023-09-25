<?php

namespace App\Models;

use CodeIgniter\Model;

class MeninggalModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'meninggal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['anggota_kk_id', 'umur', 'penyebab', 'tanggal_meninggal'];

    public function get($jemaat_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`nik`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`unsur`, 
            `meninggal`.`tanggal_meninggal`, 
            `kk`.`kode_kk`,
            CONCAT(`wijk`.`wijk`, '/', `ksp`.`ksp`) AS wijk_ksp,
            `meninggal`.`umur`,
            `meninggal`.`penyebab`")
            ->join("anggota_kk", "`anggota_kk`.`id` = `meninggal`.`anggota_kk_id`", "LEFT")
            ->join("anggota_jemaat", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND anggota_kk.status='meninggal' AND anggota_jemaat.deleted_at IS NULL")
            ->orderBy('tanggal_meninggal');
    }
}
