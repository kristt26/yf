<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Add Anggota Keluarga</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('keluarga') ?>">Keluarga</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="addAnggotaController">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form ng-submit="save()">
                    <div class="d-flex justify-content-center ">
                        <div class="row gutters-sm">
                            <div class="author-card pb-2">
                                <div class="author-card-profile">
                                    <div class="author-card-avatar" ng-click="openFile()">
                                        <img ng-show="model.berkas" data-ng-src="data:{{model.berkas.filetype}};base64,{{model.berkas.base64}}" />
                                        <img ng-show="!model.berkas" ng-src="{{photo}}" alt="Daniel Adams">
                                    </div>
                                </div>
                                <div style="padding-left: 38px;">
                                    <button type="button" class="btn btn-info btn-sm" ng-click="openFile()">Upload Photo</button>
                                </div>
                                <input type="file" id='my_file' name="files" style="display: none;" accept="image/*" ng-model="model.berkas" maxsize="1000" base-sixty-four-input />
                                <span style="color: red;" ng-show="form.files.$error.maxsize">Tidak boleh leboh dari 1 Mb</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Keluarga</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nomor KK &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" ng-model="datas.nomor" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Kepala Keluarga &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" name="namaKepala" id="namaKepala" ng-model="kepalaKeluarga.nama" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- Data Diri -->
                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Diri</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="jenis_identitas">Jenis Identitas &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.jenis_identitas.$dirty && signupform.jenis_identitas.$invalid">
                                    <small class="" ng-show="signupform.jenis_identitas.$error.required">
                                        Wajib*
                                    </small>
                                    <small class="" ng-show="signupform.jenis_identitas.$error.minlength">
                                        minimal 16 karakter
                                    </small>
                                </span>
                                <select name="jenis_identitas" id="jenis_identitas" ui-select2 class="form-control form-control-sm select2" data-placeholder="Jenis Identitas" ng-model="model.jenis_identitas" required>
                                    <option value=""></option>
                                    <option value="KTP">KTP</option>
                                    <option value="KTA">KTA</option>
                                    <option value="Paspor">Paspor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nomor_identitas">Nomor NIK &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nomor_identitas.$dirty && signupform.nomor_identitas.$invalid">
                                    <small class="" ng-show="signupform.nomor_identitas.$error.required">
                                        Wajib*
                                    </small>
                                    <small class="" ng-show="signupform.nomor_identitas.$error.minlength">
                                        minimal 16 karakter
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="nomor_identitas" id="nomor_identitas" ng-model="model.nomor_identitas" placeholder="Nomor Identitas" minlength=1 maxlength=16 required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama">Nama &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nama.$dirty && signupform.nama.$invalid">
                                    <small class="" ng-show="signupform.nama.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" capitalize name="nama" id="nama" ng-model="model.nama" placeholder="Nama sesuai KTP" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hubungan">Hubungan keluarga &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.hubungan.$dirty && signupform.hubungan.$invalid">
                                    <small class="" ng-show="signupform.hubungan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="hubungan" id="hubungan" ui-select2 class="form-control form-control-sm select2" data-placeholder="Pilih hubungan Keluarga" ng-options="item as item for item in hubungan" ng-model="model.hubungan_keluarga" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.tempat_lahir.$dirty && signupform.tempat_lahir.$invalid">
                                    <small class="" ng-show="signupform.tempat_lahir.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="tempat_lahir" id="tempat_lahir" ng-model="model.tempat_lahir" placeholder="Tempat Lahir" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.tanggal_lahir.$dirty && signupform.tanggal_lahir.$invalid">
                                    <small class="" ng-show="signupform.tanggal_lahir.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="date" class="form-control form-control-sm" name="tanggal_lahir" id="tanggal_lahir" ng-model="model.tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.gender.$dirty && signupform.gender.$invalid">
                                    <small class="" ng-show="signupform.gender.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="gender" id="gender" ui-select2 class="form-control form-control-sm select2" data-placeholder="Pilih jenis kelamin" ng-model="model.gender" required>
                                    <option value=""></option>
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="golongan_darah">Golongan Darah &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.golongan_darah.$dirty && signupform.golongan_darah.$invalid">
                                    <small class="" ng-show="signupform.golongan_darah.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="golongan_darah" id="golongan_darah" ui-select2 class="form-control form-control-sm select2" data-placeholder="Pilih golongan darah" ng-options="item as item for item in golonganDarah track by item" ng-model="model.golongan_darah" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_perkawinan">Status Perkawinan &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.status_perkawinan.$dirty && signupform.status_perkawinan.$invalid">
                                    <small class="" ng-show="signupform.status_perkawinan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="status_perkawinan" id="status_perkawinan" ui-select2 class="form-control form-control-sm select2" data-placeholder="Pilih status perkawinan" ng-model="model.status_perkawinan" required>
                                    <option value=""></option>
                                    <option value="1">KAWIN</option>
                                    <option value="0">BELUM KAWIN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="agama">Agama &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.agama.$dirty && signupform.agama.$invalid">
                                    <small class="" ng-show="signupform.agama.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="agama" id="agama" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pilih Agama--" ng-options="item as item for item in agama" ng-model="model.agama" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pendidikan">Pendidikan Terakhir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.pendidikan.$dirty && signupform.pendidikan.$invalid">
                                    <small class="" ng-show="signupform.pendidikan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="pendidikan" id="pendidikan" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pendidikan terakhir--" ng-options="item as item for item in pendidikan" ng-model="model.pendidikan_terakhir" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.pekerjaan.$dirty && signupform.pekerjaan.$invalid">
                                    <small class="" ng-show="signupform.pekerjaan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="pekerjaan" id="pekerjaan" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pekerjaan--" ng-options="item as item for item in pekerjaan" ng-model="model.pekerjaan" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hobby">Hobby &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.hobby.$dirty && signupform.hobby.$invalid">
                                    <small class="" ng-show="signupform.hobby.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="hobby" id="hobby" placeholder="Hobby" ng-model="model.hobby" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="instansi">Instansi &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.instansi.$dirty && signupform.instansi.$invalid">
                                    <small class="" ng-show="signupform.instansi.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="instansi" id="instansi" placeholder="Instansi tempat kerja" ng-model="model.instansi" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jabatan">Jabatan &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.jabatan.$dirty && signupform.jabatan.$invalid">
                                    <small class="" ng-show="signupform.jabatan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="jabatan" id="jabatan" placeholder="Jabatan" ng-model="model.jabatan" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="hp">Telp/Hp &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.hp.$dirty && signupform.hp.$invalid">
                                    <small class="" ng-show="signupform.hp.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="hp" id="hp" placeholder="Kontak Telepon" ng-model="model.hp" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left-bold"></span> Batal
                        </a>
                        <button type="submit" ng-class="{'btn btn-success': !statusEdit, 'btn btn-warning': statusEdit}">
                            <span class="mdi mdi-plus-circle"></span> {{model.id ? 'Ubah' : 'Tambah'}}
                        </button>
                    </div>
                </form>
                <!-- Data KK -->
            </div>
        </div>
    </div>
