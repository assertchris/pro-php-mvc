<?php

return [
    // load config first, so the rest can use it...
    \Framework\Provider\ConfigProvider::class,

    \Framework\Provider\CacheProvider::class,
    \Framework\Provider\DatabaseProvider::class,
    \Framework\Provider\EmailProvider::class,
    \Framework\Provider\FilesystemProvider::class,
    \Framework\Provider\LoggingProvider::class,
    \Framework\Provider\QueueProvider::class,
    \Framework\Provider\ResponseProvider::class,
    \Framework\Provider\SessionProvider::class,
    \Framework\Provider\ValidationProvider::class,
    \Framework\Provider\ViewProvider::class,
];
