<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Persyaratan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->layanan = new \App\Models\LayananModel();
        $this->persyaratan = new \App\Models\PersyaratanModel();
        $this->jemaatKK = new \App\Models\JemaatKKModel();
        helper("logger");
    }

    public function index()
    {
        return view('admin/persyaratan');
    }

    public function read()
    {
        $layanan = $this->layanan->asObject()->findAll();
        foreach ($layanan as $item) {
            $item->persyaratan = $this->persyaratan->where('jemaat_id', session()->get('jemaat_id'))->where('layanan_id', $item->id)->findAll();
        }
        logger('notice', $layanan);
        return $this->respond($layanan);
    }

    public function readByLayanan()
    {
        if (session()->get('level') == 'Admin') {
            $item = $this->persyaratan->where('jemaat_id', session()->get('jemaat_id'))->where('layanan_id', $this->request->getGet('id'))->findAll();
        } else {
            $jemaat_id = $this->jemaatKK->getByUser(session()->get('uid'))->jemaat_id;
            $item = $this->persyaratan->where('jemaat_id', $jemaat_id)->where('layanan_id', $this->request->getGet('id'))->findAll();
        }
        return $this->respond($item);
    }

    public function post()
    {
        try {
            $data = $this->request->getJSON();
            $data->jemaat_id = session()->get('jemaat_id');
            $this->persyaratan->insert($data);
            $data->id = $this->persyaratan->getInsertID();
            $item = $this->persyaratan->where('id', $data->id)->first();
            logger('notice', $data);
            return $this->respond($item);
        } catch (\Throwable $th) {
            return $this->fail("Gagal menambah data");
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->ksp->update($data->id, $data);
        logger('notice', $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        $data = $this->persyaratan->find($id);
        if ($this->ksp->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
