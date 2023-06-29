@extends('homepage.layout.master')
@push('css')

    <style>
        .rating {
            border: none;
            float: left;
        }

        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 5px;
            font-size: 1.25em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        .form_rating {
            display: flex;
            flex-direction: column;
            margin: 20px;
            width: 80%;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label {
            color: #FFD700;
        }

        /* hover previous stars in list */

        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label {
            color: #FFED85;
        }
        .modal-content{
            padding:50px;
        }
        .modal-backdrop{
            display:none !important;
        }
    </style>

@endpush
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="tab-content">
                    <div class="card card-pricing">
                        <img class="card-content" src="{{ asset("storage/".$book->avatar) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h2 class="title"> {{ $book->title }}</h2>
                <h3 class="main-price">{{ $book->price_now }}</h3>
                <h3 class="main-price">Tác giả: {{ $book->author }}</h3>
                <h3 class="main-price">Thể loại: {{ $book->category->name }}</h3>
                <h3 class="main-price">Ngày ra mắt: {{ $book->release_date }}</h3>
                <h3 class="main-price">Số trang: {{ $book->numper_page }}</h3>
                <h3 class="main-price">Đã bán: {{ $book->number_sell }}</h3>

                <div id="acordeon">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-border panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                    <h4 class="panel-title">
                                        Description
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false"
                                 style="height: 0px;">
                                <div class="panel-body">
                                    <p>
                                        {{ $book->des }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--  end acordeon -->
                <div class="row text-right">
                    @auth
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-rose btn-round">
                            Đặt mua<i class="material-icons">shopping_cart</i>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
        <div id="comments">
            <div class="title">
                <h3>Comments</h3>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="media-area">
                        <h3 class="title text-center">{{ $numberComment }} Comments</h3>
                        @foreach($comments as $comment)
                            <div class="media">
                                <a class="pull-left" href="#pablo">
                                    <div class="avatar">
                                        <img class="media-object"
                                             src="{{ asset("storage/".$comment->user->avatar)  }}"
                                             alt="...">
                                    </div>
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $comment->user->name }}
                                        <small>{{ $comment->created_at }}</small></h4>
                                    <h6 class="text-muted"></h6>
                                    <p>
                                        {{ $comment->comment }}
                                    </p>
                                    <h6 class="text-muted">Đánh giá : {{ $comment->star }} sao</h6>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination-area text-center">
                            {{ $comments->links() }}
                        </div>
                    </div>

                    @auth
                        <h3 class="text-center">Post your comment <br></h3>
                        <div class="media media-post">
                            <a class="pull-left author" href="#pablo">
                                <div class="avatar">
                                    <img class="media-object" alt="64x64"
                                         src="{{ asset("storage/".optional(auth()->user())->avatar )  }}">
                                </div>
                            </a>

                            <div class="media-body">
                                <div class="form-group is-empty">
                                    <form action="{{ route("user.postComment") }}" id="form-comment" class="form_rating" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value={{ $book->id }}>
                                        <textarea name="comment" id="comment" required class="form-control"></textarea>
                                        <span class="material-input"></span>
                                        <fieldset class="rating">
                                            <input type="radio" id="star5" name="rating" value="5"/><label class="full"
                                                                                                           for="star5"
                                                                                                           title="Awesome - 5 stars"></label>
                                            <input type="radio" id="star4half" name="rating" value="4.5"/><label
                                                class="half"
                                                for="star4half"
                                                title="Pretty good - 4.5 stars"></label>
                                            <input type="radio" id="star4" name="rating" value="4"/><label class="full"
                                                                                                           for="star4"
                                                                                                           title="Pretty good - 4 stars"></label>
                                            <input type="radio" id="star3half" name="rating" value="3.5"/><label
                                                class="half"
                                                for="star3half"
                                                title="Meh - 3.5 stars"></label>
                                            <input type="radio" id="star3" name="rating" value="3"/><label class="full"
                                                                                                           for="star3"
                                                                                                           title="Meh - 3 stars"></label>
                                            <input type="radio" id="star2half" name="rating" value="2.5"/><label
                                                class="half"
                                                for="star2half"
                                                title="Kinda bad - 2.5 stars"></label>
                                            <input type="radio" id="star2" name="rating" value="2"/><label class="full"
                                                                                                           for="star2"
                                                                                                           title="Kinda bad - 2 stars"></label>
                                            <input type="radio" id="star1half" name="rating" value="1.5"/><label
                                                class="half"
                                                for="star1half"
                                                title="Meh - 1.5 stars"></label>
                                            <input type="radio" id="star1" name="rating" value="1"/><label class="full"
                                                                                                           for="star1"
                                                                                                           title="Sucks big time - 1 star"></label>
                                            <input type="radio" id="starhalf" name="rating" value="0.5"/><label
                                                class="half"
                                                for="starhalf"
                                                title="Sucks big time - 0.5 stars"></label>
                                        </fieldset>
                                        <div class="media-footer">
                                            <button class="btn btn-primary btn-wd pull-right"
                                                type="submit"
                                                    onclick="submitComment()"
                                            >Post Comment</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div> <!-- end media-post -->
                    @endauth
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-rose btn-round">
                        <i class="fa fa-user"></i> Đăng nhập để bình luận
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Đặt mua hàng</h4>
                </div>
                <div class="modal-body">
                    <form id="cart"  class="form-horizontal" action="{{ route("user.processBuy") }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="form-group">
                            <label>Nhập số lượng (*)</label>
                            <input type="number" id="number" required name="number" id="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nhập địa chỉ (*)</label>
                            <input type="text" id="address" required name="address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Phone (*)</label>
                            <input type="phone" id="tel" required name="tel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input readonly type="text" name="price" value="{{ $book->price_now }}" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default mr-2" data-dismiss="modal">Đóng</button>
                            <button type="submit"
                                    onclick="addCart()"
                                    class="btn btn-success">Đặt mua</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
@push("js")
    <script>
        function validateTel(tel){
            const regexPhoneNumber = /(84|0[3|5|7|8|9])+([0-9]{8})\b/g;
            return tel.match(regexPhoneNumber) ? true : false;
        }

        function submitComment(){
            event.preventDefault();
            if($("#comment").val() === ""){
                alert("Nhập thông tin bình luận")
            }else{
                $("#form-comment").submit();
            }
        }

        function addCart(){
            event.preventDefault();
            if($("#number").val() === "" || $("#address").val() === "" || $("#tel").val() === ""){
                alert("Vui lòng nhập đầy đủ các trường cần thiết")
            }else if(validateTel($("#tel").val()) === false){
                alert("Số điện thoại cần đúng định dạng")
            }else{
                $("#cart").submit();
            }
        }
    </script>
@endpush
