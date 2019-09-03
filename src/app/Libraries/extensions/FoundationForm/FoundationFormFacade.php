<?php namespace Rocklegend\Libraries\Extensions\FoundationForm;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class FoundationFormFacade extends IlluminateFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'formbuilder'; }

}