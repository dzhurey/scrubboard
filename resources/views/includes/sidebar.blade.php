<nav class="nav flex-column">
  <a class="nav-link" href="{{ route('home') }}">Home</a>
  @can('superadmin-only')
  <a class="nav-link" href="{{ route('people.index') }}">Pengguna</a>
  <a class="nav-link" href="{{ route('customers.index') }}">Pelanggan</a>
  <a class="nav-link" href="{{ route('bank_accounts.index') }}">Bank</a>
  <a class="nav-link" href="{{ route('vehicles.index') }}">Kendaraan</a>
  <a class="nav-link" href="{{ route('couriers.index') }}">Kurir</a>
  @endcan
</nav>