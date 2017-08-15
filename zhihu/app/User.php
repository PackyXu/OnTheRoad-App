<?php

namespace App;

use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param Model $model
     * @return bool
     */
    public function owns (Model $model)
    {
        return $this->id == $model->user_id;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers ()
    {
        return $this->hasMany(Answer::class);
    }
    //重写邮件发送规则

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification ($token)
    {
        // 模板变量
        /*$data = ['url' => url('password/reset', $token)];
        $template = new SendCloudTemplate('ontheroad_password_reset', $data);

        Mail::raw($template, function ($message){
            $message->from('1178711258@qq.com', 'Laravel for onTheRoad');
            $message->to($this->email);
        });*/

        (new UserMailer())->passwordRest($this->email,$token);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows ()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    /**
     * @param $question
     * @return array
     */
    public function followThis ($question)
    {
        return $this->follows()->toggle($question);
    }

    /**
     * @param $question
     * @return bool
     */
    public function followed ($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers ()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUser ()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    /**
     * @param $user
     * @return array
     */
    public function followThisUser ($user)
    {
        return $this->followers()->toggle($user);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 点赞
     */
    public function votes ()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();

    }

    public function voteFor ($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVoteFor ($answer)
    {
        return !! $this->votes()->where('answer_id',$answer)->count();
    }

    public function messages ()
    {
        return $this->hasMany(Message::class,'to_user_id');
    }



}
