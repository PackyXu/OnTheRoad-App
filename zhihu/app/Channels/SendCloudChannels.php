<?php    /**     * Created by PhpStorm.     * User: ontheroad     * Date: 2017/8/8     * Time: 15:38     */    namespace App\Channels;    use Illuminate\Notifications\Notification;    class SendCloudChannels    {        public function send ($notifiable, Notification $notification)        {            $message = $notification->toSendCloud($notifiable);        }    }