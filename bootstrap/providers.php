<?php

use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;

return [
    // Providers del core
    AuthServiceProvider::class,
    BroadcastServiceProvider::class,
    BusServiceProvider::class,
    CacheServiceProvider::class,
    ConsoleSupportServiceProvider::class,
    CookieServiceProvider::class,
    DatabaseServiceProvider::class,
    EncryptionServiceProvider::class,
    FilesystemServiceProvider::class,
    FoundationServiceProvider::class,
    HashServiceProvider::class,
    MailServiceProvider::class,
    NotificationServiceProvider::class,
    PaginationServiceProvider::class,
    PipelineServiceProvider::class,
    QueueServiceProvider::class,
    RedisServiceProvider::class,
    PasswordResetServiceProvider::class,
    SessionServiceProvider::class,
    TranslationServiceProvider::class,
    ValidationServiceProvider::class,
    ViewServiceProvider::class,
    EventServiceProvider::class,
    LogServiceProvider::class,
    RoutingServiceProvider::class,

    App\Providers\FortifyServiceProvider::class,
    App\Providers\AppServiceProvider::class,
];
