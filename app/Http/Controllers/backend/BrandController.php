<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use Illuminate\Support\Facades\File;

class brandController extends Controller
{
    // GET admin/brand, admin/brand/index
    public function index()
    {
        $list_brand = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.brand.index', compact('list_brand'));
    }
    // GET admin/brand/trash
    public function trash()
    {
        $list_brand = Brand::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.brand.trash', compact('list_brand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_brand = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_brand as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.brand.create', compact('html_sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->slug = Str::slug($brand->name = $request->name, '-');
        $brand->metakey = $request->metakey;
        $brand->metadesc = $request->metadesc;
        $brand->sort_order = $request->sort_order;
        $brand->status = $request->status;
        $brand->created_at = date('Y-m-d H:i:s');
        $brand->created_by = 1;
        //xử lý upload hình
        if ($request->has('image')) {
            $path_dir = "images/brand/";
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $brand->slug . '.' . $extension;
            $file->move($path_dir, $filename);
            //  echo $filename;
            $brand->image = $filename;
        }

        if ($brand->save()) {
            $link = new Link();
            $link->slug = $brand->slug;
            $link->table_id = $brand->id;
            $link->type = 'brand';
            $link->save();
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        } else {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.brand.show', compact('brand'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        $list_brand = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_brand as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau:' . $item->name . '</option>';
        }
        return view('backend.brand.edit', compact('brand',  'html_sort_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(brandUpdateRequest $request, string $id)
    {
        $brand = Brand::find($id);
        // $brand = new brand;
        $brand->name = $request->name;
        $brand->slug = Str::slug($brand->name = $request->name, '-');
        $brand->metakey = $request->metakey;
        $brand->metadesc = $request->metadesc;
        $brand->sort_order = $request->sort_order;
        $brand->status = $request->status;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = 1;
        if ($request->has('image')) {
            $path_dir = "images/brand/";
            if (File::exists(($path_dir . $brand->image))) {
                File::delete(($path_dir . $brand->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $brand->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $brand->image = $filename;
        }
        //end upload file
        if ($brand->save()) {
            $link = Link::where([['type', '=', 'brand'], ['table_id', '=', $id]])->first();
            //  $link->slug = $brand->slug;
            $link->save();
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/brand/destroy/
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        //thong tin hinh xoa
        $path_dir = "images/brand/";
        $path_image_delete = $path_dir . $brand->image;
        if ($brand == null) {
            return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($brand->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'brand'], ['table_id', '=', $id]])->first();
        $link->delete();
        return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/brand/status/1
    public function status($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $brand->status = ($brand->status == 1) ? 2 : 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = 1;
        $brand->save();
        return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/brand/delete/1
    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $brand->status = 0;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = 1;
        $brand->save();
        return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/brand/restore/1
    public function restore($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $brand->status = 2;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = 1;
        $brand->save();
        return redirect()->route('brand.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
