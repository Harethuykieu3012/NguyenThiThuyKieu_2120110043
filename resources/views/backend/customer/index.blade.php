@extends('layouts.admin')
@section('title', 'Danh sách khách hàng')
@section('header')
    <link rel="stylesheet" href="{{ asset('jquery.dataTables.min.css') }}">
@endsection
@section('footer')
    <script src="{{ asset('jquery.dataTables.min.js') }}"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DANH SÁCH KHÁCH HÀNG</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">danh sách khách hàng</li>
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-sm btn-danger" type="submit">
                                <i class=" fal  fa-file-times"></i> Xóa</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('customer.trash') }}" class=" btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>Thùng rác
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <table class="table table-bordered table-striped" id="myTable">

                        <thead>
                            <tr>
                                <th style="width:20px;" class="text-center">#</th>
                                <th style="width:90px;" class="text-center">Hình</th>
                                <th>Họ và tên </th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th style="width:250px;" class="text-center">Chức năng</th>
                                <th style="width:20px;" class="text-center">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_customer as $customer)
                                <tr>

                                    <td class="text-center">
                                        <input type="checkbox">
                                    </td>
                                    <td> <img class="img-fluid" src="{{ asset('images/customer/' . $customer->image) }}"
                                            alt="{{ $customer->image }}">
                                    </td>
                                    <td> {{ $customer->name }} </td>
                                    <td>{{ $customer->email }}</td>
                                    <td class="text-center">{{ $customer->phone }}</td>
                                    <td class="text-center">
                                        @if ($customer->status == 1)
                                            <a href="{{ route('customer.status', ['customer' => $customer->id]) }}"
                                                class="btn btn -sm btn-success">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('customer.status', ['customer' => $customer->id]) }}"
                                                class="btn btn -sm btn-danger">
                                                <i class="fas fa-toggle-off"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('customer.edit', ['customer' => $customer->id]) }}"
                                            class="btn btn -sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('customer.show', ['customer' => $customer->id]) }}"
                                            class="btn btn -sm btn-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customer.delete', ['customer' => $customer->id]) }}"
                                            class="btn btn -sm btn-danger">
                                            <i class="fas fa-trash"></i></a>
                                    </td>
                                    <td>{{ $customer->id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Footer
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>


@endsection
