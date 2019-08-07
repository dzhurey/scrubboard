@if ($customers->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table class="c-table table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Registered</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>
                    {{ Form::open(['url' => route('customers.destroy', ['customer' => $customer->id]), 'method' => 'delete']) }} {{ csrf_field()
                    }}
                    <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="btn btn-light is-small table-action" data-toggle="tooltip"
                        data-placement="top" title="Edit">
                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt="edit" width="16">
                    </a>
                    <button type="submit" class="btn btn-light is-small table-action" data-toggle="tooltip" data-placement="top" title="Delete">
                        <img src="{{ asset('assets/images/icons/trash.svg') }}" alt="trash" width="16">
                    </button>
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div>
        {{ $customers->links() }}
    </div>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data customers</h1>
    <p style="opacity: 0.5">Your customers data will show here</p>
</div>
@endif
