<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\slide;
use App\Models\product;
use App\Models\type_product;
use App\Models\cart;
use App\Models\person;
use App\Models\bill;
use App\Models\detail_bill;
use App\Models\account;
use Illuminate\Support\Facades\Hash;
use Auth;
class PageController extends Controller
{
	//lấy trang chủ
    public function getIndex(){
    	$slide = slide::all();
    	$new_product= product::where('new',1)->paginate(8);
    	$sanpham_khuyenmai= product::where('promotion_price','<>',0)->paginate(8); 
    	// print_r($new_product);
    	// exit;
        // return view('page.trangchu',['slide'=>$slide]);

        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }
    public function getLoaiSanPham($type){
        $sp_theoloai= product::where('id_type', $type)->paginate(9);
        $sp_khac=product::where('id_type','<>',$type)->paginate(3);
        $loai=type_product::all();
        $loai_sp=type_product::where('id',$type)->first();
    	return view('page.loai_san_pham',compact('sp_theoloai','sp_khac','loai','loai_sp')); 
    }
    public function getChiTietSp(Request $req){
        $sanpham= product::where('id',$req->id)->first();
        $sp_tuongtu = product::where('id_type',$sanpham->id_type)->paginate(6);
    	return view('page.chi_tiet_sp',compact('sanpham','sp_tuongtu')); 
    }
    public function getLienHe(){
    	return view('page.lien_he'); 
    }
    public function getGioiThieu(){
    	return view('page.gioi_thieu'); 
    }
    public function getAddToCart(Request $req,$id){
        $product = product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new cart($oldCart);
        $cart -> add($product, $id);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }
    public function deleteCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0)
            Session::put('cart', $cart);
        else
            Session::forget('cart');
        return redirect()->back();
    }
    public function getCheckout(){
        $cart = Session::get('cart');
        $product_cart =$cart->items;
        $totalPrice =$cart->totalPrice;
        $totalQty =$cart->totalQty;
        return view('page.dat_hang',compact('product_cart','totalPrice','totalQty'));
    }
    public function postCheckout(Request $req){
        $cart = Session::get('cart');
        $person = new person;
        $person->fullname=$req->name;
        $person->gender=$req->gender;
        $person->email=$req->email;
        $person->address=$req->address;
        $person->numphone = $req->numphone;
        $person->note = $req->note;
        $person->save();

        $bill = new bill;
        $bill->date_order = date('Y-m-d');
        $bill ->total = $cart->Total_price;
        $bill ->payment = $req->payment;
        $bill->note = $req->note;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new order;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');
    }
    public function getLogin(){
        return view('page.login');
    }
    public function getSignup(){
        return view('page.dang_ky');
    }
    public function postSignup(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'fullname.required'=>'Vui lòng nhập họ và tên',
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.uique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập Password',
                're_password.same'=>'Mật khẩu không giống nhau'
            ]
        );
         $account = new account();
        $account->fullname= $req->fullname;
        $account->email = $req->email;
        $account->password= Hash::make($req->password);
        $account->phone = $req->phone;
        $account->address = $req->address;
        $account->save();
        return redirect()->back()->with('thanhcong', 'Đã tạo tài khoản thành công');
    }
    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập password'
            ]
        );
        $credentials = array('email'=>$req->email, 'password'=>$req->password);
        if(Auth::attempt($credentials)){
            // return redirect->back()->with('thongbao'=>'Đăng nhập thành công');
        }else{
            // return redirect->back()->with('thongbao'=>'Đăng nhập không thành công');
        }
    }
}
