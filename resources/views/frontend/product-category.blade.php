@extends('layouts.site')
@section('title', $row_cat->name)
@section('header')
    <link href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
@endsection
@section('footer')
    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
@endsection
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <x-category-list />
                <x-brand-list />
                


            </div>
            <div class="col-md-9">
                <div class="features_items">
                    <div class="headline">
                        <h2 class="title text-center">{{ $row_cat->name }}</h2>

                    </div>
                    <div style="margin:10px 20px">
                    </div>
                    <div class="row">
                        @if (count($product_list) > 0)
                            @foreach ($product_list as $product)
                                @php
                                    $product_image = $product->productimg;
                                    if (count($product_image) > 0) {
                                        $hinh = '';
                                    }
                                    $hinh = $product_image[0]['image'];
                                    $ten = Str::substr($product->name, 0, 20) . '...';
                                @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products" style="width:160px;margin:auto;padding:auto">
                                            <div class="productinfo text-center" style="height:330px;">
                                                <img href="{{ route('slug.home', ['slug' => $product->slug]) }}"
                                                    class="img-fluid" src="{{ asset('images/product/' . $hinh) }}"
                                                    alt="{{ $hinh }}">
                                                <div style="height:40px;">
                                                    <h2><a
                                                            href="{{ route('slug.home', ['slug' => $product->slug]) }}">{{ $ten }}</a>
                                                    </h2>
                                                    <p>{{ number_format($product->price_buy) }}</p>
                                                    <a href="{{ route('cart.add', ['id' => $product->id]) }}"
                                                        class="btn btn-default add-to-cart"><i
                                                            class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h4 class="text-center">Không có sản phẩm nào thuộc danh mục này!!!</h4>
                        @endif
                    </div>
                    <!--end_một_mẫu tin -->
                    <div>
                        <!--phân trang -->
                        {{ $product_list->links() }}
                    </div>
                </div>
                <!--product_category_items-->

            </div>
        </div>
    </div>

@endsection
