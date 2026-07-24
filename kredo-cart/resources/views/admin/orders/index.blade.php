@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-10 p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Orders Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's orders
                        </p>
                    </div>

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
                                    <td>{{ optional($order->user)->name ?? 'Unknown Customer' }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($order->status == 'processing')
                                            <span class="badge bg-primary">Processing</span>
                                        @elseif ($order->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif ($order->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-flex gx-2">
                                        @csrf
                                        @method('PATCH')
                                            <select name="status" class="form-select">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                    Processing</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-outline-primary btn-lg">Update</button>
                                        </form>
                                    </td>

                                    <td>{{ $order->updated_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal"
                                            data-bs-target="#delete-order-{{ $order->id }}"><i
                                                class="fa-solid fa-trash-can text-danger"></i>
                                        </button>
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
