@extends('homepage.layout.master')

@section('content')
    <h2 class="section-title">
        Danh sách đơn hàng
    </h2>
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
        <div class="col-md-12">
            @foreach ($data as $each)
                <div class="row" style="border: 1px solid black">
                    @if(isset($each->book))
                        <div class="col-md-4">
                            <img src="{{ asset("storage/".$each->book->avatar) }}" class="img-thumbnail">
                        </div>
                        <div class="col-md-8">
                            <h5 class="main-price">Thông tin sách: {{ $each->book->title }} - {{ $each->book->author }}</h5>
                            <h5 class="main-price">Số lượng: {{ $each->number }}</h5>
                            <h5 class="main-price">Giá: {{ $each->vali_price }}</h5>
                            <h5 class="main-price">Địa chỉ: {{ $each->address }}</h5>
                            <h5 class="main-price">Số điện thoại: {{ $each->tel }}</h5>
                            <h5 class="main-price">Tình trạng: {{ \App\Enums\StatusCartEnum::getKey($each->status) }}</h5>
                            <div>
                                @if($each->status === \App\Enums\StatusCartEnum::DANG_GIAO)
                                    <form method="POST" id="action-receive-{{ $each->id }}" action="{{ route("user.receive",$each) }}">
                                        @csrf
                                        <button class="btn btn-success" id="btn-receive" onclick="submitReceive({{ $each->id }})">Nhận hàng</button>
                                    </form>
                                @endif
                            </div>
                            <div style="display: flex">
                                @if($each->status === \App\Enums\StatusCartEnum::CHUA_DUYET)
                                    <a href="{{ route("user.editCart",$each) }}" class="btn btn-info">Sửa</a>
                                @endif
                                @if($each->status !== \App\Enums\StatusCartEnum::DA_GIAO)
                                    <form action="{{ route("user.destroyCart",$each) }}" method="POST" id="form-delete-{{ $each->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="submitForm({{ $each->id }})" class="btn btn-danger">Xóa</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <ul class="pagination pagination-info">
            {{ $data->links() }}
        </ul>
    </div>
@endsection
@push('js')
    <script>
        function submitForm(id){
            event.preventDefault();
            if(confirm("Bạn có chắc chắn muốn xóa đơn hàng này")){
                $("#form-delete-"+id).submit();
            }
        }
        function submitReceive(id) {
            event.preventDefault()
            if (confirm("Bạn có chắc chắn muốn nhận đơn hàng này")) {
                $("#action-receive-" + id).submit();
            }
        }

    </script>
@endpush
