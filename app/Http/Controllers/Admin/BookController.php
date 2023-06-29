<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
class BookController extends Controller
{
    private object $model;
    private string $table;
    public function __construct()
    {
        $this->model = Book::query();
        $this->table = (new Book())->getTable();
        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        $data = $this->model->with([
            'category' => function($q){
                    return $q->select([
                        'id',
                        'name'
                    ]);
                }]
            )->paginate();
        return view('admin.book.index',[
           'data' => $data
        ]);
    }



    public function edit(Book $book)
    {
        $category = Category::all();

        return view('admin.book.action',[
            'book' => $book,
            'category' => $category
        ]);
    }

    public function create(){
        $category = Category::all();

        return view('admin.book.action',[
            'category' => $category
        ]);
    }

    public function store(Request $request){
        try{
            $data = Book::query()
                ->where('title',$request->get('title'))
                ->where('author',$request->get('author'))
                ->first();
            if($data){
                return redirect()->back()->with("error","tiêu đề và tác gỉa đã tồn tại");
            }
            $path = "";
            if($request->file('avatar') !== null){
                $path = Storage::disk('public')->putFile('images', $request->file('avatar'));
            }
            Book::query()->create([
               'title'=> $request->get('title'),
               'author'=>$request->get('author'),
               'des'=> $request->get('des'),
               'release_date'=>$request->get('release_date'),
                'number_page'=>$request->get('number_page'),
                'category_id'=>$request->get('category'),
                'avatar' => $path,
                'price' => $request->get('price'),
            ]);
            return redirect()->route('list_book')->with('success',"Thành công");
        }catch (\Exception $e){
            return redirect()->back()->with("error",$e->getMessage());
        }
    }

    public function update(Request $request,$id){
        try{
            $book = Book::query()->where('title',$request->get('title'))
                                ->where('author',$request->get('author'))
                                ->first();
            if($book && $book->id !== (int) $id){
                return redirect()->back()->with('error','tiêu đề và tác giả đã tồn tại');
            }
            if(empty($book)){
                $book = Book::query()->where('id',$id)->first();
            }
            $arr = $request->except('_token','_method','avatar','category');
            if($request->file('avatar')){
                Storage::delete('public/'.$book->avatar);
                $arr['avatar'] = Storage::disk('public')->putFile('images', $request->file('avatar'));
            } else{
                $arr['avatar'] = $book->avatar;
            }
            $arr['category_id'] = $request->get('category');
            Book::query()->where('id', $id )->update($arr);
            return redirect()->route('list_book')->with('success',"Sửa thành công");
        }catch (\Exception $e){
            return redirect()->back()->with("error",$e->getMessage());
        }
    }

    public function destroy(Book $book){
        try{
            Storage::delete('public/'.$book->avatar);
            $book->delete();
            return redirect()->route('list_book')->with('success',"Xóa thành công");
        }catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    //
}
