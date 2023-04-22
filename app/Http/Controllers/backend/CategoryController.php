<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    // GET admin/category, admin/category/index
    public function index()
    {
        $list_category = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.category.index', compact('list_category'));
    }
    // GET admin/category/trash
    public function trash()
    {
        $list_category = Category::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.category.trash', compact('list_category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_category = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_category as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.category.create', compact('html_parent_id', 'html_sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($category->name = $request->name, '-');
        $category->metakey = $request->metakey;
        $category->metadesc = $request->metadesc;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        $category->status = $request->status;
        $category->created_at = date('Y-m-d H:i:s');
        $category->created_by = 1;
        //xử lý upload hình
        if ($request->has('image')) {
            $path_dir = "images/category/";
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $category->slug . '.' . $extension;
            $file->move($path_dir, $filename);
            //  echo $filename;
            $category->image = $filename;
        }

        if ($category->save()) {
            $link = new Link();
            $link->slug = $category->slug;
            $link->table_id = $category->id;
            $link->type = 'category';
            $link->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        } else {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.category.show', compact('category'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        $list_category = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_category as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.category.edit', compact('category', 'html_parent_id', 'html_sort_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::find($id);
        // $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($category->name = $request->name, '-');
        $category->metakey = $request->metakey;
        $category->metadesc = $request->metadesc;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        $category->status = $request->status;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = 1;
        if ($request->has('image')) {
            $path_dir = "images/category/";
            if (File::exists(($path_dir . $category->image))) {
                File::delete(($path_dir . $category->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $category->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $category->image = $filename;
        }
        //end upload file
        if ($category->save()) {
            $link = Link::where([['type', '=', 'category'], ['table_id', '=', $id]])->first();
            //  $link->slug = $category->slug;
            $link->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/category/destroy/
    public function destroy(string $id)
    {
        $category = Category::find($id);
        //thong tin hinh xoa
        $path_dir = "images/category/";
        $path_image_delete = $path_dir . $category->image;
        if ($category == null) {
            return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($category->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'category'], ['table_id', '=', $id]])->first();
        $link->delete();
        return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/category/status/1
    public function status($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $category->status = ($category->status == 1) ? 2 : 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = 1;
        $category->save();
        return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/category/delete/1
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $category->status = 0;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = 1;
        $category->save();
        return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/category/restore/1
    public function restore($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $category->status = 2;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = 1;
        $category->save();
        return redirect()->route('category.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
