<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url() ?>/temp/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3" style="color:black">Jumlah Keluarga <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <a href="<?= base_url('keluarga') ?>">
                            <h2 class="mb-5">
                            <?= $jumlah['keluarga']?>
                            </h2>
                        </a>
                        <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url() ?>/temp/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3" style="color:black">Jumlah Anggota <i class=" mdi mdi-account-check mdi-24px float-right"></i>
                        </h4>
                        <a href="<?= base_url('anggota') ?>">
                            <h2 class="mb-5">
                            <?= $jumlah['anggota']?>
                            </h2>
                        </a>
                        <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h4>Daftar Ulang Tahun Hari ini</h4></div>
            <div class="card-body">
                <table class="table table bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Umur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($anggota as $key=>$value):?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td><?=$value->nama?></td>
                                <td><?=$value->tempat_lahir.", ". $value->tanggal_lahir?></td>
                                <td><?=$value->umur?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
<?= $this->endSection() ?>