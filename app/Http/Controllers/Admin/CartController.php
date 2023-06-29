<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCartEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\HistoryBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PharIo\Version\Exception;

class CartController extends Controller
{
    private object $model;
    private string $table;
    public function __construct()
    {
        $this->model = HistoryBuy::query();
        $this->table = (new HistoryBuy())->getTable();
        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(){
        $listCart = HistoryBuy::query()->paginate();
        return view("admin.cart.index",[
            "data"=> $listCart
        ]);
    }

    public function accept($id){
        try {
            HistoryBuy::query()->where("id", $id)->update([
                "status"=> StatusCartEnum::DANG_GIAO
            ]);
            return redirect()->back()->with("success","duyệt thành công");
        }catch (\Exception $e){
            return redirect()->back()->with("error","lỗi serve");
        }
    }

    public function reject($id){
        DB::beginTransaction();
        try{
            HistoryBuy::query()->where("id", $id)->update([
                "status"=> StatusCartEnum::DA_HUY
            ]);
            $cart = HistoryBuy::query()->where("id", $id)->first();
            $book = $cart->book;
            $book->number_sell -= $cart->number;
            $book->save();
            DB::commit();
            return redirect()->back()->with("success","hủy thành công");
        }catch (Exception $e){
            DB::rollback();
            return redirect()->back()->with("error","lỗi serve");
        }

    }
    public function restore($id){
        DB::beginTransaction();
        try{
            HistoryBuy::query()->where("id", $id)->update([
                "status"=> StatusCartEnum::CHUA_DUYET
            ]);
            $cart = HistoryBuy::query()->where("id", $id)->first();
            $book = $cart->book;
            $book->number_sell += $cart->number;
            $book->save();
            DB::commit();
            return redirect()->back()->with("success","hủy thành công");
        }catch (Exception $e){
            DB::rollback();
            return redirect()->back()->with("error","lỗi serve");
        }
    }
}
