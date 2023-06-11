<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Product;
use App\Models\Post;
use App\Models\Page;
use App\Models\Topic;
use App\Models\ProductStore;

class SiteController extends Controller
{
    public function index($slug = null)
    {
        if ($slug == null) {
            return $this->home();
        } else {
            $link = Link::where('slug', '=', $slug)->first();
            if ($link != NULL) {
                $type = $link->type;
                switch ($type) {
                    case 'brand': {
                            return $this->product_brand($slug);
                            break;
                        }
                    case 'category': {
                            return $this->product_category($slug);
                            break;
                        }
                    case 'topic': {
                            return $this->post_topic($slug);
                            break;
                        }
                    case 'page': {
                            return $this->post_page($slug); //bảng post có 2 kiểu type là post và page, page sẽ được lưu vào bảng link
                            break;
                        }
                }
            } else {
                $product = Product::where([['status', '=', 1], ['slug', '=', $slug]])->first();
                if ($product != NULL) {
                    return $this->product_detail($product);
                } else {
                    $post = Post::where([['status', '=', 1], ['slug', '=', $slug], ['type', '=', 'post']])->first();
                    if ($post != NULL) {
                        return $this->post_detail($post);
                    } else {
                        return $this->error_404($slug);
                    }
                }
            }
        }
    }
    public function home()
    {
        $list_category = Category::where([['parent_id', '=', 0], ['status', '=', '1']])->get();
        return view('frontend/home', compact('list_category'));
    }
    public function product_category($slug)
    {
        $row_cat = Category::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        $list_category_id = array();
        array_push($list_category_id, $row_cat->id);
        //xet cap con
        $list_category1 = Category::where([['parent_id', '=', $row_cat->id], ['status', '=', 1]])
            ->orderBy('updated_at', 'desc')
            ->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row_cat1) {
                array_push($list_category_id, $row_cat1->id);
                $list_category2 = Category::where([['parent_id', '=', $row_cat1->id], ['status', '=', '1']])->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row_cat2) {
                        array_push($list_category_id, $row_cat2->id);
                        $list_category3 = Category::where([['parent_id', '=', $row_cat2->id], ['status', '=', '1']])->get();
                        if (count($list_category3) > 0) {
                            foreach ($list_category3 as $row_cat3) {
                                array_push($list_category_id, $row_cat3->id);
                            }
                        }
                    }
                }
            }
        }

        $product_list = Product::where('status', 1)
            ->whereIn('category_id', $list_category_id)->paginate(9);
        return view('frontend.product-category', compact('product_list', 'row_cat'));
    }
    public function product_brand($slug)
    {
        $row_cat = brand::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        $list_brand_id = array();
        array_push($list_brand_id, $row_cat->id);
        //xet cap con
        $list_brand1 = brand::where([['parent_id', '=', $row_cat->id], ['status', '=', 1]])
            ->orderBy('updated_at', 'desc')
            ->get();
        if (count($list_brand1) > 0) {
            foreach ($list_brand1 as $row_cat1) {
                array_push($list_brand_id, $row_cat1->id);
                $list_brand2 = brand::where([['parent_id', '=', $row_cat1->id], ['status', '=', '1']])->get();
                if (count($list_brand2) > 0) {
                    foreach ($list_brand2 as $row_cat2) {
                        array_push($list_brand_id, $row_cat2->id);
                        $list_brand3 = brand::where([['parent_id', '=', $row_cat2->id], ['status', '=', '1']])->get();
                        if (count($list_brand3) > 0) {
                            foreach ($list_brand3 as $row_cat3) {
                                array_push($list_brand_id, $row_cat3->id);
                            }
                        }
                    }
                }
            }
        }

        $product_list = Product::where('status', 1)
            ->whereIn('brand_id', $list_brand_id)->paginate(9);
        return view('frontend.product-brand', compact('product_list', 'row_cat'));
    }
    public function post_topic($slug)
    {
        return view('frontend.post-topic');
    }
    public function post_page($slug)
    {
        return view('frontend.post-page');
    }
    public function product_detail($product)
    {
        $list_category_id = array();
        array_push($list_category_id, $product->category_id);
        //xet cap con
        $list_category1 = Category::where([['parent_id', '=', $product->category_id], ['status', '=', '1']])
            ->orderBy('updated_at', 'desc')
            ->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row_cat1) {
                array_push($list_category_id, $row_cat1->id);
                $list_category2 = Category::where([['parent_id', '=', $row_cat1->id], ['status', '=', '1']])->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row_cat2) {
                        array_push($list_category_id, $row_cat2->id);
                        $list_category3 = Category::where([['parent_id', '=', $row_cat2->id], ['status', '=', '1']])->get();
                        if (count($list_category3) > 0) {
                            foreach ($list_category3 as $row_cat3) {
                                array_push($list_category_id, $row_cat3->id);
                            }
                        }
                    }
                }
            }
        }

        $product_list = Product::where([['status', '=', 1], ['id', '=', $product->id]])
            ->whereIn('category_id', $list_category_id)
            ->orderBy('created_at', 'desc')
            ->take(10)->get();
        return view('frontend.product-detail', compact('product', 'product_list'));
    }
    public function post_detail($post)
    {
        return view('frontend.post-detail');
    }
    public function error_404($slug)
    {
        return view('frontend.404');
    }
}
