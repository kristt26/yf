<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;

class Anggota extends BaseController
{
    use ResponseTrait;
    protected $keluarga;
    protected $anggota;
    protected $anggotaKeluarga;
    protected $conn;
    protected $decode;
    public function __construct()
    {
        $this->keluarga = new \App\Models\KeluargaModel();
        $this->anggota = new \App\Models\AnggotaModel();
        $this->anggotaKeluarga = new \App\Models\AnggotaKeluargaModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
        helper("find");
    }

    public function index()
    {
        return view('admin/anggota');
    }

    public function add($id)
    {
        return view('admin/add_anggota');
    }
    public function edit($id)
    {
        return view('admin/edit_anggota');
    }

    public function read()
    {

        $db = \Config\Database::connect();
        // $customers = $db->table('anggota_jemaat')->select('nik, nama');
        $data = $this->anggota->getAll();
        // $data['anggota'] = $this->anggota->getData($total);
        // $data['totalItem'] = $this->anggota->countAllResults();
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->add('aksi', function ($row) {
                return '<a href="anggota/edit/' . $row->id . '" class="btn btn-warning btn-sm btn-rounded btn-icon" style="padding: 6px;"><i class="mdi mdi-grease-pencil"
            data-bs-toggle="tooltip" data-bs-placement="top"
            title="Ubah data"></i></a>';
            })
            ->toJson(true);
        // $a = $item['data'];
        // ->toJson(true);

        return $item;
    }

    public function post()
    {
        $value = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $value->id = $this->decode->uid();
            $value->foto = isset($value->berkas) ? $this->decode->decodebase64($value->berkas->base64) : null;
            $this->anggota->insert($value);
            $this->anggotaKeluarga->insert(['keluarga_id' => $value->keluarga_id, 'anggota_id' => $value->id]);
            $this->conn->transCommit();
            return $this->respond($value);
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail("Gagal menambah data");
        }
    }

    public function put()
    {
        $value = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $value->foto = isset($value->berkas) ? $this->decode->decodebase64($value->berkas->base64) : $value->foto;
            $this->anggota->update($value->id, $value);
            $this->conn->transCommit();
            return $this->respond($value);
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail("Gagal menambah data");
        }
    }

    public function delete($id)
    {
        if ($this->anggota->delete($id)) {
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }

    public function ultah()
    {
        // $data = $this->anggota->getUltahWeak();
        return view('admin/ultah');
    }

    public function getUltah()
    {
        $param = $this->request->getGet();
        $start = $param['start'];
        $end = $param['end'];
        $data = $this->anggota
            ->select("anggota.*, keluarga.id as keluarga_id, keluarga.alamat, anggota_keluarga.keluarga_id, anggota.nama, wilayah.wilayah, timestampdiff(year,tanggal_lahir,curdate()) as umur")
            ->join("anggota_keluarga", "anggota_keluarga.anggota_id=anggota.id", "left")
            ->join("keluarga", "anggota_keluarga.keluarga_id=keluarga.id", "left")
            ->join("wilayah", "wilayah.id=keluarga.wilayah_id", "left")
            ->where("DATE_FORMAT(tanggal_lahir, '%m-%d') >= DATE_FORMAT('$start', '%m-%d') AND DATE_FORMAT(tanggal_lahir, '%m-%d') <= DATE_FORMAT('$end', '%m-%d') AND anggota.deleted_at IS NULL")
            ->findAll();
        $kepala = $this->anggota
            ->select("keluarga.*, wilayah.wilayah, anggota.nama")
            ->join("anggota_keluarga", "anggota_keluarga.anggota_id = anggota.id", "left")
            ->join("keluarga", "keluarga.id = anggota_keluarga.keluarga_id", "left")
            ->join("wilayah", "wilayah.id = keluarga.wilayah_id", "left")
            ->where("hubungan_keluarga", "KEPALA KELUARGA")
            ->where("keluarga.deleted_at", null)
            ->findAll();
        foreach ($data as $key => $angg) {
            foreach ($kepala as $value) {
                if($angg['keluarga_id']==$value['id']) $data[$key]['kepala_keluarga'] = $value['nama'];
            }
        }
        return $this->respond($data);
    }

    public function getGolonganDarah()
    {
        $item = $this->request->getGet('darah');
        $param = dekrip($item);
        if ($param == "null" || $param == "ALL") $data = $this->anggota->findAll();
        else $data = $this->anggota->where("golongan_darah", $param)->findAll();
        return $this->respond($data);
    }

    public function getId($id = null)
    {
        $data['anggota'] = $this->anggota->select("anggota.*, anggota_keluarga.keluarga_id")->join("anggota_keluarga", "anggota_keluarga.anggota_id=anggota.id", "left")->where("id", "$id")->first();
        $data['kk'] = $this->anggota->asObject()
            ->select("keluarga.*, anggota_keluarga.keluarga_id, anggota.nama")
            ->join("anggota_keluarga", "anggota_keluarga.anggota_id=anggota.id", "left")
            ->join("keluarga", "anggota_keluarga.keluarga_id=keluarga.id", "left")
            ->where('hubungan_keluarga', "KEPALA KELUARGA")
            ->where("keluarga.id", $data['anggota']['keluarga_id'])->first();
        $data['kk']->anggota = $data['anggota'];
        return $this->respond($data);
    }

    public function layak_baptis()
    {
        $data = $this->anggota->layak_baptis(session()->get("jemaat_id"));
        return $this->respond($data);
    }

    public function getById($id)
    {
        return $this->respond($this->anggota->asObject()->getById($id));
    }
}
