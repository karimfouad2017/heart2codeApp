<?php

namespace Tests\Feature\Components;

use OpenDialogAi\ActionEngine\Configuration\BaseActionConfiguration;

class TestConfiguration extends BaseActionConfiguration
{
    protected static array $hidden = [
        'access_token', 'private_key',
        'general.user.token', 'general.private.key'
    ];

    public static function getHiddenFields(): array
    {
        return self::$hidden;
    }
}