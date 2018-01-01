<?php
namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminApp\UserActivationModel;
use App\Mail\VerifyMail;
use App\Backend;
use Mail;

class UserController extends Controller
{
	protected $viewPath = 'backend.protected.dashboard.pages.users';
	protected $typesKey = [ "su", "user", "admin"];

	public function index()
	{
		return view($this->viewPath.'.index');
	}


	public function show($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.show', ['user' => $user]);
	}


	public function create()
	{
		return view($this->viewPath.'.create');
	}


	public function store(Request $request)
	{
		$this->validate($request, [
          'firstname' => 'required|max:255',
          'lastname' => 'required|max:255',
          'mobile' => 'required|max:255',
          'email' => 'required|email|max:255|unique:mysql1.backends',
          'type' => 'required|in:' . implode(',', $this->typesKey),
          'password' => 'required|min:6|confirmed',
        ]);

		$auth = auth()->guard('backend')->user();

		Backend::create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'type' => $request->type,
        'password' => bcrypt($request->password),
        'is_active' => 1,
        'creator' => $auth->id,
      ]);
		// $this->sendVerifyEmail($request->email);
		return redirect('admin/manage/users');
	}


	public function edit($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.edit', ['user' => $user]);
	}


	public function update($email, Request $request)
	{
		$this->validate($request, [
				'firstname' => 'required|max:255',
				'lastname' => 'required|max:255',
				'mobile' => 'required|numeric',
				'email' => 'required|email|max:255',
        'type' => 'required|in:' . implode(',', $this->typesKey),
			]);

		$user = Backend::call()->findByEmailOrFail($email);
		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->mobile = $request->mobile;
		$user->email = $request->email;
		$user->type = $request->type;
		$user->save();
		session()->flash('success', 'User edit.');
		return redirect('admin/manage/users');
	}


	public function getResetPassword($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		return view($this->viewPath.'.reset_password', ['user' => $user]);
	}



	public function putResetPassword($email, Request $request)
	{
		$this->validate($request, [
        'password' => 'required|min:6|confirmed',
			]);

		$user = Backend::call()->findByEmailOrFail($email);
    $user->password = bcrypt($request->password);
    $user->save();
		session()->flash('success', 'User('.$email.') password has been reset.');
		return redirect('admin/manage/users');
	}



	public function activateUser($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		$user->activate();
		return redirect()->back();
	}


	public function suspendUser($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		$user->suspend();
		return redirect()->back();
	}


	public function destroy($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		$user->delete();
		session()->flash('danger', 'User has been deleted.');
		return redirect()->back();
	}


	public function sendVerifyEmail($email)
	{
		$user = Backend::call()->findByEmailOrFail($email);
		$token = $this->createToken($user->id);
		$data = (object)[
				"name" => $user->fullname,
				"email" => $user->email,
				"link" => route('activatePendingUser', $token)	
			];
		Mail::to($data)->queue(new VerifyMail($data));
		session()->flash('success', 'Verification email sent.');
	}


	public function resendVerifyEmail($email)
	{
		$this->sendVerifyEmail($email);
		return redirect('admin/manage/users');
	}



	public function createToken($userId)
	{
		$token = mycrypt($userId);
		$new = new UserActivationModel;
		$new->user_id = $userId;
		$new->token = $token;
		$new->save();
		return $token;
	}

	public function activatePendingUser($token)
	{
		UserActivationModel::call()->activateUser($token);
		return redirect('login');
	}



}

