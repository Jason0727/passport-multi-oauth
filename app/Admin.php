<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Admin extends Model
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $hidden = [
        'pass_word'
    ];

    /**
     * 返回用户密码
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * 返回唯一标识的值
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * 返回唯一标识的名称
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * 重构用户名验证
     *
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return $this->where('user_name', $username)->first();
    }

    /**
     * 重构密码验证
     *
     * @param $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password,$this->pass_word);
    }
}
