    <aside class="col-md-2 bg-dark text-white p-4">
        <h4>Admin</h4>

        <hr class="text-white">

        <nav class="nav flex-column">
            <a href="{{ route('admin.products.index') }}" class="nav-link text-white {{ request()->is('admin/products') ? 'bg-warning' : '' }}">
                Products
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white {{ request()->is('admin/categories') ? 'bg-warning' : '' }}">
                Categories
            </a>

            <a href="{{ route('admin.orders.index') }}" class="nav-link text-white {{ request()->is('admin/orders') ? 'bg-warning' : '' }}">
                Orders
            </a>

            <a href="{{ route('admin.customers.index') }}" class="nav-link text-white {{ request()->is('admin/customers') ? 'bg-warning' : '' }} ">
                Customers
            </a>
        </nav>
    </aside>
