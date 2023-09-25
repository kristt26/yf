<?php

namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['times', 'type', 'jemaat_id', 'user_id', 'ip_address', 'router', 'status', 'data'];
}
