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
                    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                        <a href="{{ route('admin.book.create') }}" class="btn btn-success mb-2" style="color: white">Create</a>
                    @endif
                    <table class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Avatar</td>
                                <td>Title</td>
                                <td>Author</td>
                                <td>Category</td>
                                <td>Release Date</td>
                                <td>Number Page</td>
                                <td>Number Sell</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>
                                    {{$each->id}}
                                </td>
                                <td>
                                    <img src="{{ asset("storage/".$each->avatar) }}" height="100">
                                </td>
                                <td>
                                    {{$each->title}}
                                </td>
                                <td>
                                    {{ $each->author }}
                                </td>
                                <td>
                                    {{ $each->category->name }}
                                </td>
                                <td>
                                    {{ $each->release_date }}
                                </td>
                                <td>
                                    {{ $each->number_page }}
                                </td>
                                <td>
                                    {{ $each->number_sell }}
                                </td>
                                <td>
                                    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                        <div class="d-flex">
                                            <a class="btn btn-primary mr-2" href="{{ route('admin.book.edit',$each) }}">View</a>
                                            <form action="{{ route("admin.book.destroy",$each) }}" method="POST" id="form-delete-{{ $each->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="submitForm({{ $each->id }})" class="btn btn-danger">delete</button>
                                            </form>
                                        </div>
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
        function submitForm(id){
            event.preventDefault();
            if(confirm("Bạn có chắc chắn muốn xóa sách này")){
                $("#form-delete-"+id).submit();
            }
        }

    </script>
@endpush
