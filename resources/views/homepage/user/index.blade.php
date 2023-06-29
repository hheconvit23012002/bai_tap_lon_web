@extends('homepage.layout.master')

@section('content')
    <h2 class="section-title">
        Tìm thứ bạn cần
    </h2>
    <a href="{{ route('list_book') }}" class="btn btn-rose btn-round">
        Quản lý sách
    </a>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @foreach ($books as $book)
                    <div class="col-md-4 h-50">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#pablo" >
                                    <img class="img img-raised" style="height: 250px" src="{{ asset("storage/".$book->avatar)  }}">
                                </a>
                                <div class="colored-shadow"
                                     style="background-image: url({{ asset("storage/".$book->avatar)  }}); opacity: 1;"></div>
                            </div>

                            <div class="card-content">
                                <h6 class="category text-info">{{ $book->author }}</h6>
                                <h4 class="card-title">
                                    <a href="{{ route("user.show",$book) }}">{{ $book->title }}</a>
                                </h4>
                                <p class="card-description">
                                    {{ Str::limit(
                                        $book->des,
                                     10) }}
                                    <a
                                        href="{{ route("user.show",$book) }}"> Đọc thêm </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <ul class="pagination pagination-info">
                {{ $books->links() }}
            </ul>
        </div>
    </div>
@endsection
