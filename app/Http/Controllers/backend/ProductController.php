<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSale;
use App\Models\ProductStore;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // GET admin/product, admin/product/index
    public function index()
    {
        $list_product = Product::join('nttk_category', 'nttk_category.id', '=', 'nttk_product.category_id')
            ->join('nttk_brand', 'nttk_brand.id', '=', 'nttk_product.brand_id')
            ->select('nttk_product.*', 'nttk_brand.name as brand_name', 'nttk_category.name as category_name')
            ->where('nttk_product.status', '!=', 0)
            ->orderBy('nttk_product.created_at', 'desc')
            ->get();
        return view('backend.product.index', compact('list_product'));
    }
    // GET admin/product/trash
    public function trash()
    {
        $list_product = Product::join('nttk_category', 'nttk_category.id', '=', 'nttk_product.category_id')
            ->join('nttk_brand', 'nttk_brand.id', '=', 'nttk_product.brand_id')
            ->select('nttk_product.*', 'nttk_brand.name as brand_name', 'nttk_category.name as category_name')
            ->where('nttk_product.status', '=', 0)
            ->orderBy('nttk_product.created_at', 'desc')->get();
        return view('backend.product.trash', compact('list_product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_category = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $list_brand = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_category_id = '';
        $html_brand_id = '';
        foreach ($list_category as $item) {
            $html_category_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        $html_brand_id = '';
        foreach ($list_brand as $item) {
            $html_brand_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        return view('backend.product.create', compact('html_category_id', 'html_brand_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $product = new Product; //tạo mới Sản phẩm
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->slug = Str::slug($product->name = $request->name, '-');
        $product->price_buy = $request->price_buy;
        $product->detail = $request->detail;
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->created_at = date('Y-m-d H:i:s');
        $product->created_by = 1;
        $product->status = $request->status;
        if ($product->save()) {
            //upload image
            if ($request->has('image')) {
                $path_dir = "images/product/";
                $array_file =  $request->file('image');
                $i = 1;
                foreach ($array_file as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $product->slug . "-" . $i . '.' . $extension;
                    $file->move($path_dir, $filename);
                    //echo $filename;
                    $product_image = new ProductImage();
                    $product_image->product_id = $product->id;
                    $product_image->image = $filename;
                    $product_image->save();
                    $i++;
                }
            }
            //khuyến mãi
            if (strlen($request->price_sale) && strlen($request->date_begin) && strlen($request->date_end)) {
                $product_sale = new ProductSale();
                $product_sale->product_id = $product->id;
                $product_sale->price_sale = $request->price_sale;
                $product_sale->date_begin = $request->date_begin;
                $product_sale->date_end = $request->date_end;
                $product_sale->save();
            }
            //Nhập kho
            if (strlen($request->price) && strlen($request->qty)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product->id;
                $product_store->price = $request->price;
                $product_store->qty = $request->qty;
                $product_store->created_at = date('Y-m-d H:i:s');
                $product_store->created_by = 1;
                $product_store->save();
            }
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg'
            => 'Thêm thành công']);
        } else {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg'
            => 'Thêm không thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);
        } else {
            return view('backend.product.show', compact('product'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $list_product = Product::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_product as $item) {
            if ($product->parent_id == $item->id) {
                $html_parent_id .= '<option selected value="' . $item->id . '">' . $item->name . '</option>';
            } else {
                $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
            if ($product->sort_order == $item->id) {
                $html_sort_order .= '<option selected value="' . $item->sort_order - 1 . '">Sau: ' . $item->name . '</option>';
            } else {
                $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
            }
        }
        return view('backend.product.edit', compact('product', 'html_parent_id', 'html_sort_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::find($id);
        // $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($product->name = $request->name, '-');
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->parent_id = $request->parent_id;
        $product->sort_order = $request->sort_order;
        $product->status = $request->status;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = 1;
        if ($request->has('image')) {
            $path_dir = "images/product/";
            if (File::exists(($path_dir . $product->image))) {
                File::delete(($path_dir . $product->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $product->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $product->image = $filename;
        }
        //end upload file
        if ($product->save()) {
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }


    //get:adim/product/destroy/
    public function destroy(string $id)
    {
        $product = Product::find($id);
        //thong tin hinh xoa
        $path_dir = "images/product/";
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($product->delete()) {
            //xoa hinh
            foreach ($product->productimg as $pro_img) {
                if (File::exists(($path_dir . $pro_img->image))) {
                    File::delete(($path_dir . $pro_img->image));
                }
            }
            foreach ($product->productimg as $pro_img) {
                if ($product_image = ProductImage::where('product_id', '=', $id)->first()) {
                    $product_image->delete();
                }
            }
        }
        return redirect()->route('product.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    //get:adim/product/status/1
    public function status($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $product->status = ($product->status == 1) ? 2 : 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = 1;
        $product->save();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
    //get:adim/product/delete/1
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $product->status = 0;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = 1;
        $product->save();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg'
        => 'Xóa vào thùng rác']);
    }
    //get:adim/product/restore/1
    public function restore($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg'
            => 'Mẫu tin không tồn tại!']);

            //chuyen huong bao loi
        }
        $product->status = 2;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = 1;
        $product->save();
        return redirect()->route('product.trash')->with('message', ['type' => 'success', 'msg'
        => 'Thay đổi trang thái thành công']);
    }
}
