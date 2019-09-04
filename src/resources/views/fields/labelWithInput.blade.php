<?php 
    $options = array_merge($options, ['id'=>"field-{$name}"]);
    
    if($labelIsPlaceholder){
        $options += array('placeholder' => Lang::get($labelValue));
    }
?>
<div class="{{$name}}-field">
@if(!$labelIsPlaceholder)
    {{Form::label($name, Lang::get($labelValue), ['class' => $serverErrors->has($name) ? 'error' : ''])}}
    {{Form::input($inputType, $name, $value, $options)}}
@else
    {{Form::input($inputType, $name, $value, $options)}}
@endif

@if(!is_null($errorMessageKey))
    <small class="error">
    @if(is_array($errorMessageKey))
        {{Lang::get('validation.'.$errorMessageKey['key'], $errorMessageKey['values'])}}
    @else
        {{Lang::get('validation.'.$errorMessageKey, 
            array(
                'attribute' => Lang::get($labelValue)
            )
        )}}
    @endif
    </small>
@endif

@if($serverErrors->has($name))
    <small class="server-error">{{$serverErrors->first($name)}}</small>
@endif
</div>