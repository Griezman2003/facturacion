<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
        'accepted' => 'El campo :attribute debe ser aceptado.',
        'accepted_if' => 'El campo :attribute debe ser aceptado cuando :other es :value.',
        'active_url' => 'El campo :attribute no es una URL válida.',
        'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
        'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
        'alpha' => 'El campo :attribute solo debe contener letras.',
        'alpha_dash' => 'El campo :attribute solo debe contener letras, números, guiones y guiones bajos.',
        'alpha_num' => 'El campo :attribute solo debe contener letras y números.',
        'array' => 'El campo :attribute debe ser un arreglo.',
        'ascii' => 'El campo :attribute solo debe contener caracteres alfanuméricos de un solo byte.',
        'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
        'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
        'between' => [
            'array' => 'El campo :attribute debe tener entre :min y :max elementos.',
            'file' => 'El campo :attribute debe tener entre :min y :max kilobytes.',
            'numeric' => 'El campo :attribute debe estar entre :min y :max.',
            'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
        ],
        'boolean' => 'El campo :attribute debe ser verdadero o falso.',
        'can' => 'El campo :attribute contiene un valor no autorizado.',
        'confirmed' => 'La confirmación de :attribute no coincide.',
        'current_password' => 'La contraseña es incorrecta.',
        'date' => 'El campo :attribute no es una fecha válida.',
        'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
        'date_format' => 'El campo :attribute no coincide con el formato :format.',
        'decimal' => 'El campo :attribute debe tener :decimal decimales.',
        'declined' => 'El campo :attribute debe ser rechazado.',
        'declined_if' => 'El campo :attribute debe ser rechazado cuando :other es :value.',
        'different' => 'El campo :attribute y :other deben ser diferentes.',
        'digits' => 'El campo :attribute debe tener :digits dígitos.',
        'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
        'dimensions' => 'El campo :attribute tiene dimensiones de imagen inválidas.',
        'distinct' => 'El campo :attribute tiene un valor duplicado.',
        'doesnt_end_with' => 'El campo :attribute no debe terminar con uno de los siguientes: :values.',
        'doesnt_start_with' => 'El campo :attribute no debe comenzar con uno de los siguientes: :values.',
        'email' => 'El campo :attribute debe ser una dirección de correo válida.',
        'ends_with' => 'El campo :attribute debe terminar con uno de los siguientes: :values.',
        'enum' => 'El campo :attribute seleccionado no es válido.',
        'exists' => 'El campo :attribute seleccionado no es válido.',
        'extensions' => 'El campo :attribute debe tener una de las siguientes extensiones: :values.',
        'file' => 'El campo :attribute debe ser un archivo.',
        'filled' => 'El campo :attribute debe tener un valor.',
        'gt' => [
            'array' => 'El campo :attribute debe tener más de :value elementos.',
            'file' => 'El campo :attribute debe ser mayor que :value kilobytes.',
            'numeric' => 'El campo :attribute debe ser mayor que :value.',
            'string' => 'El campo :attribute debe ser mayor que :value caracteres.',
        ],
        'gte' => [
            'array' => 'El campo :attribute debe tener :value elementos o más.',
            'file' => 'El campo :attribute debe ser mayor o igual que :value kilobytes.',
            'numeric' => 'El campo :attribute debe ser mayor o igual que :value.',
            'string' => 'El campo :attribute debe ser mayor o igual que :value caracteres.',
        ],
        'hex_color' => 'El campo :attribute debe ser un color hexadecimal válido.',
        'image' => 'El campo :attribute debe ser una imagen.',
        'in' => 'El campo :attribute seleccionado no es válido.',
        'in_array' => 'El campo :attribute no existe en :other.',
        'integer' => 'El campo :attribute debe ser un número entero.',
        'ip' => 'El campo :attribute debe ser una dirección IP válida.',
        'ipv4' => 'El campo :attribute debe ser una dirección IPv4 válida.',
        'ipv6' => 'El campo :attribute debe ser una dirección IPv6 válida.',
        'json' => 'El campo :attribute debe ser una cadena JSON válida.',
        'lowercase' => 'El campo :attribute debe estar en minúsculas.',
        'lt' => [
            'array' => 'El campo :attribute debe tener menos de :value elementos.',
            'file' => 'El campo :attribute debe ser menor que :value kilobytes.',
            'numeric' => 'El campo :attribute debe ser menor que :value.',
            'string' => 'El campo :attribute debe ser menor que :value caracteres.',
        ],
        'lte' => [
            'array' => 'El campo :attribute no debe tener más de :value elementos.',
            'file' => 'El campo :attribute debe ser menor o igual que :value kilobytes.',
            'numeric' => 'El campo :attribute debe ser menor o igual que :value.',
            'string' => 'El campo :attribute debe ser menor o igual que :value caracteres.',
        ],
        'mac_address' => 'El campo :attribute debe ser una dirección MAC válida.',
        'max' => [
            'array' => 'El campo :attribute no debe tener más de :max elementos.',
            'file' => 'El campo :attribute no debe ser mayor de :max kilobytes.',
            'numeric' => 'El campo :attribute no debe ser mayor de :max.',
            'string' => 'El campo :attribute no debe ser mayor de :max caracteres.',
        ],
        'max_digits' => 'El campo :attribute no debe tener más de :max dígitos.',
        'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
        'mimetypes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
        'min' => [
            'array' => 'El campo :attribute debe tener al menos :min elementos.',
            'file' => 'El campo :attribute debe ser al menos de :min kilobytes.',
            'numeric' => 'El campo :attribute debe ser al menos :min.',
            'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        ],
        'min_digits' => 'El campo :attribute debe tener al menos :min dígitos.',
        'missing' => 'El campo :attribute debe estar ausente.',
        'multiple_of' => 'El campo :attribute debe ser un múltiplo de :value.',
        'not_in' => 'El campo :attribute seleccionado no es válido.',
        'not_regex' => 'El formato del campo :attribute no es válido.',
        'numeric' => 'El campo :attribute debe ser un número.',
        'required' => 'El campo :attribute es obligatorio.',
        'unique' => 'El campo :attribute ya ha sido registrado.',
        'url' => 'El campo :attribute debe ser una URL válida.',
        'uuid' => 'El campo :attribute debe ser un UUID válido.',
        'attributes' => [
            'rfc' => 'RFC',
            'password' => 'contraseña',
        ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
