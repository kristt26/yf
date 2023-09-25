<?php

namespace App\Models;

use CodeIgniter\Model;

class PindahModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pindah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['status_pindah', 'tanggal_pindah', 'anggota_kk_id', 'alasan_pindah', 'gereja_id'];

    public function get($jemaat_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`nik`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`unsur`, 
            `kk`.`kode_kk`,
            CONCAT(`wijk`.`wijk`, '/', `ksp`.`ksp`) AS wijk_ksp,
            `pindah`.`status_pindah`,
            `pindah`.`tanggal_pindah`,
            `pindah`.`anggota_kk_id`,
            `pindah`.`alasan_pindah`,
            `gereja`.`nama` AS tujuan
            ")
            ->join("anggota_kk", "`anggota_kk`.`id` = `pindah`.`anggota_kk_id`", "LEFT")
            ->join("gereja", "`gereja`.`id` = `pindah`.`gereja_id`", "LEFT")
            ->join("anggota_jemaat", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND anggota_kk.status='pindah' AND anggota_jemaat.deleted_at IS NULL")
            ->orderBy('tanggal_pindah');
    }
}
