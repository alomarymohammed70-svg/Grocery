<!-- الشريط الجانبي -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2><i class="fas fa-store"></i> نظام البقالة</h2>
    </div>

    <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>لوحة التحكم</span>
        </a>

        <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>إدارة الأصناف</span>
        </a>

        <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>إدارة المنتجات</span>
        </a>

        <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
            <i class="fas fa-warehouse"></i>
            <span>إدارة المخزون</span>
        </a>

        <a href="{{ route('sales.index') }}" class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>المبيعات</span>
        </a>

        <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>العملاء والديون</span>
        </a>

        <a href="{{ route('suppliers.index') }}" class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            <span>الموردين</span>
        </a>

        <a href="{{ route('purchases.index') }}" class="nav-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <i class="fas fa-cart-plus"></i>
            <span>المشتريات</span>
        </a>

        <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>التقارير</span>
        </a>

        <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>الإعدادات</span>
        </a>

        <!-- زر تسجيل الخروج (زر فعّال حقيقي POST) -->
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="nav-item logout-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>تسجيل الخروج</span>
            </button>
        </form>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div class="user-info">
                <h4>{{ Auth::user()->name }}</h4>
                <p>مدير النظام</p>
            </div>
        </div>
    </div>
</div>
