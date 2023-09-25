<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\RTF;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Spatie\Async\Pool;

class Baptis extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->ksp = new \App\Models\KspModel();
        $this->wijk = new \App\Models\WijkModel();
        $this->anggota = new \App\Models\AnggotaKKModel();
        $this->pendaftaran = new \App\Models\PendaftaranModel();
        $this->pendaftaranDetail = new \App\Models\PendaftaranDetailModel();
        $this->kelengkapan = new \App\Models\KelengkapanModel();
        $this->baptis = new \App\Models\BaptisModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
        helper("find");
        helper("logger");
    }

    public function index()
    {
        $list['lists'] = [
            ["url" => enkrip("pengajuan"), "text" => "Pengajuan"],
            ["url" => enkrip("proses"), "text" => "Proses"],
            ["url" => enkrip("selesai"), "text" => "Selesai"],
        ];
        $setItem = $this->request->getGet("item");
        if (is_null($setItem)) {
            $url = base_url('manajemen_baptis') . '?item=' . enkrip("pengajuan");
            return redirect()->to($url);
        } else if (dekrip($setItem) == "pengajuan") {
            $list['title'] = "Pengajuan";
            $list['url'] = enkrip("pengajuan");
            $list['item'] = count($this->pendaftaran->getPengajuanAll("1"));
            return view('admin/baptis/pengajuan', $list);
        } else if (dekrip($setItem) == "proses") {
            $list['title'] = "Proses";
            $list['url'] = enkrip("proses");
            $list['add'] = enkrip("add");
            $list['item'] = count($this->pendaftaran->getPengajuanAll("1"));
            return view('admin/baptis/proses', $list);
        } else if (dekrip($setItem) == "selesai") {
            $list['title'] = "Selesai";
            $list['url'] = enkrip("selesai");
            $list['item'] = count($this->pendaftaran->getPengajuanAll("1"));
            return view('admin/baptis/selesai', $list);
        } else if (dekrip($setItem) == "add") {
            $list['title'] = "Add";
            $list['url'] = enkrip("proses");
            $list['item'] = count($this->pendaftaran->getPengajuanAll("1"));
            return view('admin/baptis/add', $list);
        }
    }

    public function getPengajuan()
    {
        $data = $this->pendaftaran->getPengajuanAll("1");
        logger('notice', $data);
        return $this->respond($data);
    }

    public function getProses()
    {
        $data = $this->pendaftaran->getProsesAll("1");
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

    public function put()
    {
        $item = $this->request->getJSON();
        // return $this->respond($item);
        try {
            $this->conn->transBegin();
            $this->pendaftaran->update($item->id, $item);
            if ($item->status == "2") {
                $jemaat = $this->baptis->asObject()->where('anggotakk_id', $item->anggotakk_id)->first();
                if (!is_null($jemaat)) {
                    $this->baptis->update($jemaat->id, ['nama_gereja' => $item->nama_gereja, 'tanggal_baptis' => $item->tanggal_baptis, 'pendeta' => $item->pendeta]);
                } else {
                    $this->baptis->insert(['nama_gereja' => $item->nama_gereja, 'tanggal_baptis' => $item->tanggal_baptis, 'pendeta' => $item->pendeta, 'anggotakk_id' => $item->anggotakk_id]);
                }
            }
            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                session()->setFlashdata('pesan', 'Diubah');
                logger('notice', $item);
                return $this->respondCreated(true);
            } else {
                $this->conn->transRollback();
                return $this->fail("Error");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function doc()
    {
        $pool = Pool::create();
        $data = [1, 2, 3, 4, 5];

        foreach ($data as $i) {
            $pool[] = async(function () use ($i) {
                $output = $i * 2;
                return $output;
            })->then(function ($output) {
                echo $output . "\n";
            });
        }
        echo "Testing\n";
        await($pool);

        // $pooling = Pool::create();
        // foreach (range(1, 5) as $i) {
        //     $pooling[] = async(function () use ($i) {
        //         $output = $i * 2;
        //         return $output;
        //     })->then(function (int $output) {
        //         echo $output . "\n";
        //     });
        // }
        // await($pooling);



        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        // $rendererName = Settings::PDF_RENDERER_DOMPDF;
        // $rendererLibraryPath = '../vendor/dompdf/dompdf';
        // // dd($rendererLibraryPath);
        // // dd(\PhpOffice\PhpWord\Settings::setPdfRendererPath($rendererLibraryPath));
        // \PhpOffice\PhpWord\Settings::setPdfRendererPath($rendererLibraryPath);
        // \PhpOffice\PhpWord\Settings::setPdfRendererName($rendererName);

        // $writers = array('Word2007' => 'docx', 'HTML' => 'html', 'PDF' => 'pdf');

        // $template = new \PhpOffice\PhpWord\TemplateProcessor('temp/baptis.docx');
        // $template->setValue('npm', '201811001');
        // $template->setValue('nama', 'Deni Malik');

        // $filename = uniqid() . "." . "docx";
        // if (!file_exists('assets/berkas/baptis') && !is_dir('assets/berkas/baptis')) {
        //     mkdir("assets/berkas/baptis/");
        // }
        // $pathToSave = 'assets/berkas/baptis/' . $filename;
        // $template->saveAs($pathToSave);

        // $phpWord = IOFactory::load($pathToSave, 'Word2007');
        // $phpWord->save('assets/berkas/baptis/sampledocument.pdf', 'PDF');

        // // $phpWord = \PhpOffice\PhpWord\IOFactory::load($pathToSave);
        // // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        // // $xmlWriter->save("assets/berkas/baptis/sampledocument.pdf");  // Save to PDF
        // // $temp = \PhpOffice\PhpWord\IOFactory::load($pathToSave);

        // // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($temp, 'PDF');
        // // $xmlWriter->save('assets/berkas/baptis/sampledocument.pdf', TRUE);
    }
}
