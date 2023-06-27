<?php

namespace Pterodactyl\Services\Helpers;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;
use Pterodactyl\Services\Helpers\BlueprintPlaceholderService;

class BlueprintVariableService
{
  // Construct BlueprintVariableService
  public function __construct(
    private SettingsRepositoryInterface $settings,
    private BlueprintPlaceholderService $blueprintplaceholderservice,
  ) {
  }


  // $bp->serve()
  // $bp->isInstalled()
  // $bp->version()
  // $bp->dbGet('db::record')
  // $bp->dbSet('db::record', 'value')
  // $bp->exec('arguments')
  public function serve(): void {
    return;
  }

  public function version(): string {
    return $this->blueprintplaceholderservice->version();
  }

  public function isInstalled(): string {
    return $this->blueprintplaceholderservice->installed();
  }

  public function dbGet($key): string {
    $a = $this->settings->get("blueprint::".$key);
    if (!$a) {
      return "";
    } else {
      return $a;
    };
  }

  public function dbSet($key, $value): void {
    $this->settings->set('blueprint::' . $key, $value);
    return;
  }

  public function exec($arg): string|null {
    return shell_exec("cd /var/www/".$this->blueprintplaceholderservice->folder().";bash blueprint.sh -exec ".escapeshellarg($arg));
  }
}
