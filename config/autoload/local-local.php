<?php
/**
 * Local application configuration
 *
 * Insert your local database credentials here
 * and provide the email address the system should use.
 */

return array(
    'db' => array(
        'database' => 'app_db',
        'username' => 'app_user',
        'password' => 'app_password',

        'hostname' => '192.168.106.2',
        'port' => 3306,
    ),
    'mail' => array(
        'type' => 'file', // or 'smtp' or 'smtp-tls' (or 'file', to not send, but save to file (data/mails/))
        'address' => 'platzreservierung@tennis-schwabmuenchen.de',
            // Make sure 'bookings.example.com' matches the hosting domain when using type 'sendmail'

        'host' => '?', // for 'smtp' type only, otherwise remove or leave as is
        'user' => '?', // for 'smtp' type only, otherwise remove or leave as is
        'pw' => '?', // for 'smtp' type only, otherwise remove or leave as is

        'port' => 'auto', // for 'smtp' type only, otherwise remove or leave as is
        'auth' => 'plain', // for 'smtp' type only, change this to 'login' if you have problems with SMTP authentication
    ),
    'i18n' => array(
        'choice' => array(
            'de-DE' => 'Deutsch',
            'en-US' => 'English',

            // More possible languages:
            // 'fr-FR' => 'Français',
            // 'hu-HU' => 'Magyar',
        ),

        'currency' => 'EUR',

        // The language is usually detected from the user's web browser.
        // If it cannot be detected automatically and there is no cookie from a manual language selection,
        // the following locale will be used as the default "fallback":
        'locale' => 'de-DE',
    ),
);
