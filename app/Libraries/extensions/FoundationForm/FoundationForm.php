<?php namespace Rocklegend\Libraries\Extensions\FoundationForm;


use Collective\Html\FormBuilder as IlluminateFormBuilder;
use Lang;

class FormBuilder extends IlluminateFormBuilder {

    public function labelWithInput(	$name, 
    								$labelValue = null, 
    								$value = null, 
    								$serverErrors, 
    								$inputType = "text", 
    								$options = array(), 
    								$errorMessageKey = null,
                    $labelIsPlaceholder = false)
    {
        $options = $options + array('id'=>"field-{$name}");

        if($labelIsPlaceholder){
          $options += array('placeholder' => Lang::get($labelValue));
        }

        $html = '<div class="'.$name.'-field">';

        if(!$labelIsPlaceholder){
        			$html .= '<label for="'.$name.'" '.($serverErrors->has($name) ? 'class="error"' : '').'>'
    				. Lang::get($labelValue)
    				. $this->input($inputType, $name, $value, $options)
    				. '</label>';
        }else{
          $html .= $this->input($inputType, $name, $value, $options);
        }

		if(!is_null($errorMessageKey)){
       		$html .= '<small class="error">';

			if(is_array($errorMessageKey)){
				$html .= Lang::get('validation.'.$errorMessageKey['key'], 
									$errorMessageKey['values']
						);
			}else{
       			$html .= Lang::get('validation.'.$errorMessageKey, 
       								array(
       									'attribute' => Lang::get($labelValue)
       								)
       					);
       		}

       		$html .= '</small>';
       	}
        
       	if($serverErrors->has($name)){
       		$html .= '<small class="server-error">'.$serverErrors->first($name).'</small>';
       	}

        $html .= '</div>';

        return $html;
    }

}