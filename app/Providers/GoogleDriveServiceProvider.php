<?php

namespace App\Providers;

use Storage;
use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Storage::extend(
            'google' , function($app,$config){
                $client = new \Google_Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new \Google_Service_Drive($client);

                $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, $config['folderId']);
    
                $filesystem = new \League\Flysystem\Filesystem($adapter);

                return $filesystem;
            }
        );
    }
}
