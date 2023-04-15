<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;


class CategoryController extends Controller
{
    // GET admin/cayegory, admin/category/index
    public function index()
    {
        $list_category = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.category.index', compact('list_category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_category = Category::where('status', '!=', 0)->get();
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
        if ($category->save()) {
            $link = new Link();
            $link->slug = $category->slug;
            $link->table_id = $category->id;
            $link->type = 'category';
            $link->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
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
            //return view('backend.category.show',compat('category'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $list_category = Category::where('status', '!=', 0)->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_category as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.category.edit', compact('category','html_parent_id', 'html_sort_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = category::find($id);
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($category->name = $request->name, '-');
        $category->metakey = $request->metakey;
        $category->metadesc = $request->metadesc;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        $category->status = $request->status;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = 1;
        if ($category->save()) {
            $link = Link::where([['type','=','category'],['table_id','=',$id]])->first();
            $link->slug =$category->slug;
            $link->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        }else{
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);

        }
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    //get:adim/category/status/1
    public function status($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        } else {
            $category->status = ($category->status == 1) ? 2 : 1;
            $category->updated_at = date('Y-m-d H:i:s');
            $category->updated_by = 1;
            $category->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
            => 'Thay đổi trang thái thành công']);
        }
    }
    //get:adim/category/delete/1
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        } else {
            $category->status = 0;
            $category->updated_at = date('Y-m-d H:i:s');
            $category->updated_by = 1;
            $category->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg'
            => 'Xóa vào thùng rác']);
        }
    }
}
