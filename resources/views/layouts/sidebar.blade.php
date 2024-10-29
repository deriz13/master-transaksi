<div class="sb-sidenav-menu">
    <div class="nav">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            Dashboard
        </a>
        
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Master
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('master_category.index') }}">Master Kategori COA</a>
                <a class="nav-link" href="{{ route('master_chart.index') }}">Master Chart Of Account</a>
            </nav>
        </div>
        <a class="nav-link" href="{{ route('transaction.index') }}">
            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Transaksi
        </a>
        <a class="nav-link" href="{{ route('report.index') }}">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Laporan Profit / Los
        </a>
    </div>
</div>