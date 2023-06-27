<?php

/*
| Welcome to the Blueprint Extension Library.
|
| This allows extensions to easily communicate with
| Blueprint and Pterodactyl.
*/

namespace Pterodactyl\Services\Helpers;

use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;
use Pterodactyl\Services\Helpers\BlueprintPlaceholderService;

class BlueprintExtensionLibrary
{
    // Construct BlueprintExtensionLibrary
    public function __construct(
        private SettingsRepositoryInterface $settings,
        private BlueprintPlaceholderService $placeholder,
    ) {
    }


    /*
    | Databasing
    |
    | dbGet("table", "record");
    | dbSet("table", "record", "value");
    */
    public function dbGet($table, $record) {
        return $this->settings->get($table."::".$record);
    }

    public function dbSet($table, $record, $value) {
        return $this->settings->set($table."::".$record, $value);
    }


    /*
    | Notifications
    |
    | notify("text");
    | notifyAfter("text");
    */
    public function notify($text) {
        $this->dbSet("blueprint", "notification:text", $text);
        shell_exec("cd /var/www/".escapeshellarg($this->placeholder->folder()).";echo \"".escapeshellarg($text)."\" > .blueprint/data/internal/db/notification;");
        return;
    }

    public function notifyAfter($delay, $text) {
        $this->dbSet("blueprint", "notification:text", $text);
        shell_exec("cd /var/www/".escapeshellarg($this->placeholder->folder()).";echo \"".escapeshellarg($text)."\" > .blueprint/data/internal/db/notification;");
        header("Refresh:$delay");
        return;
    }
}
