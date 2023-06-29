<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index()
    {
        $books = Book::query()->paginate(3);
        return view('homepage.user.index', [
            'books' => $books
        ]);
    }

    public function show(Book $book)
    {
        $numberComment = $book->comment()->count();
        $query = Comment::query()->where('book_id', $book->id);
            if(auth()->check()){
                $query->orderBy(DB::raw('(user_id=' . auth()->user()->id . ')'), 'desc');
            }
        $arrComments = $query->orderBy('id')
                        ->paginate(3);
        return view('homepage.user.show', [
            'book' => $book,
            'numberComment' => $numberComment,
            'comments' => $arrComments,
        ]);
    }

    public function postComment(Request $request)
    {
        try {
            Comment::create([
                'user_id' => auth()->user()->id,
                'book_id' => $request->get('book_id'),
                'comment' => $request->get('comment') ?? "",
                'star' => $request->get('rating') ?? 0,
            ]);
            return redirect()->back()->with("success","Đã đăng bình luận");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Lỗi server");
        }
    }
}
