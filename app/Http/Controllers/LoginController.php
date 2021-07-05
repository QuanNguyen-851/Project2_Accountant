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
            ->where('block','=','0')
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
}
