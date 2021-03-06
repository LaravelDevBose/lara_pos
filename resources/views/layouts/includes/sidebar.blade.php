<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="active">
                <a href="{{ route('dashboard') }}">
                    <i class="la la-home"></i>
                    <span class="menu-title" data-i18n="eCommerce Dashboard">{{ auth()->user()->role_name }} Dashboard</span>
                </a>
            </li>
            <li class=" navigation-header">
                <span data-i18n="Ecommerce">Ecommerce</span>
                <i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Ecommerce"></i>
            </li>
            <li class=" nav-item">
                <a href="ecommerce-product-shop.html">
                    <i class="la la-th-large"></i>
                    <span class="menu-title" data-i18n="Shop">Shop</span>
                </a>
            </li>

            <li class=" nav-item"><a href="#"><i class="la la-clipboard"></i><span class="menu-title" data-i18n="Invoice">Product</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="invoice-summary.html"><i></i><span data-i18n="Invoice Summary">Product list</span></a></li>
                    <li><a class="menu-item" href="invoice-template.html"><i></i><span data-i18n="Invoice Template">Create Product</span></a></li>
                    <li><a class="menu-item" href="invoice-list.html"><i></i><span data-i18n="Invoice List">Brand</span></a></li>
                    <li><a class="menu-item" href="invoice-list.html"><i></i><span data-i18n="Invoice List">Category</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
