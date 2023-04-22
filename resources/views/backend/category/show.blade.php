@extends('layouts.admin')
@section('title', 'Chi tiết mục sản phẩm')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CHI TIẾT DANH MỤC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                            </li>
                            <li class="breadcrumb-item active">Chi tiết danh mục</li>
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
                            <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                class=" btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <a href="{{ route('category.delete', ['category' => $category->id]) }}"
                                class=" btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>Xóa
                            </a>
                            <a href="{{ route('category.index') }}" class=" btn btn-sm btn-info">
                                <i class="fas fa-long-arrow-alt-left"></i>Quay về danh sách
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tên trường</th>
                            <th>Giá trị</th>
                        </tr>
                        <tr>
                            <td>Id</td>
                            <td> {{ $category->id }} </td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td> {{ $category->name }} </td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td> {{ $category->slug }} </td>
                        </tr>
                        <tr>
                            <td>Danh mục cha</td>
                            <td> {{ $category->parent_id }} </td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td> <img style="width:300px" class="img-fluid "
                                    src="{{ asset('images/category/' . $category->image) }}" alt="{{ $category->image }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Từ khóa</td>
                            <td> {{ $category->metakey }} </td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td> {{ $category->metadesc }} </td>
                        </tr>

                        <tr>
                            <td>Người tạo</td>
                            <td> {{ $category->created_by }} </td>
                        </tr>
                        <tr>
                            <td>Người cập nhật</td>
                            <td> {{ $category->updated_by }} </td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td> {{ $category->created_at }} </td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td> {{ $category->updated_at }} </td>
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
