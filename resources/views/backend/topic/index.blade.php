@extends('layouts.admin')
@section('title', 'Tất cả chủ đề')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>TẤT CẢ CHỦ ĐỀ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả chủ đề</li>
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
                            <a href="{{ route('topic.create') }}" class=" btn btn-sm btn-success">
                                <i class="fas fa-plus"></i>Thêm
                            </a>
                            <a href="{{ route('topic.trash')}}" class=" btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>Thùng rác
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:20px;" class="text-center">#</th>
                                <th style="width:90px;" class="text-center">Hình</th>
                                <th>Tên chủ đề </th>
                                <th>Slug</th>
                                <th>Ngày đăng</th>
                                <th style="width:250px;" class="text-center">Chức năng</th>
                                <th style="width:20px;" class="text-center">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_topic as $topic)
                                <tr>

                                    <td class="text-center">
                                        <input type="checkbox">
                                    </td>
                                    <td> <img class="img-fluid" src="{{asset('images/topic/'.$topic->image)}}" 
                                        alt="{{$topic->image}}">
                                     </td>
                                    <td> {{ $topic->title }} </td>
                                    <td>{{ $topic->slug }}</td>
                                    <td class="text-center">{{ $topic->created_at }}</td>
                                    <td class="text-center">
                                        @if ($topic->status == 1)
                                            <a href="{{ route('topic.status', ['topic' => $topic->id]) }}"
                                                class="btn btn -sm btn-success">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('topic.status', ['topic' => $topic->id]) }}"
                                                class="btn btn -sm btn-danger">
                                                <i class="fas fa-toggle-off"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('topic.edit', ['topic' => $topic->id]) }}"
                                            class="btn btn -sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('topic.show', ['topic' => $topic->id]) }}"
                                            class="btn btn -sm btn-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('topic.delete', ['topic' => $topic->id]) }}"
                                            class="btn btn -sm btn-danger">
                                            <i class="fas fa-trash"></i></a>
                                    </td>
                                    <td>{{ $topic->id }}</td>
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
