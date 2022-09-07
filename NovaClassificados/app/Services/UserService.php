<?php

namespace App\Services;

use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use Fluent\Auth\Facades\Hash;
class UserService
{
    private $userModel;
    private $User;

    public function __construct()
    {
        $this->userModel    = Factories::models(UserModel::class);
        $this->user         = service('auth')->user();
    }

    public function userDataIsComplete()
    {
        if (
            is_null($this->user->name) ||
            is_null($this->user->last_name) ||
            is_null($this->user->cpf) ||
            is_null($this->user->birth) ||
            is_null($this->user->phone)
        ) {
            return false;
        }
        return true;
    }

    public function tryUpdateProfile(array $request)
    {
        try {
            //code...

            $request =(object)$request;
            $this->user->name               = $request->name;
            $this->user->last_name          = $request->last_name;
            $this->user->cpf                = $request->cpf;
            $this->user->email              = $request->email;
            $this->user->birth              = $request->birth;
            $this->user->phone              = $request->phone;
            $this->user->display_phone      = $request->display_phone;

            

            if($this->user->hasChanged()){
                $this->userModel->save($this->user);
            }

        } catch (\Throwable $e) {
            //throw $th;

            die('Não foi possivel atualizar o perfil');
        }
    }

    public function currentPasswordIsValid(string $currentPassword):bool
    {
        return Hash::check($currentPassword, $this->user->password);

    }

    public function tryUpdateAccess(string $newPassword)
    {
        try {
            //code...

           
            $this->user->password   = $newPassword;
                     
            if($this->user->hasChanged()){
                $this->userModel->save($this->user);
            }

        } catch (\Throwable $e) {
            //throw $th;

            die('Não foi possivel atualizar o seu acesso ');
        }
    }

    public function deleteUserAccount()
    {
        try {
            
            $gerencianetService = Factories::class(gerencianetService::class);

            // User tem assinatura? bool(true ou false)                      
            if($gerencianetService->userHasSubscription())
            {
                //sim... então removemos na gerencianet tambem
                $gerencianetService->cancelSubscription();

            }
                     
            // chamamos deleteUserAccount no userModel
            //removemos da nossa base de dados
            $this->userModel->deleteUserAccount();

            //destruimos a sessao
            service('auth')->logout();

        } catch (\Exception $e) {
           
            die('Não foi possivel atualizar o seu acesso ');
        }

    }

    public function getUserByCriteria(array $criteria = []) //recebemos um array de criterios 
    { 
        $user = $this->userModel->getUserByCriteria($criteria); //armazenamos o array em $user

        if(is_null($user)){ // verifica se veio vazio

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found'); // retornamos para o user uma exception

        }
        //casao nao esteja vazia retornamos array $user 
        return $user; 

    }
}
