<?php

namespace App\Support\Websockets\Server\Channels;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManagers\ArrayChannelManager;

class LighthouseArrayChannelManager extends ArrayChannelManager
{
    protected function determineChannelClass(string $channelName): string
    {
        if (starts_with($channelName, 'private-lighthouse-')) {
            return PrivateLighthouseChannel::class;
        }

        return parent::determineChannelClass($channelName);
    }
}