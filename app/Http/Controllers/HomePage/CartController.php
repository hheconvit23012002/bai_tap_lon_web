<?php

namespace App\Http\Controllers\HomePage;

use App\Enums\StatusCartEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\HistoryBuy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function processBuy(Request $request){
        $arr = $request->except("_token");
        $arr['user_id']= auth()->user()->id;
        DB::beginTransaction();
        try{
            $book = Book::find($request->get("book_id"));
            $book->number_sell += $request->get("number");
            $book->save();
            $arr["status"] = StatusCartEnum::CHUA_DUYET;
            $arr["price"] = $book->price;
            HistoryBuy::create($arr);
            DB::commit();
            return redirect()->route("user.showCart")->with("success","Đặt hàng thành công");
        }catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with("error","Có lỗi xảy ra khi mua hàng");
        }
    }

    public function showCart(){
        $data = HistoryBuy::query()->where("user_id",auth()->user()->id)->where("status", ">" , StatusCartEnum::DA_HUY)->paginate();
        return view("homepage.user.cart",[
            "data" => $data
        ]);
    }

    public function editCart(HistoryBuy $cart){
        return view("homepage.user.editCart",[
            "cart" => $cart
        ]);
    }

    public function receive($id){
        HistoryBuy::query()->where("id", $id)->update([
            "status"=> StatusCartEnum::DA_GIAO
        ]);
        return redirect()->back()->with("success","nhận hàng thành công");
    }

    public function updateCart(Request $request,$id){
        DB::beginTransaction();
        try {
            $cart = HistoryBuy::where("id",$id)->first();
            $book = $cart->book;
            $book->number_sell -= $cart->number;
            $book->number_sell += $request->get("number");
            $book->save();
            $cart->update([
                "number" => $request->get("number"),
                "address"=> $request->get("address"),
                "tel"=> $request->get("tel"),
            ]);
            DB::commit();
            return redirect()->back()->with('success',"Sửa thành công");
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy(HistoryBuy $cart){
        DB::beginTransaction();
        try{
            $book = $cart->book;
            $book->number_sell -= $cart->number;
            $book->save();
            $cart->delete();
            DB::commit();
            return redirect()->back()->with('success',"Xóa thành công");
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    //
}
