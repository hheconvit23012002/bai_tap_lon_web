@extends('homepage.layout.master')

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
    <div class="form-header">
        <a href="{{ route("user.showCart") }}" class="btn btn-default">Quay lại</a>
    </div>
    <h2 class="section-title">
        Chỉnh sửa đơn hàng
    </h2>

    <form id="form-edit-cart" class="form-horizontal" action="{{ route("user.updateCart",$cart) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
            <h3>Sách : {{ $cart->book->title }} - {{ $cart->book->author }}</h3>
        </div>
        <div class="form-group">
            <label>Nhập số lượng (*)</label>
            <input type="number" name="number" id="number" value="{{ $cart->number ?? 0 }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Nhập địa chỉ (*)</label>
            <input type="text" name="address" id="address" value="{{ optional($cart)->address }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Phone (*) </label>
            <input type="phone" name="tel" id="tel" value="{{ optional($cart)->tel }}" class="form-control">
        </div>
        <div class="form-group">
            <h5>Giá : {{ $cart->vali_price }}</h5>
        </div>
        <div class="form-group">
            <h4>Tổng tiền : {{ $cart->sum_price  }}</h4>
        </div>
        <div class="modal-footer">
                <button type="submit" onclick="submitForm()" class="btn btn-success">Chỉnh sửa</button>
        </div>
    </form>

@endsection
@push('js')
    <script>
        function submitForm(){
            event.preventDefault();

            if(confirm("Bạn có chắc chắn muốn chỉnh sửa đơn hàng này")){
                if($("#number").val() === "" || $("#address").val() === "" || $("#tel").val() === ""){
                    alert("Vui lòng nhập đầy đủ các trường cần thiết")
                }else if(validateTel($("#tel").val()) === false){
                    alert("Số điện thoại cần đúng định dạng")
                }else{
                    $("#form-edit-cart").submit();
                }
            }
        }

        function validateTel(tel){
            const regexPhoneNumber = /(84|0[3|5|7|8|9])+([0-9]{8})\b/g;
            return tel.match(regexPhoneNumber) ? true : false;
        }


    </script>
@endpush
