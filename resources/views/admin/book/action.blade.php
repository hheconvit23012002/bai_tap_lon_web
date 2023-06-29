@extends('admin.layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div id="div-error" class="alert alert-danger d-none"></div>
                <div class="card-body">
                    <form class="form-horizontal" id="form-action" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @isset($book)
                            @method('PUT')
                        @endisset
                        <div class="form-row">
                            <div class="form-group col-6">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        @isset($book)
                                            <input type="hidden" name="id" value="{{ $book->id }}"
                                                   class="form-control"/>
                                        @endisset
                                        <label>Tiêu đề (*)</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                               @isset($book)
                                                   readonly
                                               value="{{ $book->title }}"
                                            @endisset
                                        >
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Tác giả (*)</label>
                                        <input type="text" id="author" name="author" class="form-control"
                                               @isset($book)
                                                   readonly
                                               value="{{ $book->author }}"
                                            @endisset
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả về sách</label>
                                    <textarea name="des" id="des" class="form-control"
                                              @isset($book)
                                                  readonly
                                      @endisset
                                    >@isset($book){{ $book->des }}@endisset</textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label>Ngày phát hành (*)</label>
                                        <input type="date" name="release_date" id="release_date" class="form-control"
                                               @isset($book)
                                                   value="{{ $book->release_date }}"
                                            @endisset
                                        >
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Số trang (*)</label>
                                        <input type="number" name="number_page" id="number_page" class="form-control"
                                               @isset($book)
                                                   value="{{ $book->number_page }}"
                                            @endisset
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Thể loại (*)</label>
                                    <select class="form-control select-category" name="category"
                                            id="category"
                                            aria-label="Default select example"
                                            @isset($book)
                                                disabled
                                        @endisset
                                    >
                                        @foreach ($category as $each)
                                            <option value="{{ $each->id }}"
                                                    @isset($book)
                                                        @if($each->id === $book->$category)
                                                            selected
                                                @endif
                                                @endisset
                                            >{{ $each->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Giá (*)</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                       @isset($book)
                                           disabled
                                           value="{{ $book->price }}"
                                        @endisset
                                    >
                                </div>
                            </div>
                            <div class="form-group col-6 ">
                                <input
                                    @isset($book)
                                        disabled
                                    @endisset
                                    name="avatar"
                                    accept="image/*"
                                    class="form-control "
                                    type='file' id="imgInp"/>
                                <img id="blah"
                                     @if(isset($book))
                                         src="{{ asset("storage/".$book->avatar)  }}"
                                     @else
                                         src="#"
                                     @endif
                                      alt="your image"
                                     class="w-100 mt-2"/>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success float-right"
                                onclick="submitForm()"
                                id="btnSubmit"
                        >
                            @isset($book)
                                Edit
                            @endisset
                            @empty($book)
                                Add
                            @endempty
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".select-category").select2({})
        })
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        function validate(){
            if($("#title").val() === "" ||
                    $("#author").val() === "" ||
                    $("#release_date").val() === "" ||
                    $("#number_page").val() === "" ||
                    $("#category").val() === "" ||
                    $("#price").val() === ""
                )
            {
                return false
            }
            return true;
        }

         function submitForm() {
            event.preventDefault()
            if ($('#btnSubmit').text().trim() === "Edit") {

                $('#btnSubmit').text("Save")
                $("#title").attr('readonly', false)
                $("#author").attr('readonly', false)
                $("#des").attr('readonly', false)
                $("#release_date").attr('readonly', false)
                $("#number_page").attr('readonly', false)
                $("#category").attr('disabled', false)
                $("#price").attr('disabled', false)
                $("#imgInp").attr('disabled', false)
            }
            else if ($('#btnSubmit').text().trim() === "Add") {
                if (confirm("Bạn có chắc chắn muốn thêm sách này?")) {
                    if(validate() ===false) {
                        alert("Không để trống những dòng cần thiết")
                    }else{
                        $("#form-action").attr("action", "{{ route('admin.book.store') }}");
                        $("#form-action").submit();
                    }
                }
            } else if ($('#btnSubmit').text().trim() === "Save") {
                if (confirm("Bạn có chắc chắn muốn thay đổi sách này")) {
                    if(validate() ===false) {
                        alert("Không để trống những dòng cần thiết")
                    }else{
                        $("#form-action").attr("action", "{{ route('admin.book.update',$book ?? -1 ) }}");
                        $("#form-action").submit();
                    }
                }
            }

        }
    </script>
@endpush
