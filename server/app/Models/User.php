<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   
    protected $table = 'users'; // 指定對應的資料庫表格名稱

    
    protected $primaryKey = 'userID'; // 指定主鍵的名稱

    
    protected $fillable = [
        'userID',
        'accountForm',
        'userName',
        'email',
        'hashpassword',
        'token',
        'profilePhoto',
        'phone',
        'publish',
        'finish',
        'membershipLevel',
        'verCode',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
