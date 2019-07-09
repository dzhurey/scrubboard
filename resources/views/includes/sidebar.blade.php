<nav class="nav flex-column">
  <a class="nav-link" href="{{ route('home') }}">Home</a>
  @can('superadmin-only')
  <a class="nav-link" href="{{ route('people.index') }}">Pengguna</a>
  @endcan
  <a class="nav-link" href="{{ route('vehicles.index') }}">Kendaraan</a>
</nav>