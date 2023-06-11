@extends('layouts.site')
@section('title', $product->name)
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
            <div class="col-md-12">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-5">
                        @php
                            $product_image = $product->productimg;
                            $hinh = '';
                            if (count($product_image) > 0) {
                                $hinh = $product_image[0]['image'];
                            }
                        @endphp

                        <div class="view-product">
                            @for ($i = 0; $i <= count($product_image) - 1; $i++)
                                @php
                                    $hinh = $product_image[$i]['image'];
                                @endphp
                                <div><img style="width:200px;float: left; margin:10px 5px;"
                                        src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" />
                                </div>
                            @endfor
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information">
                            <!--/product-information-->
                            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                            <h2>{{ $product->name }}</h2>
                            <span>
                                <span>{{ number_format($product->price_buy) }} VNĐ</span>
                                <br />
                                <label>Số lượng</label>:</label>
                                <input type="text" value="1" />
                                <button type="button" class="btn btn-fefault cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                            </span>
                            <p><b>Mô tả</b>:</b> {{ $product->metadesc }}</p>
                            <div class="detail">
                                <b>Chi tiết sản phẩm</b><br />
                                <p style="font-size:24;">{{ $product->detail }}</p>
                            </div>
                        </div>
                        <!--/product-information-->

                    </div>
                </div>
                <!--/product-details-->
            </div>

        </div>
        <h2 class="title text-center">Sản phẩm cùng loại</h2>
        {{-- </a> --}}
        <div class="owl-carousel owl-theme">
            @foreach ($product_list as $row)
                @php
                    $product_image = $row->productimg;
                    if (count($product_image) > 0) {
                        $hinh = '';
                    }
                    $hinh = $product_image[0]['image'];
                    $ten = Str::substr($row->name, 0, 20) . '...';
                @endphp
                <div class="item">
                    <div class="product-image-wrapper">
                        <div class="single-products" style="width:160px;margin:auto;padding:auto">
                            <div class="productinfo text-center" style="height:330px;">
                                <img href="{{ route('slug.home', ['slug' => $row->slug]) }}" class="img-fluid"
                                    src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}">
                                <div style="height:40px;">
                                    <h2><a href="{{ route('slug.home', ['slug' => $row->slug]) }}">{{ $ten }}</a>
                                    </h2>
                                    <p>{{ number_format($row->price_buy) }}</p>
                                    <a href="{{ route('cart.add', ['id' => $row->id]) }}"
                                        class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ
                                        hàng</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
