<?php namespace Rocklegend\Libraries\Extensions\FoundationForm;

use Illuminate\Support\ServiceProvider as  IlluminateServiceProvider;
use Rocklegend\Libraries\Extensions\FoundationForm\FoundationForm;

class FoundationFormServiceProvider extends IlluminateServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('formbuilder', function($app)
        {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('formbuilder');
    }

}