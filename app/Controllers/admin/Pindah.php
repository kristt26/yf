<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Pindah extends BaseController
{
    use ResponseTrait;
    protected $anggota;
    protected $jemaatKK;
    protected $pindah;
    protected $meninggal;
    protected $anggotaKK;
    protected $kk;
    protected $conn;
    protected $wijk;
    public function __construct()
    {
        $this->anggota = new \App\Models\AnggotaKKModel();
        $this->jemaatKK = new \App\Models\JemaatKKModel();
        $this->pindah = new \App\Models\PindahModel();
        $this->meninggal = new \App\Models\MeninggalModel();
        $this->kk = new \App\Models\KkModel();
        $this->anggotaKK = new \App\Models\AnggotaKeluargaModel();
        $this->conn = \Config\Database::connect();
        helper("logger");
        helper("find");
    }

    public function index()
    {
        $list['lists'] = [
            ["url" => enkrip("pindah"), "text" => "Pindah"],
            ["url" => enkrip("meninggal"), "text" => "Meninggal"],
            ["url" => enkrip("numpang"), "text" => "Numpang KK"],
            ["url" => enkrip("baru"), "text" => "KK Baru"],
        ];
        $setItem = $this->request->getGet("item");
        if (is_null($setItem)) {
            $url = base_url('mutasi') . '?item=' . enkrip("pindah");
            return redirect()->to($url);
        } else if (dekrip($setItem) == "pindah") {
            $list['title'] = "Pindah";
            $list['url'] = enkrip("pindah");
            $list['add'] = enkrip("add");
            return view('admin/mutasi/pindah', $list);
        } else if (dekrip($setItem) == "meninggal") {
            $list['title'] = "Meninggal";
            $list['url'] = enkrip("meninggal");
            $list['add'] = enkrip("add");
            return view('admin/mutasi/meninggal', $list);
        } else if (dekrip($setItem) == "numpang") {
            $list['title'] = "Numpang KK";
            $list['url'] = enkrip("numpang");
            $list['add'] = enkrip("add");
            return view('admin/mutasi/numpang', $list);
        } else if (dekrip($setItem) == "add") {
            $list['title'] = "Add";
            $list['url'] = enkrip("add");
            return view('admin/mutasi/add', $list);
        }
    }

    public function add()
    {
        return view('admin/add');
    }

    public function read()
    {
        return $this->respond($this->wijk->where('wijk.jemaat_id', session()->get('jemaat_id'))->findAll());
    }

    public function get_jemaat_aktif()
    {
        return $this->respond($this->anggota->getJemaatAktif($this->request->getVar('q')));
    }

    public function get_kk_aktif()
    {
        return $this->respond($this->jemaatKK->getKKAktif($this->request->getVar('q')));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            if ($data->status_pindah == '1') {
                if ($data->jenisAnggota == "1") {
                    $this->pindah->insert($data);
                    $this->anggotaKK->update($data->anggota_kk_id, ['status' => "Pindah"]);
                } else {
                    foreach ($data->anggota as $key => $value) {
                        $item = [
                            'status_pindah' => $data->status_pindah,
                            'tanggal_pindah' => $data->tanggal_pindah,
                            'anggota_kk_id' => $value->anggota_kk_id,
                            'alasan_pindah' => $data->alasan_pindah,
                            'gereja_id' => $data->gereja_id,
                        ];
                        $this->pindah->insert($item);
                        $this->anggotaKK->update($value->anggota_kk_id, ['status' => "Pindah"]);
                    }
                    $this->jemaatKK->update($data->jemaat_kk_id, ['status' => "Pindah"]);
                }
            } else {
                $this->meninggal->insert($data);
                $this->anggotaKK->update($data->anggota_kk_id, ['status' => "Meninggal"]);
                if ($data->hubungan_keluarga == "SUAMI" || $data->hubungan_keluarga == "KEPALA KELUARGA") {
                    $newKK = $this->anggotaKK->asObject()->where("kk_id", $data->kk_id)->where('status', 'Aktif')->first();
                    $this->anggota->update($newKK->anggota_jemaat_id, ['hubungan_keluarga' => 'KEPALA KELUARGA']);
                }
            }

            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                return $this->respond(true);
            } else {
                $this->conn->transRollback();
                return $this->fail(false);
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function pindah()
    {
        $data = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            if($data->setStatus) $this->kk->update($data->kkLama, ['status'=>'0']);
            foreach ($data->anggotaBaru as $key => $value) {
                $this->anggotaKK->update($value->anggota_kk_id, ['kk_id'=>$data->id]);
                $this->anggota->update($value->id, ['hubungan_keluarga'=>$value->hubungan_keluarga]);
            }
            if($this->conn->transStatus()){
                $this->conn->transCommit();
                return $this->respondUpdated(true);
            }else throw new \Exception("Proses Gagal", 1);
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }

    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->wijk->update($data->id, $data);
        logger('notice', $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        $data = $this->wijk->find($id);
        if ($this->wijk->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
