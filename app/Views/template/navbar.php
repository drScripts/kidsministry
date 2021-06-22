<?php

use App\Models\CabangModel;
use App\Models\ChildrenModel;

if (!in_groups('pusat')) {
    $childrenModel = new ChildrenModel();

    $childBirthDay = $childrenModel->birthDayChildren();
}

$cabangModel = new CabangModel();
$cabang = $cabangModel->getCabang(user()->toArray()['region'])['nama_cabang'];

?>

<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">GBI PPL
                <?php


                if ($cabang == "Kopo") {
                    echo $cabang;
                } else {
                    echo strtoupper($cabang);
                }

                ?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <?php if (!in_groups('pusat')) : ?>
                    <li class="dropdown nav-item">
                        <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <?= (count($childBirthDay) != 0) ? '<div class="notification d-none d-lg-block d-xl-block"></div>' : '' ?>
                            <i class="fas fa-birthday-cake"></i>
                            <p class="d-lg-none">
                                Birthday Notifications
                            </p>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                            <?php if (count($childBirthDay) == 0) : ?>
                                <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Tidak Ada Yang Ulang Tahun Dibulan Ini</a></li>
                            <?php else : ?>
                                <?php foreach ($childBirthDay as $birthDay) : ?>
                                    <?php if (
                                        date('m') == date('m', strtotime($birthDay['tanggal_lahir']))
                                    ) : ?>
                                        <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item"><?= $birthDay['children_name']; ?> - <?= date('d M Y', strtotime($birthDay['tanggal_lahir'])); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="dropdown nav-item">
                    <!-- on mobile -->
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
                        <div class="photo">
                            <img src="<?= base_url('/assets/img/anime3.png'); ?>" alt="Profile Photo">
                        </div>
                        <b class="caret d-none d-lg-block d-xl-block ml-2"></b>
                        <p class="d-lg-none">
                            Log out
                        </p>
                    </a>
                    <!-- on mobile end -->
                    <!-- normal dropdown -->
                    <ul class="dropdown-menu dropdown-navbar">

                        <li class="nav-link"><a href="#" class="nav-item dropdown-item"><?= user()->toArray()['username'] ?></a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <?php if (!in_groups('pusat')) : ?>
                            <li class="nav-link"><a href="<?= base_url('/settings'); ?>" class="nav-item dropdown-item">Settings</a></li>
                        <?php endif; ?>
                        <li class="nav-link"><a href="<?= base_url('/logout') . '/' . user()->toArray()['id']; ?>" class="nav-item dropdown-item">Log out</a>
                        </li>
                    </ul>
                    <!-- normal dropdown end -->
                </li>
                <li class="separator d-lg-none"></li>
            </ul>
        </div>
    </div>
</nav>