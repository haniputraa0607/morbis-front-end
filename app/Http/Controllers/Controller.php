<?php

namespace App\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function login(Request $request)
    {
        $post = $request->except('_token');

		$postLogin = MyHelper::postLogin($post);
        if(isset($postLogin['error']) || (isset($postLogin['status']) && $postLogin['status'] == "fail")){
            return redirect('login')->withErrors(['invalid_credentials' => 'Email / Password salah'])->withInput();
		}

        $postLogin = $postLogin['result'];
        session([
            'access_token' => 'Bearer '.$postLogin['access_token'],
            'name'         => $postLogin['admin']['name'],
            'email'        => $postLogin['admin']['email'],
        ]);

        return redirect('home');

    }

    public function home()
    {

        $currQueue = MyHelper::get('admin/queue');
        if(isset($currQueue['status']) && $currQueue['status'] == "fail"){
            $data['current'] = [];
		}else{
            $data['current'] = $currQueue['result']??[];
        }

        $listQueue = MyHelper::get('admin/list-queue');
        if(isset($listQueue['status']) && $listQueue['status'] == "fail"){
            $data['list'] = [];
		}else{
            $data['list'] = $listQueue['result']??[];
        }

        return view('home', $data);

    }

    public function change($type = 'next')
    {
        if($type == 'next'){
            $currQueue = MyHelper::get('admin/queue/next');
        }elseif($type == 'prev'){
            $currQueue = MyHelper::get('admin/queue/prev');
        }else{
            $finish = MyHelper::get('admin/finished');
            if(isset($finish['status']) && $finish['status'] == "success"){
                $currQueue = MyHelper::get('admin/queue');
            }
        }

        if(isset($currQueue['status']) && $currQueue['status'] == "fail"){
            $data['current'] = [];
		}else{
            $data['current'] = $currQueue['result']??[];
        }

        $listQueue = MyHelper::get('admin/list-queue');
        if(isset($listQueue['status']) && $listQueue['status'] == "fail"){
            $data['list'] = [];
		}else{
            $data['list'] = $listQueue['result']??[];
        }

        return $data;
    }
}
