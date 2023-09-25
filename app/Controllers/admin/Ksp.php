<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Ksp extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->ksp = new \App\Models\KspModel();
        $this->wijk = new \App\Models\WijkModel();
        helper('logger');
    }

    public function index()
    {
        return view('admin/ksp');
    }

    public function read()
    {
        $data = $this->wijk->asObject()->where('wijk.jemaat_id', session()->get('jemaat_id'))->findAll();
        foreach ($data as $item) {
            $item->ksp = $this->ksp->where('wijk_id', $item->id)->findAll();
        }
        logger('notice', '');
        return $this->respond($data);
    }

    public function post()
    {
        try {
            $data = $this->request->getJSON();
            $this->ksp->insert($data);
            $data->id = $this->ksp->getInsertID();
            logger('notice', $data);
            return $this->respond($data);
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
        $data = $this->ksp->find($id);
        if ($this->ksp->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
