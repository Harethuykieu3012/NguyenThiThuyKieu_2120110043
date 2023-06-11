@extends('layouts.admin')
@section('title', 'Chi tiết khách hàng')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CHI TIẾT KHÁCH HÀNG</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                            </li>
                            <li class="breadcrumb-item active">Chi tiết khách hàng</li>
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

                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('customer.edit', ['customer' => $customer->id]) }}"
                                class=" btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <a href="{{ route('customer.delete', ['customer' => $customer->id]) }}"
                                class=" btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>Xóa
                            </a>
                            <a href="{{ route('customer.index') }}" class=" btn btn-sm btn-info">
                                <i class="fas fa-long-arrow-alt-left"></i>Quay về danh sách
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                       <tr>
                    <th style="width:200px;">Tên trường</th>
                    <th>Giá trị</th>
                  </tr>
                  <tr>
                    <td>Id</td>
                    <td>{{$customer->id}}</td>
                  </tr>
                  <tr>
                    <td>Họ tên khách hàng</td>
                    <td>{{$customer->name}}</td>
                  </tr>  
                  <tr>
                    <td>Tên đăng nhập</td>
                    <td>{{$customer->username}}</td>
                  </tr>
                  <tr>
                    <td>Số điện thoại</td>
                    <td>{{$customer->phone}}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td>{{$customer->email}}</td>
                  </tr>
                  <tr>
                    <td>Địa chỉ</td>
                    <td>{{$customer->address}}</td>
                  </tr>

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
