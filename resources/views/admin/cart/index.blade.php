@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Customer</td>
                            <td>Address</td>
                            <td>Tel</td>
                            <td>Book</td>
                            <td>Number</td>
                            <td>Price</td>
                            <td>Sum Price</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>{{ $each->id }}</td>
                                <td>
                                    {{$each->user->name}}
                                </td>
                                <td>
                                    {{$each->address}}
                                </td>
                                <td>
                                    {{$each->tel}}
                                </td>
                                <td>
                                    {{ $each->book->title }}
                                </td>
                                <td>
                                    {{ $each->number }}
                                </td>
                                <td>
                                    {{ $each->vali_price }}
                                </td>
                                <td>
                                    {{ $each->sum_price }}
                                </td>
                                <td>
                                    {{ \App\Enums\StatusCartEnum::getKey($each->status)  }}
                                </td>
                                <td>
                                    @if(
                                        $each->status === \App\Enums\StatusCartEnum::CHUA_DUYET
                                    )
                                        <form method="POST" id="accept-{{ $each->id }}"
                                              action="{{ route("admin.cart.accept",$each) }}">
                                            @csrf
                                            <button type="submit" onclick="submitAccept({{ $each->id }})"
                                                    class="btn btn-info">Duyệt
                                            </button>
                                        </form>
                                    @endif
                                    @if($each->status === \App\Enums\StatusCartEnum::CHUA_DUYET
                                        || $each->status === \App\Enums\StatusCartEnum::DANG_GIAO)
                                        <form method="POST" id="reject-{{ $each->id }}"
                                              action="{{ route("admin.cart.reject",$each) }}">
                                            @csrf
                                            <button type="submit" onclick="submitReject({{ $each->id }})"
                                                    class="btn btn-danger">Huỷ
                                            </button>
                                        </form>
                                    @endif
                                    @if( $each->status === \App\Enums\StatusCartEnum::DA_HUY)
                                        <form method="POST" id="restore-{{ $each->id }}"
                                              action="{{ route("admin.cart.restore",$each) }}">
                                            @csrf
                                            <button type="submit" onclick="submitRestore({{ $each->id }})"
                                                    class="btn btn-info">Khôi phục
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav class="mt-4">
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function submitAccept(id) {
            event.preventDefault();
            if (confirm("Bạn có chắc chắn muốn duyệt đơn hàng này")) {
                $("#accept-" + id).submit();
            }
        }

        function submitReject(id) {
            event.preventDefault();
            if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng này")) {
                $("#reject-" + id).submit();
            }
        }

        function submitRestore(id) {
            event.preventDefault();
            if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng này")) {
                $("#restore-" + id).submit();
            }
        }

    </script>
@endpush
