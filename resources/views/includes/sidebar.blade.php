<nav class="nav flex-column">
  <a class="nav-link" href="{{ route('home') }}">Home</a>
  @can('superadmin-only')
  <a class="nav-link" href="{{ route('people.index') }}">Pengguna</a>
  <a class="nav-link" href="{{ route('customers.index') }}">Pelanggan</a>
  <a class="nav-link" href="{{ route('bank_accounts.index') }}">Bank</a>
  <a class="nav-link" href="{{ route('item_groups.index') }}">Item Group</a>
  <a class="nav-link" href="{{ route('item_sub_categories.index') }}">Item Sub Category</a>
  <a class="nav-link" href="{{ route('items.index') }}">Item</a>
  <a class="nav-link" href="{{ route('prices.index') }}">Harga</a>
  <a class="nav-link" href="{{ route('vehicles.index') }}">Kendaraan</a>
  <a class="nav-link" href="{{ route('couriers.index') }}">Kurir</a>
  @endcan
</nav>