<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pendaftaran_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['pendaftaran_id', 'anggota_jemaat_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
