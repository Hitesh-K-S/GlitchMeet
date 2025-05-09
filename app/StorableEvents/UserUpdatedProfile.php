<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserUpdatedProfile extends ShouldBeStored
{
    public function __construct( 
        public int $userId,
        public ?string $bio
        )
    {
    }
}
