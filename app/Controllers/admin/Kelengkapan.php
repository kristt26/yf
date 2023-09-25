<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Kelengkapan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->kelengkapan = new \App\Models\KelengkapanModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
        helper("find");
        helper("logger");
    }

    public function getByPendaftaran($id)
    {
        $data = $this->kelengkapan
            ->asObject()
            ->select("kelengkapan.id, kelengkapan.persyaratan_id, kelengkapan.pendaftaran_id, kelengkapan.berkas, persyaratan.nama")
            ->join("persyaratan", "persyaratan.id=kelengkapan.persyaratan_id")
            ->where("kelengkapan.pendaftaran_id", $id)->findAll();
        logger('notice', $data);
        return $this->respond($data);
    }

    public function getProses()
    {
        $data = $this->pendaftaran->getProsesAll();
        logger('notice', $data);
        return $this->respond($data);
    }

    public function getSelesai()
    {
        $data = $this->pendaftaran->getSelesaiAll("1");
        logger('notice', $data);
        return $this->respond($data);
    }

    public function add()
    {
        return $this->respond($this->anggota->getBelumBaptis($this->request->getVar('q')));
    }

    public function post()
    {
        $item = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $this->pendaftaran->insert(['jemaat_kk_id' => $item->jemaat_kk_id, 'layanan_id' => $item->layanan_id, 'status' => '1']);
            $item->anggotas->pendaftaran_id = $this->pendaftaran->getInsertID();
            $this->pendaftaranDetail->insert($item->anggotas);
            foreach ($item->persyaratans as $key => $value) {
                $data = [
                    'persyaratan_id' => $value->id,
                    'pendaftaran_id' => $item->anggotas->pendaftaran_id,
                    'berkas' => $this->decode->decodebase64($value->file->base64)
                ];
                $this->kelengkapan->insert($data);
                // return $this->respond($data);
            }
            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                logger('notice', $item);
                return $this->respondCreated(true);
            } else {
                $this->conn->transRollback();
                $this->fail("Error");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }
}
