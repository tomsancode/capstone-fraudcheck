@extends('admin.layout.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h4 class="text-capitalize">Data Order</h4>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">
                                    {{ $pendingOrders->count() }}
                                    <span class="ms-2">Pending</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#created" role="tab" aria-controls="created" aria-selected="false">
                                    {{ $createdOrders->count() }}
                                    <span class="ms-2">Created</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#shipped" role="tab" aria-controls="shipped" aria-selected="false">
                                    {{ $shippedOrders->count() }}
                                    <span class="ms-2">Shipped</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#delivered" role="tab" aria-controls="delivered" aria-selected="false">
                                    {{ $deliveredOrders->count() }}
                                    <span class="ms-2">Delivered</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Existing Tabs -->

                        <!-- Pending Tab Content -->
<div class="tab-pane fade show active" id="pending" role="tabpanel">
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Point</th>
                    <th>Feeder Type</th>
                    <th>Request Quantity</th>
                    <th>Driver PIC</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingOrders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer->name ?? 'No Customer' }}</td>
                    <td>{{ $order->point->point_name ?? 'No Point' }}</td>
                    <td>{{ $order->getFirstCoboxNameAttribute() }}</td>
                    <td>{{ $order->getTotalQuantityAttribute() }}</td>
                    <td>{{ $order->user->username ?? 'Not Assigned' }}</td>
                    <td>
                        <a href="{{ route('DetailOrder', ['orderId' => $order->order_id]) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Created Tab Content -->
<div class="tab-pane fade" id="created" role="tabpanel">
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Point</th>
                    <th>Feeder Type</th>
                    <th>Request Quantity</th>
                    <th>Driver PIC</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($createdOrders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer->name ?? 'No Customer' }}</td>
                    <td>{{ $order->point->point_name ?? 'No Point' }}</td>
                    <td>{{ $order->getFirstCoboxNameAttribute() }}</td>
                    <td>{{ $order->getTotalQuantityAttribute() }}</td>
                    <td>{{ $order->user->username ?? 'Not Assigned' }}</td>
                    <td>
                        <a href="{{ route('DetailOrder', ['orderId' => $order->order_id]) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
                        <!-- Shipped Tab Content -->
                        <div class="tab-pane fade" id="shipped" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Point</th>
                                            <th>Feeder Type</th>
                                            <th>Request Quantity</th>
                                            <th>Driver PIC</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shippedOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->customer->name ?? 'No Customer' }}</td>
                                            <td>{{ $order->point->point_name ?? 'No Point' }}</td>
                                            <td>{{ $order->getFirstCoboxNameAttribute() }}</td>
                                            <td>{{ $order->getTotalQuantityAttribute() }}</td>
                                            <td>{{ $order->user->username ?? 'Not Assigned' }}</td>
                                            <td>
                                                <a href="{{ route('DetailOrder', ['orderId' => $order->order_id]) }}" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delivered" role="tabpanel">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Point</th>
                                            <th>Feeder Type</th>
                                            <th>Request Quantity</th>
                                            <th>Driver PIC</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveredOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->customer->name ?? 'No Customer' }}</td>
                                            <td>{{ $order->point->point_name ?? 'No Point' }}</td>
                                            <td>{{ $order->getFirstCoboxNameAttribute() }}</td>
                                            <td>{{ $order->getTotalQuantityAttribute() }}</td>
                                            <td>{{ $order->user->username ?? 'Not Assigned' }}</td>
                                            <td>
                                                <a href="{{ route('DetailOrder', ['orderId' => $order->order_id]) }}" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
