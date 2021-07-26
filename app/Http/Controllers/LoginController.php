<?php

namespace App\Http\Controllers;

use App\Models\MinistryModel;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return View('login');
    }
    public function process(Request $request){
        try{
            $email = $request->get('email');
            $password = $request->get('password');
            $result = MinistryModel::where('email', $email)
            ->where('passWord', $password)

            ->firstOrFail();
            $request->session()->put('id',$result->id);
            $request->session()->put('name',$result->name);
            $request->session()->put('email',$result->email);
            return redirect(route('fee.index'));
        } catch(Exception $es) {
            return redirect(route('login'))->with('error','Email hoặc mật khẩu không đúng');
        }
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect(route('login'));
    }

    public function changepass(){
        return view('changepass');
    }
    public function changepasswordprocess(Request $request){
        $id = $request->session()->get('id');
        $check = MinistryModel::select('*')
        ->where('id',$id)->first();
        $pass = $request->password;
        $newPass = $request->newpassword;
        $repass = $request->rePass;
        if($newPass == $repass){
            if($check->passWord == $pass){
                MinistryModel::where('id',$id)
                ->update(['passWord'=>$newPass]);
            } else {
                return redirect(route('changepass'))->with('errorPass','Mật khẩu cũ không đúng');
            }
        } else {
            return redirect(route('changepass'))->with('errorPass','Mật khẩu nhập lại không trùng khớp');
        }
        return redirect(route('login'));
    }

}
