<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="?p=dashboard" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2"><?= $WEB_NAME ?></span>
    </a>

    <a href=" javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?= isset($_GET['p']) ? ($split[0] == 'dashboard' ? 'active' : '') : 'active' ?>">
      <a href="?p=dashboard" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Master Data</span>
    </li>

    <li class="menu-item <?= $split[0] == 'produk' ? 'active' : '' ?>">
      <a href="?p=produk" class="menu-link">
        <i class="menu-icon tf-icons bx bx-package"></i>
        <div data-i18n="Analytics">Produk</div>
      </a>
    </li>

    <li class="menu-item <?= $split[0] == 'penjualan' ? 'active' : '' ?>">
      <a href="?p=penjualan" class="menu-link">
        <i class="menu-icon tf-icons bx bx-store"></i>
        <div data-i18n="Analytics">Penjualan</div>
      </a>
    </li>
    <?php if (in_array($_SESSION['level'], ['admin'])) : ?>
      <li class="menu-item <?= $split[0] == 'dataset' ? 'active' : '' ?>">
        <a href="?p=dataset" class="menu-link">
          <i class="menu-icon tf-icons bx bx-data"></i>
          <div data-i18n="Analytics">Dataset</div>
        </a>
      </li>
    <?php endif; ?>

    <?php if (in_array($_SESSION['level'], ['kasir'])) : ?>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Transaksi</span>
      </li>

      <li class="menu-item <?= $split[0] == 'transaksi' ? 'active' : '' ?>">
        <a href="?p=transaksi" class="menu-link">
          <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
          <div data-i18n="Analytics">Transaksi</div>
        </a>
      </li>

    <?php endif; ?>

    <?php if (in_array($_SESSION['level'], ['admin', 'manager'])) : ?>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Process</span>
      </li>

      <li class="menu-item <?= $split[0] == 'cmeans' ? 'active' : '' ?>">
        <a href="?p=cmeans" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div data-i18n="Analytics">Fuzzy C-Means</div>
        </a>
      </li>

    <?php endif; ?>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Laporan</span>
    </li>

    <li class="menu-item <?= $split[0] == 'laporan' ? 'active' : '' ?>">
      <a href="?p=laporan" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Analytics">Laporan</div>
      </a>
    </li>

  </ul>
</aside>
<!-- / Menu -->