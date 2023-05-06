<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    // GET admin/page, admin/page/index
    public function index()
    {
        $list_page = Post::where([['status', '!=', 0], ['type', '=', 'page']])->orderBy('created_at', 'desc')->get();
        return view('backend.page.index', compact('list_page'));
    }
    // GET admin/page/trash
    public function trash()
    {
        $list_page = Post::where([['status', '=', 0], ['type', '=', 'page']])->orderBy('created_at', 'desc')->get();
        return view('backend.page.trash', compact('list_page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $page = new Post;
        $page->title = $request->title;
        $page->slug = Str::slug($page->title = $request->title, '-');
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->detail = $request->detail;

        $page->type = 'page';
        $page->status = $request->status;
        $page->created_at = date('Y-m-d H:i:s');
        $page->created_by = 1;
        //upload image
        if ($request->has('image')) {
            $path_dir = "images/page/";
            $file =  $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $page->slug . '.' . $extension;
            $file->move($path_dir, $filename);
            //echo $filename;
            $page->image = $filename;
        }
        //end upload

        if ($page->save()) {
            $link = new Link();
            $link->slug = $page->slug;
            $link->table_id = $page->id;
            $link->type = 'page';
            $link->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        } else {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.page.show', compact('page'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Post::find($id);
        return view('backend.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, string $id)
    {
        $page = Post::find($id);
        // $page = new Page;
        $page->title = $request->title;
        $page->slug = Str::slug($page->title = $request->title, '-');
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->detail = $request->detail;
        $page->type = 'page';
        $page->status = $request->status;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = 1;
        //upload image
        if ($request->has('image')) {
            $path_dir = "images/page/";
            if (File::exists(($path_dir . $page->image))) {
                File::delete(($path_dir . $page->image));
            }
            $file =  $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $page->slug . '.' . $extension;
            $file->move($path_dir, $filename);
            //echo $filename;
            $page->image = $filename;
        }
        //end upload
        if ($page->save()) {
            $link = Link::where([['type', '=', 'page'], ['table_id', '=', $id]])->first();
            //  $link->slug = $page->slug;
            $link->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/page/destroy/
    public function destroy(string $id)
    {
        $page = Post::find($id);
        //thong tin hinh xoa
        $path_dir = "image/page/";
        $path_image_delete = $path_dir . $page->image;
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($page->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'page'], ['table_id', '=', $id]])->first();
        $link->delete();
        return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/page/status/1
    public function status($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $page->status = ($page->status == 1) ? 2 : 1;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = 1;
        $page->save();
        return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/page/delete/1
    public function delete($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $page->status = 0;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = 1;
        $page->save();
        return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/page/restore/1
    public function restore($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $page->status = 2;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = 1;
        $page->save();
        return redirect()->route('page.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
