    <aside class="col-md-2 bg-dark text-white p-3">
        <h4>Admin</h4>

        <nav class="nav flex-column">
            <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
                Products
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                Categories
            </a>

            <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                Orders
            </a>

            <a href="#" class="nav-link text-white">
                Customers
            </a>
        </nav>
    </aside>
