<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Fluent\Auth\Contracts\AuthenticatorInterface;
use Fluent\Auth\Contracts\AuthorizableInterface;
use Fluent\Auth\Contracts\HasAccessTokensInterface;
use Fluent\Auth\Contracts\ResetPasswordInterface;
use Fluent\Auth\Contracts\VerifyEmailInterface;
use Fluent\Auth\Facades\Hash;
use Fluent\Auth\Traits\AuthenticatableTrait;
use Fluent\Auth\Traits\AuthorizableTrait;
use Fluent\Auth\Traits\CanResetPasswordTrait;
use Fluent\Auth\Traits\HasAccessTokensTrait;
use Fluent\Auth\Traits\MustVerifyEmailTrait;

use App\Traits\AdsAutorizationTrait; 

use Fluent\JWTAuth\Contracts\JWTSubjectInterface;    // <- aqui

class User extends Entity implements
    AuthenticatorInterface,
    AuthorizableInterface,
    HasAccessTokensInterface,
    ResetPasswordInterface,
    VerifyEmailInterface,
    JWTSubjectInterface       // <- aqui
{
    use AuthenticatableTrait;
    use AuthorizableTrait;
    use CanResetPasswordTrait;
    use HasAccessTokensTrait;
    use MustVerifyEmailTrait;
    use AdsAutorizationTrait; //noso Trait superadmin

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'display_phone' => 'boolean', // adicionamos  o display_phone como bollean e não string
    ];

    /**
     * Fill set password hash.
     *
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->attributes['password'] = Hash::make($password);

        return $this;
    }

    public function flashMessageToUser()
    {
        if(session()->has('choice')){

            return 'Por favor complete todos os campos de seu perfil, antes de prosseguir para o pagamento de sua Assinatura.';
        }

        return ' Por favor, complete todos os campos de seu perfil.';
    }

    public function fullname()
    {
        return "{$this->name} {$this->last_name}";
    }

     /**
     * {@inheritdoc}
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
