<?php

namespace App\Utils;

class EnvironmentUtils
{
    const APP_NAME = "app.name";
    const APP_ENV = "app.env";
    const APP_KEY = "app.key";
    const APP_DEBUG = "app.debug";
    const APP_URL = "app.url";

    const LOG_CHANNEL = "logging.default";

    const DB_CONNECTION = "DB_CONNECTION";
    const DB_HOST = "DB_HOST";
    const DB_PORT = "DB_PORT";
    const DB_DATABASE = "DB_DATABASE";
    const DB_USERNAME = "DB_USERNAME";
    const DB_PASSWORD = "DB_PASSWORD";

    const BROADCAST_DRIVER = "BROADCAST_DRIVER";
    const CACHE_DRIVER = "CACHE_DRIVER";
    const QUEUE_CONNECTION = "QUEUE_CONNECTION";
    const SESSION_DRIVER = "SESSION_DRIVER";
    const SESSION_LIFETIME = "SESSION_LIFETIME";

    const REDIS_HOST = "REDIS_HOST";
    const REDIS_PASSWORD = "REDIS_PASSWORD";
    const REDIS_PORT = "REDIS_PORT";

    const MAIL_MAILER = "mail.mailer";
    const MAIL_HOST = "mail.host";
    const MAIL_PORT = "mail.port";
    const MAIL_USERNAME = "mail.username";
    const MAIL_PASSWORD = "mail.password";
    const MAIL_ENCRYPTION = "mail.encryption";
    const MAIL_FROM_ADDRESS = "mail.from.address";
    const MAIL_FROM_NAME = "mail.from.name";

    const AWS_ACCESS_KEY_ID = "AWS_ACCESS_KEY_ID";
    const AWS_SECRET_ACCESS_KEY = "AWS_SECRET_ACCESS_KEY";
    const AWS_DEFAULT_REGION = "AWS_DEFAULT_REGION";
    const AWS_BUCKET = "AWS_BUCKET";

    const PUSHER_APP_ID = "PUSHER_APP_ID";
    const PUSHER_APP_KEY = "PUSHER_APP_KEY";
    const PUSHER_APP_SECRET = "PUSHER_APP_SECRET";
    const PUSHER_APP_CLUSTER = "PUSHER_APP_CLUSTER";

    const MIX_PUSHER_APP_KEY = "MIX_PUSHER_APP_KEY";
    const MIX_PUSHER_APP_CLUSTER = "MIX_PUSHER_APP_CLUSTER";

    /**
     * Get an environment value by key
     * @param String $key
     * @return String $value
     */
    public function getByKey($key)
    {
        return config($key);
    }
}
