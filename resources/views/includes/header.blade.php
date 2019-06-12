@section('sidebar')
    <div class="contact-info-wrapper accent-bg-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contact-info">
                        <ul class="nav nav-pills">
                            <li><a class="accent-bg-0 accent-0" href="#"><i class="fa fa-phone"></i> +413 231 3553</a>
                            </li>
                            <li><a class="accent-bg-0 accent-0" href="#"><i class="fa fa-envelope"></i> dquaidoo@clarku.edu</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook accent-0"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-twitter accent-0"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin accent-0"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-dribbble accent-0"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-google-plus accent-0"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="container-fluid">
            <div class="header-wrapper">
                <div class="col-md-4 col-sm-4 col-xs-12 header-right">
                    <div class="vert-center-wrapper">
                        <div class="vert-center">
                            <nav class="header-auth-nav" role="navigation">
                                <ul class="nav nav-pills navbar-nav">
                                  @if(!Auth::user())
                                    <li role="presentation" class="dropdown has-panel">

                                    </li>
                                    <li role="presentation" class="dropdown has-panel">

                                    </li>
                                  @else
                                    <li role="presentation" class="dropdown has-panel">
                                      <p style="padding-top:10px; text-transform:capitalize;">Welcome, {{Auth::user()->first_name}} </p>
                                    </li>
                                  @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="logo hidden-xs">
                    <div class="vert-center-wrapper">
                        <div class="vert-center">
                            <a href="/">
                                <img src="/images/casper.png" alt="Casper" style="zoom:3;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 header-left">
                    <div class="vert-center-wrapper">
                        <div class="vert-center">
                            <form class="header-search">
                                <div class="form-group">
                                    <input class="form-control" placeholder="SEARCH" type="text">
                                    <button class="btn search-btn accent-1"><i class="ti ti-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="header-auth-nav">
        <nav class="navbar navbar-default">
            <div class="container-fluid navbar-mobile-container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand show-xs" href="#"><img src="/images/casper.png" width="50" height="50" style="zoom:1.8; margin-left:-8px; margin-top:0px;"/>
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-mobile" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-center line-selector" style="text-transform: capitalize !important;">
                        <li class="active"><a href="#">Shop</a></li>
                        <li><a href="/order">Order History</a></li>
                        <li><a href="/tracking">Track Orders</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <div class="navbar-aux-items">

                    <!-- Navbar btn-group -->
                    <div class="navbar-btn-group btn-group navbar-right no-margin-r-xs">

                        <!-- Btn Wrapper -->
                        <div class="btn-wrapper dropdown">

                            <a class="btn btn-outline" data-toggle="dropdown" aria-expanded="false"><i class="ti-home"></i></a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu">
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/order">Order History</a></li>
                                @if(Auth::user())
                                  @if(Auth::user()->isAdmin())
                                      <li><a href="/admin/products">Admin</a></li>
                                      <li><a href="/admin/profiles">User Profiles</a></li>
                                  @endif
                                  <li><a href="{{route('logout-user')}}">Logout</a></li>
                                @endif
                            </ul>
                            <!-- /Dropdown Menu -->

                        </div>
                        <!-- /Btn Wrapper -->

                        <!-- Btn Wrapper -->
                        <div class="btn-wrapper dropdown">

                            <a aria-expanded="false" class="btn btn-outline" data-toggle="dropdown">
                              @if(Auth::user())
                                @if($cart)
                                <b class="badge badge-color badge-round">
                                  {{$quantity}}
                                </b>
                                @endif
                              @endif
                              <i class="ti ti-bag"></i>
                            </a>

                            <!-- Dropdown Panel -->
                            <div class="dropdown-menu dropdown-panel dropdown-right" data-keep-open="true">
                                <section>
                                    <!-- Mini Cart -->
                                    <ul class="mini-cart">
                                        <!-- Item -->
                                        @if(Auth::user())
                                          @if($cart)
                                            @foreach ($cart as $cartItem)
                                            <li class="clearfix">
                                                <img src="{{$cartItem->product->imageurl}}" alt="">
                                                <div class="text">
                                                    <a class="title" href="#">{{$cartItem->product->name}}</a>
                                                    <div class="details">{{$cartItem->quantity}} x ${{number_format($cartItem->product->price,2,'.','')}}
                                                        <div class="btn-group">
                                                            <a class="btn accent-0 accent-bg-2" href="/cart"><i class="ti ti-pencil"></i></a>
                                                            <a class="btn btn-default" href="/carts/{{$cartItem->id}}/delete"><i class="ti ti-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            <p style="text-align:right; margin:-10px 0px; color:#222; padding:0px;">Cart Total: ${{number_format($total,2,'.','')}}</p>
                                          @else
                                            <li><p style="text-align:center;">No items in cart</p></li>
                                          @endif
                                        @else
                                            <li><p style="text-align:center;">Login to view cart</p></li>
                                        @endif
                                        <!-- /Item -->
                                    </ul>
                                    <!-- /Mini Cart -->
                                </section>

                                <section class="section-divider">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a class="btn btn-block accent-0 accent-bg-1" style="margin-top:5px; margin-bottom:5px;" href="/cart">view cart</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-block accent-0 accent-bg-2" style="margin-top:5px; margin-bottom:5px;" href="/checkout">checkout</a>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- /Dropdown Panel -->

                        </div>
                        <!-- /Btn Wrapper -->

                    </div>
                    <!-- /Navbar btn-group -->

                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
    </div>
@show
