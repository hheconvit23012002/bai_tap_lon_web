<nav class="navbar navbar-default navbar-fixed-top navbar-color-on-scroll" color-on-scroll="100" id="sectionsNav">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('user.index') }}">
                Shop Book
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="button-container">
                    @auth
                        <div class="d-flex">
                            <a href="{{ route('user.showCart') }}" class="btn btn-rose btn-round">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Giỏ hàng
                            </a>
                            <a href="{{ route('logout') }}" class="btn btn-rose btn-round">
                                <i class="fa fa-user"></i> logout
                            </a>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-rose btn-round">
                            <i class="fa fa-user"></i> login
                        </a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
