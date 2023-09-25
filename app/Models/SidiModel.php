<?php

namespace App\Models;

use CodeIgniter\Model;

class SidiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sidi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['anggotakk_id', 'tanggal_sidi', 'nama_gereja', 'pendeta', 'file'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
