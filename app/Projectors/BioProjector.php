<?php

namespace App\Projectors;

use App\StorableEvents\UserUpdatedProfile;
use Illuminate\Support\Facades\DB;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BioProjector extends Projector
{
    public function onUserUpdatedProfile(UserUpdatedProfile $event): void
    {
        DB::table('bios')->updateOrInsert(
            ['user_id' => $event->userId],
            ['bio' => $event->bio]
        );
    }
}
