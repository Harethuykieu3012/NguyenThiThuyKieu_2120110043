@extends('layouts.site')
@section('title', 'Giỏ hàng')
@section('content')

    <div class="container">
        <section id="cart_items">
            <div class="container">
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">Shopping Cart</li>
                    </ol>
                </div>
                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Hình</td>
                                <td class="description">Tên</td>
                                <td class="price">giá</td>
                                <td class="quantity">Số lượng</td>
                                <td class="total">Thành tiền</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $item)
                            @php
                        $product_image= $item['image'];
                        if(count($product_image)>0)
                        $hinh="";
                        {
                            $hinh=$product_image[0]["image"];
                        }   
                    @endphp
                                <tr>
                                    <td class="cart_product">
                                        <img class="img-fluid" style="width:100px;" src="{{asset('images/product/'.$hinh)}}" 
                                        alt="{{$hinh}}">
                                    </td>
                                    <td>{{ $item['name'] }} </td>
                                    <td> {{ number_format($item['price']) }}VNĐ </td>
                                    <td class="qua-col">
                                        <div class="quantity" style="justify-content: center;">
                                            <form action="{{ route('cart.update', ['id' => $item['id']]) }}" method="get"
                                                accept-charset="utf-8">
                                                
                                                <div class="pro-qty">
                                                    <input type="text" name="quantity" spellcheck="false"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                        data-id="{{ $item['id'] }}" value="{{ $item['quantity'] }}">
                                                </div>
                                                <button type="submit" class="btn btn-default" style="height:46px;"><i
                                                        class="fa fa-arrow-circle-o-right"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    <td> {{ number_format((int) $item['price'] * (int) $item['quantity'] )}}VNĐ</td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete"
                                            href="{{ route('cart.remove', ['id' => $item['id']]) }}"><i
                                                class="fa fa-times"></i></a>
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="jumbotron">
                        <div class="container">
                            <p>
                                <a href="{{ route('cart.clear') }}" class="btn btn-xs btn-danger"> Xóa tất cả</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/#cart_items-->
    </div>

@endsection
@section('footer')
    <script>
        /*-------------------
                                Quantity change
                                --------------------- */
        (function($) {
            var proQty = $('.pro-qty');
            proQty.prepend('<span class="dec qtybtn">-</span>');
            proQty.append('<span class="inc qtybtn">+</span>');
            proQty.on('click', '.qtybtn', function() {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                    }
                }
                $button.parent().find('input').val(newVal);
            });

        })(jQuery);
    </script>
@endsection
