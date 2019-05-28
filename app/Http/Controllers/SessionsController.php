<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * 用户认证
 * Class SessionsController
 * @package App\Http\Controllers
 */
class SessionsController extends Controller
{

    /**
     * 用Auth 中间件提供的 guest 选项，限制未登录用户只能访问登录页面
     * SessionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * 展示登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 登录，验证用户登录信息
     * @param Request $request
     *  email
     *  password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中注册邮件进行激活。');
                return redirect('/');
            }
        } else {
            session()->flash('danger', '你的邮箱和密码不匹配。');
            return redirect()->back();
        }
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '已成功退出！');
        return redirect('login');
    }
}
