<div class="sb-sidenav-menu">
    <div class="nav">
        <a class="nav-link" style="{{ request()->routeIs('dashboard.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="{{ route('dashboard.index') }}">
            <div class="sb-nav-link-icon" style="{{ request()->routeIs('dashboard.index') ? 'color: black;' : '' }}"><i class="fas fa-tachometer-alt"></i></div>
            Dashboard
        </a>
        
        <a class="nav-link collapsed" style="{{ request()->routeIs('master_category.index') || request()->routeIs('master_chart.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon" style="{{ request()->routeIs('master_category.index') || request()->routeIs('master_chart.index') ? 'color: black;' : '' }}"><i class="fas fa-columns"></i></div>
            Master
            <div class="sb-sidenav-collapse-arrow" style="{{ request()->routeIs('master_category.index') || request()->routeIs('master_chart.index') ? 'color: black;' : '' }}"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" style="{{ request()->routeIs('master_category.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="{{ route('master_category.index') }}">Master Kategori COA</a>
                <a class="nav-link" style="{{ request()->routeIs('master_chart.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="{{ route('master_chart.index') }}">Master Chart Of Account</a>
            </nav>
        </div>
        <a class="nav-link" style="{{ request()->routeIs('transaction.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="{{ route('transaction.index') }}">
            <div class="sb-nav-link-icon" style="{{ request()->routeIs('transaction.index') ? 'color: black;' : '' }}"><i class="fas fa-wallet"></i></div>
            Transaksi
        </a>
        <a class="nav-link" style="{{ request()->routeIs('report.index') ? 'background-color: #CCCCCC; color: black;' : '' }}" href="{{ route('report.index') }}">
            <div class="sb-nav-link-icon" style="{{ request()->routeIs('report.index') ? 'color: black;' : '' }}"><i class="fas fa-chart-line"></i></div>
            Laporan Profit / Los
        </a>
    </div>
</div>