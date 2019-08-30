<div class="c-sidebar">
    <div class="c-sidebar--logo mb-4">
        <div class="mb-4 text-center">
          <a class="{{ (request()->segment(1) == 'customers') ? 'is-active' : '' }}" href="{{ route('home') }}">
            <img class="logo-full" src="{{ asset('assets/images/logo-bebewash.png') }}" height="50">
            <img class="logo-icon" src="{{ asset('assets/images/ic-logo-bebewash.png') }}" height="40">
          </a>
        </div>
        <a class="btn btn-primary btn-block btn-lg" href="{{ route('sales_orders.create') }}" data-toggle="tooltip" data-placement="right"
            title="Sales Order">
            <span>
                <img class="svg" src="{{ asset('assets/images/icons/plus.svg') }}">
            </span>
            <span>Add Sales Order</span>
        </a>
    </div>
    <nav class="c-nav pb-5">
        <div class="c-nav--item" id="item" data-toggle="tooltip" data-placement="right" title="Item">
            <a class="{{ (request()->segment(1) == 'item_groups') ? 'is-active' : '' }}" href="{{ route('item_groups.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/package.svg') }}">
                </span>
                <span>Item Category</span>
            </a>
        </div>
        <div class="c-nav--item" id="item" data-toggle="tooltip" data-placement="right" title="Item">
            <a class="{{ (request()->segment(1) == 'item_sub_categories') ? 'is-active' : '' }}" href="{{ route('item_sub_categories.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/package.svg') }}">
                </span>
                <span>Item Sub Category</span>
            </a>
        </div>
        <div class="c-nav--item" id="agent" data-toggle="tooltip" data-placement="right" title="Agent">
            <a class="{{ (request()->segment(1) == 'agents') ? 'is-active' : '' }}" href="{{ route('agents.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/home.svg') }}">
                </span>
                <span>Outlet</span>
            </a>
        </div>
        <div class="c-nav--item" id="vehicle" data-toggle="tooltip" data-placement="right" title="Vehicle">
            <a class="{{ (request()->segment(1) == 'vehicles') ? 'is-active' : '' }}" href="{{ route('vehicles.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/truck.svg') }}">
                </span>
                <span>Vehicle</span>
            </a>
        </div>
        <div class="c-nav--item" id="bank" data-toggle="tooltip" data-placement="right" title="Bank">
            <a class="{{ (request()->segment(1) == 'bank_accounts') ? 'is-active' : '' }}" href="{{ route('bank_accounts.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/credit-card.svg') }}">
                </span>
                <span>Bank</span>
            </a>
        </div>
        <div class="c-nav--item" id="agent" data-toggle="tooltip" data-placement="right" title="Agent">
            <a class="{{ (request()->segment(1) == 'couriers') ? 'is-active' : '' }}" href="{{ route('couriers.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/users.svg') }}">
                </span>
                <span>Courier</span>
            </a>
        </div>
        <div class="c-nav--item" id="user" data-toggle="tooltip" data-placement="right" title="User">
            <a class="{{ (request()->segment(1) == 'people') ? 'is-active' : '' }}" href="{{ route('people.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/user-plus.svg') }}">
                </span>
                <span>User</span>
            </a>
        </div>
        <div class="c-nav--item" id="customer" data-toggle="tooltip" data-placement="right" title="Customer">
            <a class="{{ (request()->segment(1) == 'customers') ? 'is-active' : '' }}"  href="{{ route('customers.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/users.svg') }}">
                </span>
                <span>Customer</span>
            </a>
        </div>
        <div class="c-nav--item" id="item" data-toggle="tooltip" data-placement="right" title="Item">
            <a class="{{ (request()->segment(1) == 'items') ? 'is-active' : '' }}" href="{{ route('items.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/package.svg') }}">
                </span>
                <span>Item</span>
            </a>
        </div>
        <div class="c-nav--item" id="price" data-toggle="tooltip" data-placement="right" title="Price">
            <a class="{{ (request()->segment(1) == 'prices') ? 'is-active' : '' }}" href="{{ route('prices.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/dollar-sign.svg') }}">
                </span>
                <span>Price list</span>
            </a>
        </div>
        <div class="c-nav--item" id="sales" data-toggle="tooltip" data-placement="right" title="Sales Order" data-container="body">
            <a class="{{ (request()->segment(1) == 'sales_orders') ? 'is-active' : '' }}" href="{{ route('sales_orders.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/shopping-bag.svg') }}">
                </span>
                <span>Sales Order</span>
            </a>
        </div>
        <div class="c-nav--item" id="pickup_schedules" data-toggle="tooltip" data-placement="right" title="Pickup schedule">
            <a class="{{ (request()->segment(1) == 'pickup_schedules') ? 'is-active' : '' }}" href="{{ route('pickup_schedules.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/calendar.svg') }}">
                </span>
                <span>Pickup Schedules</span>
            </a>
        </div>
        <div class="c-nav--item" id="delivery_schedules" data-toggle="tooltip" data-placement="right" title="Delivery schedule">
            <a class="{{ (request()->segment(1) == 'delivery_schedules') ? 'is-active' : '' }}" href="{{ route('delivery_schedules.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/calendar.svg') }}">
                </span>
                <span>Delivery Schedules</span>
            </a>
        </div>
        <div class="c-nav--item" id="invoice" data-toggle="tooltip" data-placement="right" title="Invoices">
            <a class="{{ (request()->segment(1) == 'sales_invoices') ? 'is-active' : '' }}" href="{{ route('sales_invoices.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/file-text.svg') }}">
                </span>
                <span>Invoices</span>
            </a>
        </div>
        <div class="c-nav--item" id="courier_delivery_schedules" data-toggle="tooltip" data-placement="right" title="Pickup schedule">
            <a class="{{ (request()->segment(2) == 'pickup_schedules') ? 'is-active' : '' }}" href="{{ route('courier.pickup_schedules.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/calendar.svg') }}">
                </span>
                <span>Courier Pickup</span>
            </a>
        </div>
        <div class="c-nav--item" id="courier_delivery_schedules" data-toggle="tooltip" data-placement="right" title="Delivery schedule">
            <a class="{{ (request()->segment(2) == 'delivery_schedules') ? 'is-active' : '' }}" href="{{ route('courier.delivery_schedules.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/calendar.svg') }}">
                </span>
                <span>Courier Delivery</span>
            </a>
        </div>
        <div class="c-nav--item" id="payment" data-toggle="tooltip" data-placement="right" title="Payments">
            <a class="{{ (request()->segment(1) == 'payments') ? 'is-active' : '' }}" href="{{ route('payments.index') }}">
                <span class="mr-4">
                    <img class="svg" src="{{ asset('assets/images/icons/file-text.svg') }}">
                </span>
                <span>Payments</span>
            </a>
        </div>
    </nav>
</div>
