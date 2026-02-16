<?php

namespace App\Providers;

use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Factory::class, function ($app) {
            $firebaseConfig = getWebConfig('push_notification_key');
            
            // Check if config is valid JSON file path or placeholder text
            if (empty($firebaseConfig) || 
                strpos($firebaseConfig, 'Put your firebase') !== false ||
                !file_exists($firebaseConfig)) {
                $firebaseConfig = storage_path('app/firebase-credentials.json');
                
                // Create a dummy credentials file if it doesn't exist
                if (!file_exists($firebaseConfig)) {
                    $dummyCredentials = [
                        'type' => 'service_account',
                        'project_id' => 'dummy-project',
                        'private_key_id' => 'dummy',
                        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC7W8RbW...\n-----END PRIVATE KEY-----\n",
                        'client_email' => 'firebase-adminsdk@dummy-project.iam.gserviceaccount.com',
                        'client_id' => '000000000000000000000',
                        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                        'token_uri' => 'https://oauth2.googleapis.com/token',
                        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                    ];
                    file_put_contents($firebaseConfig, json_encode($dummyCredentials, JSON_PRETTY_PRINT));
                }
            }
            
            try {
                return (new Factory)->withServiceAccount($firebaseConfig);
            } catch (\Exception $e) {
                // Return a default factory if Firebase setup fails
                return new Factory();
            }
        });

        $this->app->singleton(Auth::class, function ($app) {
            try {
                return $app->make(Factory::class)->createAuth();
            } catch (\Exception $e) {
                return null;
            }
        });

        $this->app->singleton(Messaging::class, function ($app) {
            try {
                return $app->make(Factory::class)->createMessaging();
            } catch (\Exception $e) {
                return null;
            }
        });

        // Optionally, you can bind it to a simpler alias
        $this->app->alias(Messaging::class, 'firebase.messaging');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
