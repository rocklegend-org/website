<?php

namespace Rocklegend\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    public function boot()
    {
      Form::component(
        'labelWithInput',
        'fields.labelWithInput',
        [
          'name',
          'labelValue' => null,
          'value' => null,
          'serverErrors',
          'inputType' => 'text',
          'options' => [],
          'errorMessageKey' => null,
          'labelIsPlaceholder' => false
          ]
      );
    }

    public function register()
    {

    }
}
