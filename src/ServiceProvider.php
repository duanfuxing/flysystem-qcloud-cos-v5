<?php

namespace duan617\Flysystem\QcloudCOSv5;

use duan617\Flysystem\QcloudCOSv5\Plugins\CDN;
use duan617\Flysystem\QcloudCOSv5\Plugins\CloudInfinite;
use duan617\Flysystem\QcloudCOSv5\Plugins\ContentReview;
use duan617\Flysystem\QcloudCOSv5\Plugins\GetFederationToken;
use duan617\Flysystem\QcloudCOSv5\Plugins\GetFederationTokenV3;
use duan617\Flysystem\QcloudCOSv5\Plugins\GetUrl;
use duan617\Flysystem\QcloudCOSv5\Plugins\MediaProcess;
use duan617\Flysystem\QcloudCOSv5\Plugins\PutRemoteFile;
use duan617\Flysystem\QcloudCOSv5\Plugins\PutRemoteFileAs;
use duan617\Flysystem\QcloudCOSv5\Plugins\TCaptcha;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use League\Flysystem\Filesystem;
use Qcloud\Cos\Client;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app instanceof LumenApplication) {
            $this->app->configure('filesystems');
        }

        $this->app->make('filesystem')
                  ->extend('cosv5', function ($app, $config) {
                      $client = new Client($config);
                      $flysystem = new Filesystem(new Adapter($client, $config), $config);

                      $flysystem->addPlugin(new PutRemoteFile());
                      $flysystem->addPlugin(new PutRemoteFileAs());
                      $flysystem->addPlugin(new GetUrl());
                      $flysystem->addPlugin(new CDN($client,$config));
                      $flysystem->addPlugin(new TCaptcha());
                      $flysystem->addPlugin(new GetFederationToken());
                      $flysystem->addPlugin(new GetFederationTokenV3());
                      $flysystem->addPlugin(new CloudInfinite());
                      $flysystem->addPlugin(new MediaProcess($client,$config));
                      $flysystem->addPlugin(new ContentReview($client,$config));

                      return $flysystem;
                  });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/filesystems.php', 'filesystems'
        );
    }
}
