<?php

namespace Codesource\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of User
 *
 * @author abc
 */
class User extends Model {
    //put your code here
    
    protected $table= 'users';
    
    protected $fillable=array(
        'username'
    );
}
