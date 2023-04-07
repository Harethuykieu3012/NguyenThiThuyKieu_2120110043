@extends('layouts.admin')
@section('title', 'Tất cả danh mục sản phẩm')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Blank Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Blank Page</li>
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
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('category.create') }}" class=" btn btn-sm btn-success"> Thêm</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục </th>
                                <th>Slug</th>
                                <th>Chức năng</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_category as $category)
                                <tr>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                    <td> {{ $category->name }} </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                            class="btn btn -sm btn-info">Edit</a>
                                        <a href="{{ route('category.show', ['category' => $category->id]) }}"
                                            class="btn btn -sm btn-success">View</a>
                                        <a href="{{ route('category.destroy', ['category' => $category->id]) }}"
                                            class="btn btn -sm btn-danger">Delete</a>
                                    </td>
                                    <td>{{ $category->id }}</td>
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
