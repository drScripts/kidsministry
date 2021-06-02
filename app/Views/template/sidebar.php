<div class="sidebar" data-aos="fade-right" data-aos-duration="500">
    <div class="sidebar-wrapper">
        <div class="logo" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
            <a href="<?= base_url(); ?>" class="simple-text logo-mini" >
                <?php 
                   $region = user()->toArray()['region'];

                    if($region == "Kopo"){
                        echo "KP";
                    }else{
                        echo strtoupper($region);
                    }
                ?>
            </a>
            <a href="<?= base_url(); ?>" class="simple-text logo-normal" >
                GBI PPL <?php 
                    if($region == "Kopo"){
                        echo $region;
                    }else{
                        echo strtoupper($region);
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
            <li class="<?= (strpos(current_url(true)->getPath(),'children') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="600">
                <a href="<?= base_url('/children') ?>">
                    <i class="fas fa-users"></i>
                    <p>Childrens</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(),'pembimbing') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
                <a href="<?= base_url('/pembimbing'); ?>">
                    <i class="fas fa-universal-access"></i>
                    <p>Pembimbing</p>
                </a>
            </li>
            <li class="<?= (strpos(current_url(true)->getPath(),'absensi') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="800">
                <a href="<?= base_url('/absensi'); ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Absensi</p>
                </a>
            </li>
            <li class="<?=(strpos(current_url(true)->getPath(),'history') !== false ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                <a href="<?= base_url('/history'); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <p>History Absensi</p>
                </a>
            </li>
           <?php if(user()->toArray()['status_region'] == "Super"): ?>
            <li class="<?= (isset($title) && $title === 'Google Token' ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1000">
                <a href="./user.html">
                    <i class="fas fa-key"></i>
                    <p>Google Token</p>
                </a>
            </li>
            <li class="<?= (isset($title) && $title === 'Teams' ? 'active' : ' '); ?>" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
                <a href="./typography.html">
                    <i class="fas fa-user"></i>
                    <p>Team's</p>
                </a>
            </li>
           <?php endif; ?>
        </ul>
    </div>
</div>