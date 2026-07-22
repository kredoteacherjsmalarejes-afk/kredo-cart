@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-9 gx-5 p-2">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Orders Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's orders
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.create') }}" class="btn btn-warning">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add New Orders
                    </a>
                </div>

                <table class="table table-hover align-middle bg-white border">
                    <thead class="table-dark text-white">
                        <tr>
                            <th></th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                            <th>Payment</th>
                            <th>Paced On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td></td>
                                <td>{{ $order->id }}</td>
                                <td>{{ optional($order->user)->name ?? 'Unknown Customer' }}</td >
                                <td>{{ $order->total_amount}}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->status }}</td>
                                <td></td>
                                <td><button type="button" class="btn btn-outline-primary btn-lg">Update</button></td>
                                <td>{{ $order->payment_status }}</td>
                                <td>


                                      <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#delete-order-{{ $order->id }}"><i class="fa-solid fa-trash-can text-danger"></i></button>
                                    @include('admin.orders.modals.delete')

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
