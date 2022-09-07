<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Requests\UserRequest;
use App\Services\gerencianetService;
use App\Services\UserService;
use CodeIgniter\Config\Factories;

class DashboardController extends BaseController
{
    private $User;
    private $userRequest;
    private $userService;
    private $gerencianetService;

    public function __construct()
    {
        $this->user = service('auth')->user();
        $this->userRequest = Factories::class(UserRequest::class);
        $this->userService = Factories::class(UserService::class);
        $this->gerencianetService = Factories::class(gerencianetService::class);
    }

    public function index()
    {

       

        $data = [
            'title' => 'Dashboard',
        ];
        return view('Dashboard/Home/index', $data);
    }

    public function myPlan()
    {
        $data = [
            'title'             => 'Meu Plano',
            'subscription'      => $this->gerencianetService->getUserSubscription(),
            'hiddens'           => ['_method' =>'DELETE'], // Para o model de cnacelamento

        ];
        return view('Dashboard/Home/my_plan', $data);
    }

    

    public function detailCharge(int $chargeID = null )
    {

       if(is_null($chargeID))
       {
            return redirect()->back()->with('danger', 'Não identificamos a cobrança');
       }

       $charge = $this->gerencianetService->detailCharge($chargeID);

       //dd($charge);

       return redirect()->back()->with('charge', $charge);
    }

    public function profile()
    {

        $data = [
            'title'     => 'Profile',
            'hiddens'   => ['id' => $this->user->id, '_method' => 'PUT'],
        ];
        return view('Dashboard/Home/profile', $data);
    }

    public function updateProfile()
    {

        $this->userRequest->validateBeforeSave('user_profile', repondWithRedirect: true);

        $this->userService->tryUpdateProfile($this->removeSpoofingFromRequest());

        if (session()->has('choice')) {
            return redirect()->to(session('choice'));
        }

        return redirect()->back()->with('success', lang('App.success_saved'));
    }

    public function access()
    {
        $data = [
            'title'     => 'Alterar Senha',
            'hiddens'   => ['id' => $this->user->id, '_method' => 'PUT'],
        ];
        return view('Dashboard/Home/access', $data);
    }

    public function updateAccess()
    {

        $request = (object) $this->removeSpoofingFromRequest();

        //verifica se current_password e igual ao do user logado
        if (!$this->userService->currentpasswordIsValid($request->current_password)) {

            return redirect()->back()->with('danger', 'Senha atual inválida');
        }

        $this->userRequest->validateBeforeSave('access_update', repondWithRedirect: true);

        $this->userService->tryUpdateAccess($request->password);

        return redirect()->back()->with('success', lang('App.success_saved'));
    }

    public function cancelSubscription()
    {
        
        $this->gerencianetService->cancelSubscription();

        return redirect()->route('dashboard')->with('success', 'Sua assinatura foi cancelada com sucesso!');

    }

    public function confirmDeleteAccount()
    {
        
        $data = [
            'hiddens'   => ['_method' => 'DELETE'],
        ];
        return view('Dashboard/Home/confirm_delete_account', $data);
    }

    public function accountDelete()
    {
        $this->userService->deleteUserAccount();

        return redirect()->route('web.home');
    }
    
}
