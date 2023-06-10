<?php

namespace App\Listeners;

use App\Events\SaveUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Details;

class saveUserDetails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaveUser $event): void
    {
        $gender = ($event->user->prefixname == 'Mr'? 'male' : 'female');// will break with more prefexis
        $fullname = $event->user->firstname.' '.(!empty($event->user->middlename)?$event->user->middlename.' ':'').$event->user->lastname;
        $initial =  mb_substr($event->user->firstname, 0, 1).'.'.(!empty($event->user->middlename)?$mb_substr($event->user->middlename, 0, 1).'.':'').mb_substr($event->user->lastname, 0, 1);

        Details::create([
            'user_id'=>$event->user->id,
            'key' => $initial,
            'value' => $fullname,
            'icon' => $event->user->photo,
            'status' => $gender,
        ]);
        //
    }
}
