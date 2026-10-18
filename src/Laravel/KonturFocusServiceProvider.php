<?php

declare(strict_types=1);

namespace Ex3mm\KonturFocus\Laravel;

use Ex3mm\KonturFocus\Client\GuzzleClientFactory;
use Ex3mm\KonturFocus\Config\KonturFocusConfig;
use Ex3mm\KonturFocus\Contracts\ResponseMapperInterface;
use Ex3mm\KonturFocus\KonturFocusManager;
use Ex3mm\KonturFocus\Mappers\ResponseMapper;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;

final class KonturFocusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/kontur-focus.php', 'kontur-focus');

        $this->app->bind(ResponseMapperInterface::class, ResponseMapper::class);

        $this->app->singleton(GuzzleClientFactory::class, function (Application $app): GuzzleClientFactory {
            /** @var ConfigRepository $configRepository */
            $configRepository = $app->make('config');

            /** @var array<string, mixed> $config */
            $config = $configRepository->get('kontur-focus', []);
            /** @var array<string, mixed> $loggingConfig */
            $loggingConfig = (array) ($config['logging'] ?? []);
            $channel = $loggingConfig['channel'] ?? 'default';
            $channel = is_string($channel) ? $channel : 'default';

            // Получаем логгер из Laravel
            /** @var LogManager $logManager */
            $logManager = $app->make('log');
            $logger = $channel === 'default'
                ? $logManager
                : $logManager->channel($channel);

            return new GuzzleClientFactory(logger: $logger);
        });

        $this->app->singleton(KonturFocusManager::class, function (Application $app): KonturFocusManager {
            /** @var ConfigRepository $configRepository */
            $configRepository = $app->make('config');

            /** @var array<string, mixed> $config */
            $config = $configRepository->get('kontur-focus', []);

            return new KonturFocusManager(
                KonturFocusConfig::fromArray($config),
                $app->make(GuzzleClientFactory::class),
                $app->make(ResponseMapperInterface::class),
            );
        });

        $this->app->alias(KonturFocusManager::class, 'kontur-focus');
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/kontur-focus.php' => config_path('kontur-focus.php'),
        ], 'kontur-focus-config');
    }
}
