<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img
                    src="assets/dashboard/assets/img/kaiadmin/logo_light.svg"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a

                        href="index.php"
                        class="collapsed"
                        aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>

                    </a>

                </li>
                <?php if ($_SESSION['id_level'] == 7) { ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                    <li class="nav-item">
                        <a href="?pg=user">
                            <p>User</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="?pg=level">
                            <p>Level</p>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?pg=customer">
                            <p>Customer</p>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="?pg=paket">
                            <p>Paket</p>

                        </a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['id_level'] == 7 or $_SESSION['id_level'] == 8) { ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Data Transaksi</h4>
                    </li>

                    <li class="nav-item">
                        <a href="?pg=trans-order">
                            <p>Transksi</p>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?pg=trans-pick">
                            <p>Pengambilan Laundry</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?pg=laporan">
                            <p>Laporan</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>