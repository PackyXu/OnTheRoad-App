<?php

namespace App\Notifications;

use App\Channels\SendCloudChannels;
use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Support\Facades\Mail;

/**
 * Class NewUserFollowNotification
 * @package App\Notifications
 */
class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendCloudChannels::class];
    }

    public function toSendCloud ($notifiable)
    {
        // 模板变量
       /* $data = ['url' => url('http://127.0.0.1:8000', Auth::guard('api')->user()->name)];
        $template = new SendCloudTemplate('ontheroad_app_new_user_follow', $data);

        Mail::raw($template, function ($message) use ($notifiable){
            $message->from('1178711258@qq.com', 'Laravel for onTheRoad');
            $message->to($notifiable->email);
        });*/

        (new UserMailer())->followNotifyEmail($notifiable->email);

    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase ($notifiable)
    {
        return [
            'name' => Auth::guard('api')->user()->name
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    /*public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