</div>
<style>
    .widget-author {
        margin-bottom: 58px;
    }

    .author-card {
        position: relative;
        padding-bottom: 48px;
        background-color: #fff;
        /* box-shadow: 0 12px 20px 1px rgba(64, 64, 64, .09); */
    }

    .author-card .author-card-cover {
        position: relative;
        width: 100%;
        height: 100px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .author-card .author-card-cover::after {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        content: '';
        opacity: 0.5;
    }

    .author-card .author-card-cover>.btn {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0 10px;
    }

    .author-card .author-card-profile {
        display: table;
        position: relative;
        margin-top: -4px;
        padding-right: 15px;
        padding-bottom: 16px;
        padding-left: 20px;
        z-index: 5;
    }

    .author-card .author-card-profile .author-card-avatar,
    .author-card .author-card-profile .author-card-details {
        display: table-cell;
        vertical-align: middle;
    }

    .author-card .author-card-profile .author-card-avatar {
        width: 145px;
        border-radius: 50%;
        /* box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15); */
        overflow: hidden;
    }

    .author-card .author-card-profile .author-card-avatar>img {
        display: block;
        width: 100%;
    }

    .author-card .author-card-profile .author-card-details {
        padding-top: 20px;
        padding-left: 15px;
    }

    .author-card .author-card-profile .author-card-name {
        margin-bottom: 2px;
        font-size: 16px;
        font-weight: bold;
    }

    .author-card .author-card-profile .author-card-jurusan {
        margin-bottom: 2px;
        font-size: 14px;
        font-weight: bold;
    }

    .author-card .author-card-profile .author-card-npm {
        margin-bottom: 2px;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .author-card .author-card-profile .author-card-position {
        display: block;
        color: #8c8c8c;
        font-size: 12px;
        font-weight: 600;
    }

    .author-card .author-card-info {
        margin-bottom: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .author-card .author-card-social-bar-wrap {
        position: absolute;
        bottom: -18px;
        left: 0;
        width: 100%;
    }

    .author-card .author-card-social-bar-wrap .author-card-social-bar {
        display: table;
        margin: auto;
        background-color: #fff;
        box-shadow: 0 12px 20px 1px rgba(64, 64, 64, .11);
    }

    .btn-style-1.btn-white {
        background-color: #fff;
    }

    .list-group-item i {
        display: inline-block;
        margin-top: -1px;
        margin-right: 8px;
        font-size: 1.2em;
        vertical-align: middle;
    }

    .mr-1,
    .mx-1 {
        margin-right: .25rem !important;
    }

    .list-group-item.active:not(.disabled) {
        border-color: #e7e7e7;
        background: #fff;
        color: #ac32e4;
        cursor: default;
        pointer-events: none;
    }

    .list-group-flush:last-child .list-group-item:last-child {
        border-bottom: 0;
    }

    .list-group-flush .list-group-item {
        border-right: 0 !important;
        border-left: 0 !important;
    }

    .list-group-flush .list-group-item {
        border-right: 0;
        border-left: 0;
        border-radius: 0;
    }

    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .list-group-item:last-child {
        margin-bottom: 0;
        border-bottom-right-radius: .25rem;
        border-bottom-left-radius: .25rem;
    }

    a.list-group-item,
    .list-group-item-action {
        color: #404040;
        font-weight: 600;
    }

    .list-group-item {
        padding-top: 16px;
        padding-bottom: 16px;
        -webkit-transition: all .3s;
        transition: all .3s;
        border: 1px solid #e7e7e7 !important;
        border-radius: 0 !important;
        color: #404040;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        text-decoration: none;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: .75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .list-group-item.active:not(.disabled)::before {
        background-color: #ac32e4;
    }

    .list-group-item::before {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background-color: transparent;
        content: '';
    }
</style>
<?= $this->endSection() ?>