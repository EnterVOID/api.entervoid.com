<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $login
 * @property integer $posts
 * @property string $real_name
 * @property string $passwd
 * @property string $email_address
 * @property string $gender
 * @property string $birthdate
 * @property string $website_title
 * @property string $website_url
 * @property string $location
 * @property integer $avatar_id
 * @property string $avatar
 * @property integer $times_warned
 * @property integer $extensions_available
 * @property string $secret_question
 * @property string $secret_answer
 * @property string $password_salt
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePosts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePasswd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmailAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBirthdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereWebsiteTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereWebsiteUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAvatarId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTimesWarned($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereExtensionsAvailable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSecretQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSecretAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePasswordSalt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 */
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
