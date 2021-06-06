<div class="sidebar" data-aos="fade-right" data-aos-duration="500">
    <div class="sidebar-wrapper">
        <div class="logo" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
            <a href="<?= base_url(); ?>" class="simple-text logo-mini">
                <?php

                use App\Models\CabangModel;

                $cabangModel = new CabangModel();
                $cabang = $cabangModel->getCabang(user()->toArray()['region'])['nama_cabang'];

                if ($cabang == "Kopo") {
                    echo "KP";
                } else {
                    echo strtoupper($cabang);
                }
                ?>
            </a>
            <a href="<?= base_url(); ?>" class="simple-text logo-normal">
                GBI PPL <?php
                        if ($cabang == "Kopo") {
                            echo $cabang;
                        } else {
                            echo strtoupper($cabang);
                        }
                        ?>
            </a>
        </div>
        <ul class="nav">
            <li class="<?= (current_url(true)->getPath() === '/' ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
                <a href="<?= base_url(); ?>">
                    <i class="fas fa-chart-pie"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(), 'children') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="600">
                <a href="<?= base_url('/children') ?>">
                    <i class="fas fa-users"></i>
                    <p>Childrens</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(), 'pembimbing') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
                <a href="<?= base_url('/pembimbing'); ?>">
                    <i class="fas fa-universal-access"></i>
                    <p>Pembimbing</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(), 'absensi') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="800">
                <a href="<?= base_url('/absensi'); ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Absensi</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(), 'history') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                <a href="<?= base_url('/history'); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <p>History Absensi</p>
                </a>
            </li> 
            <?php if (in_groups('superadmin') || in_groups('pusat')) : ?>
                <li class="<?= (strpos(current_url(true)->getPath(), 'team') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
                    <a href="<?= base_url('/team'); ?>">
                        <i class="fas fa-user"></i>
                        <p>Team's</p>
                    </a>
                </li> 
            <?php endif; ?>
        </ul>
    </div>
</div>