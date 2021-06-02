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
            <a class="navbar-brand" href="javascript:void(0)" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">GBI PPL <?php 
             $region = user()->toArray()['region'];
             if($region == "Kopo"){
                 echo $region;
             }else{
                 echo strtoupper($region);
             }
            
            ?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">

                
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
                        <li class="nav-link"><a href="<?= base_url('/logout'); ?>" class="nav-item dropdown-item">Log out</a>
                        </li>
                    </ul>
                    <!-- normal dropdown end -->
                </li>
                <li class="separator d-lg-none"></li>
            </ul>
        </div>
    </div>
</nav>