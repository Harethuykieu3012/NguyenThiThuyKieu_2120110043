<div>
    <div class="container">
        <div class="col-sm-12 padding-right">
            <div class="features_items">
                <!--features_items-->
                {{-- <a href="{{route('slug.home',['slug'=>$row_cat->slug])}}"> --}}
                <h2 class="title text-center">{{ $row_cat->name }}</h2>
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
                                            <h2><a href="{{ route('slug.home', ['slug' => $row->slug]) }}">{{ $ten }}</a></h2>
                                            <p>{{ number_format($row->price_buy) }}</p>
                                            <a href="{{ route('cart.add', ['id' => $row->id]) }}"
                                                class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('images/product1.jpg') }}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <a href="#" class="btn btn-default add-to-cart"><i
                                        class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
            <!--features_items-->

        </div>
    </div>

</div>
