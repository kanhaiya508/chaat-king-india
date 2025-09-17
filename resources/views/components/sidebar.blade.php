<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">

            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-smart-home"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <!-- orders -->
            <li class="menu-item {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-shopping-cart-plus"></i>

                    <div data-i18n="New Order">New Order</div>
                </a>
            </li>

            <!-- Order -->
            <li class="menu-item {{ request()->routeIs('order.show') ? 'active' : '' }}">
                <a href="{{ route('order.show') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-list-details"></i>
                    <div data-i18n="Order">Order</div>
                </a>
            </li>

            <!-- Event Booking (as-is) -->
            <li class="menu-item {{ request()->routeIs('event.booking.form') ? 'active' : '' }}">
                <a href="{{ route('event.booking.form') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-calendar-event"></i>
                    <div data-i18n="Event Booking">Event Booking</div>
                </a>
            </li>


            <!-- Menu (Standalone Dropdown) -->
            <li class="menu-item {{ request()->routeIs('categories', 'item-form') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ti tabler-clipboard-list"></i>
                    <div data-i18n="Menu">Menu</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('categories') ? 'active' : '' }}">
                        <a href="{{ route('categories') }}" class="menu-link">
                            <div data-i18n="Categories">Categories</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('item-form') ? 'active' : '' }}">
                        <a href="{{ route('item-form') }}" class="menu-link">
                            <div data-i18n="Item">Item</div>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Tables (Standalone Dropdown) -->
            <li
                class="menu-item {{ request()->routeIs('tablecategories.manage', 'tables.manage') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ti tabler-layout-grid"></i>
                    <div data-i18n="Tables">Tables</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('tablecategories.manage') ? 'active' : '' }}">
                        <a href="{{ route('tablecategories.manage') }}" class="menu-link">
                            <div data-i18n="Table Categories">Table Categories</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('tables.manage') ? 'active' : '' }}">
                        <a href="{{ route('tables.manage') }}" class="menu-link">
                            <div data-i18n="Tables">Tables</div>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Event Halls (Standalone Dropdown) -->
            <li class="menu-item {{ request()->routeIs('eventhalls.manage', 'slots.manage') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ti tabler-building-skyscraper"></i>
                    <div data-i18n="Event Halls">Event Halls</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('eventhalls.manage') ? 'active' : '' }}">
                        <a href="{{ route('eventhalls.manage') }}" class="menu-link">
                            <div data-i18n="Event Hall List">Event Hall List</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('slots.manage') ? 'active' : '' }}">
                        <a href="{{ route('slots.manage') }}" class="menu-link">
                            <div data-i18n="Slots">Slots</div>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Users & Roles (Standalone Dropdown) -->
            <li
                class="menu-item {{ request()->routeIs('users.*', 'roles.*', 'branches.*', 'users', 'roles', 'branches', 'staff') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fas fa-cogs"></i>
                    <div data-i18n="Software Manage">Software Manage</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div data-i18n="User List">User List</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="menu-link">
                            <div data-i18n="Roles">Roles</div>
                        </a>
                    </li>
                    @can('branche-list')
                        <li class="menu-item {{ request()->routeIs('branches.index') ? 'active' : '' }}">
                            <a href="{{ route('branches.index') }}" class="menu-link">
                                <div data-i18n="Branches">Branches</div>
                            </a>
                        </li>
                    @endcan

                    @can('staff-list')
                        <li class="menu-item {{ request()->routeIs('staff.index') ? 'active' : '' }}">
                            <a href="{{ route('staff.index') }}" class="menu-link">
                                <div data-i18n="staff">Staff</div>
                            </a>
                        </li>
                    @endcan

                    @can('other-expense-list')
                        <li class="menu-item {{ request()->routeIs('other-expenses.index') ? 'active' : '' }}">
                            <a href="{{ route('other-expenses.index') }}" class="menu-link">
                                <div data-i18n="Other Expense">Other Expense</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>



        </ul>
    </div>
</aside>
