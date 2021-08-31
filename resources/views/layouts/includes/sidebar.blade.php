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
{{--            <li class=" nav-item">--}}
{{--                <a href="ecommerce-product-shop.html">--}}
{{--                    <i class="la la-th-large"></i>--}}
{{--                    <span class="menu-title" data-i18n="Shop">Shop</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li class=" nav-item"><a href="#"><i class="la la-cart-plus"></i><span class="menu-title" data-i18n="Invoice">Purchase</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('purchases.index') }}"><i></i><span data-i18n="Invoice Summary">Purchase list</span></a></li>
                    <li><a class="menu-item" href="{{ route('purchases.create') }}"><i></i><span data-i18n="Invoice Template">Add Purchase</span></a></li>
                    <li><a class="menu-item" href="{{ route('brand.index') }}"><i></i><span data-i18n="Invoice List">Purchase Return</span></a></li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="la la-cart-plus"></i><span class="menu-title" data-i18n="Invoice">Sell</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('sells.index') }}"><i></i><span data-i18n="Invoice Summary">Sell list</span></a></li>
                    <li><a class="menu-item" href="{{ route('sells.create') }}"><i></i><span data-i18n="Invoice Template">Add Sell</span></a></li>
                    <li><a class="menu-item" href="{{ route('pos.index') }}"><i></i><span data-i18n="Invoice List">Pos</span></a></li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="la la-list-ul"></i><span class="menu-title" data-i18n="Invoice">Product</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('products.index') }}"><i></i><span data-i18n="Invoice Summary">Product list</span></a></li>
                    <li><a class="menu-item" href="{{ route('products.create') }}"><i></i><span data-i18n="Invoice Template">Create Product</span></a></li>
                    <li><a class="menu-item" href="{{ route('brand.index') }}"><i></i><span data-i18n="Invoice List">Brand</span></a></li>
                    <li><a class="menu-item" href="{{ route('category.index') }}"><i></i><span data-i18n="Invoice List">Category</span></a></li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="Invoice">Contacts</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item" href="{{ route('contacts.index', ['type'=>'customer']) }}">
                            <span>Customer list</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item" href="{{ route('contacts.index', ['type'=>'supplier']) }}">
                            <span>Supplier list</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="fal fa-file-invoice-dollar"></i><span class="menu-title" data-i18n="Invoice">Expanse</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item" href="{{ route('expenses.index') }}">
                            <span>Expanse list</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item" href="{{ route('expenses.create') }}">
                            <span>New Expanse</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item" href="{{ route('expanse_heads.index') }}">
                            <span>Expanse heads</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="fal fa-money-check-edit-alt"></i><span class="menu-title" data-i18n="Invoice">Payment Accounts</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item" href="{{ route('bank_accounts.index') }}">
                            <span>Account list</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-cogs"></i><span class="menu-title" data-i18n="Invoice">Setting</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item" href="{{ route('business_locations.index') }}">
                            <span>Business Locations</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
