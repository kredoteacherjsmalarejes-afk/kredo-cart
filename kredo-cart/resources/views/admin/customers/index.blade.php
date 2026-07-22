@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-9 gx-5 p-2">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Customers Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's customers
                        </p>
                    </div>
                </div>

                <table class="table table-hover align-middle bg-white border">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Registered</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->role }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#delete-customer-{{ $customer->id }}"><i class="fa-solid fa-trash-can text-danger"></i></button>
                                    @include('admin.customers.modals.delete')

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
