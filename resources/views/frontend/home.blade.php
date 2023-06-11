@extends('layouts.site')
@section('title', 'Trang chủ')
@section('header')
    <link href="{{asset('owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">  
    <link href="{{asset('owlcarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">  
@endsection
@section('footer')
    <script src="{{asset('owlcarousel/owl.carousel.min.js')}}"></script>
@endsection
@section('content')
<x-slideshow />



@foreach ($list_category as $category)
	<x-product-home :rowcat="$category"/>
@endforeach
<div class="container"></div>

@endsection
