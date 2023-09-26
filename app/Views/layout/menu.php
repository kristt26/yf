<nav class="sidebar sidebar-offcanvas sidebar-fixed" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="<?= base_url('temp') ?>/assets/images/faces/account.png" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?= session()->get('level') ?></span>
                    <span class="text-secondary text-small"><?= session()->get('lembaga') ?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <?php if (session()->get('level') == 'Admin') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('keluarga') ?>">
                    <span class="menu-title">Keluarga</span>
                    <i class="mdi mdi-human-male-boy menu-icon"></i>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('anggota') ?>">
                    <span class="menu-title">Anggota Keluarga</span>
                    <i class="mdi mdi-human-male menu-icon"></i>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('laporan') ?>">
                    <span class="menu-title">Laporan</span>
                    <i class="mdi mdi-file-chart menu-icon"></i>
                </a>
            </li> 
            <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cetak" aria-expanded="false" aria-controls="cetak">
                <span class="menu-title">Cetak </span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-printer menu-icon"></i>
            </a>
            <div class="collapse" id="cetak">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('wijk') ?>">Keluarga</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('ksp') ?>">KSP</a></li>
                </ul>
            </div>
        </li> -->
        <?php endif; ?>
        <?php if (session()->get('level') == 'Administrator') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('gereja') ?>">
                    <span class="menu-title">Manajemen Gereja</span>
                    <i class="mdi mdi-church menu-icon"></i>
                </a>
            </li>
        <?php endif; ?>
        <?php if (session()->get('level') == 'Jemaat') : ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#jemaatLayanan" aria-expanded="false" aria-controls="jemaatLayanan">
                    <span class="menu-title">Layanan </span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="jemaatLayanan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_baptis') ?>">Baptis</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_sidi') ?>">SIDI</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_nikah') ?>">Nikah</a></li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</nav>