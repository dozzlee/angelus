

@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('includes.homeslider')
    <div id="shopper" class="">
      <div class="row">
        <div class="col-sm-12 padding-right">
          <div class="features_items">
            <h2 class="title text-center"> Product Items </h2>
          </div>
          @foreach ($products as $product)
              <div class="col-sm-5 col-md-3">
                <div class="thumbnail product">
                  <img src="{{$product->imageurl}}" class="img-responsive">
                  <div class="caption" style="text-align:center;">
                    <p style="font-weight: 400; color: #131416; margin: 0 0 10px 0;">{{$product->name}}</p>
                    <p class="accent-2">${{number_format($product->price,2,'.','')}}</p>
                    <p><a href="/product/{{$product->id}}" class="btn btn-product accent-bg-0 accent-0" role="button"><span class="fa fa-shopping-cart"></span> View</a> </p>
                  </div>
                </div>
              </div>
          @endforeach
        </div>
      </div>
    </div>
    <script>
    /*price range*/
     $('#price-slider').slider();
    </script>
@endsection
