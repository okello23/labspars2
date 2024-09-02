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

    'accepted' => 'Le :attribute doit être accepté.',
    'accepted_if' => 'Le :attribute doit être accepté lorsque :other est :value.',
    'active_url' => "Le :attribute n'est pas une URL valide.",
    'after' => 'Le :attribute doit être une date après :date.',
    'after_or_equal' => 'Le :attribute doit être une date après ou égale à :date.',
    'alpha' => 'Le :attribute ne doit contenir que des lettres.',
    'alpha_dash' => 'Le :attribute ne doit contenir que des lettres, des chiffres, des tirets et des underscores.',
    'alpha_num' => 'Le :attribute ne doit contenir que des lettres et des chiffres.',
    'array' => 'Le :attribute doit être un tableau.',
    'before' => 'Le :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le :attribute doit être une date avant ou égale à :date.',
    'between' => [
        'array' => 'Le :attribute doit avoir entre :min et :max éléments.',
        'file' => 'Le :attribute doit être compris entre :min et :max kilobytes.',
        'numeric' => 'Le :attribute doit être compris entre :min et :max.',
        'string' => 'Le :attribute doit avoir entre :min et :max caractères.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => "Le :attribute n'est pas une date valide.",

    'date_equals' => 'Le :attribute doit être une date égale à :date.',
    'date_format' => 'Le :attribute ne correspond pas au format :format.',
    'declined' => 'Le :attribute doit être refusé.',
    'declined_if' => 'Le :attribute doit être refusé lorsque :other est :value.',
    'different' => 'Le :attribute et :other doivent être différents.',
    'digits' => 'Le :attribute doit être composé de :digits chiffres.',
    'digits_between' => 'Le :attribute doit avoir entre :min et :max chiffres.',
    'dimensions' => "Le :attribute a des dimensions d'image non valides.",
    'distinct' => 'Le champ :attribute a une valeur en double.',

    'doesnt_end_with' => "Le :attribute ne peut pas se terminer par l'une des valeurs suivantes : :values.",
    'doesnt_start_with' => "Le :attribute ne peut pas commencer par l'une des valeurs suivantes : :values.",
    'email' => 'Le :attribute doit être une adresse email valide.',
    'ends_with' => "Le :attribute doit se terminer par l'une des valeurs suivantes : :values.",
    'enum' => 'Le :attribute sélectionné est invalide.',
    'exists' => 'Le :attribute sélectionné est invalide.',
    'file' => 'Le :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'array' => 'Le :attribute doit avoir plus de :value éléments.',
        'file' => 'Le :attribute doit être supérieur à :value kilobytes.',
        'numeric' => 'Le :attribute doit être supérieur à :value.',
        'string' => 'Le :attribute doit être supérieur à :value caractères.',
    ],
    'gte' => [
        'array' => 'Le :attribute doit avoir :value éléments ou plus.',
        'file' => 'Le :attribute doit être supérieur ou égal à :value kilobytes.',
        'numeric' => 'Le :attribute doit être supérieur ou égal à :value.',
        'string' => 'Le :attribute doit être supérieur ou égal à :value caractères.',
    ],
    'image' => 'Le :attribute doit être une image.',
    'in' => 'Le :attribute sélectionné est invalide.',
    'in_array' => "Le champ :attribute n'existe pas dans :other.",
    'integer' => 'Le :attribute doit être un entier.',
    'ip' => 'Le :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'array' => 'Le :attribute doit avoir moins de :value éléments.',
        'file' => 'Le :attribute doit être inférieur à :value kilobytes.',
        'numeric' => 'Le :attribute doit être inférieur à :value.',
        'string' => 'Le :attribute doit être inférieur à :value caractères.',
    ],
    'lte' => [
        'array' => 'Le :attribute ne doit pas avoir plus de :value éléments.',
        'file' => 'Le :attribute doit être inférieur ou égal à :value kilobytes.',
        'numeric' => 'Le :attribute doit être inférieur ou égal à :value.',
        'string' => 'Le :attribute doit être inférieur ou égal à :value caractères.',
    ],
    'max' => [
        'array' => 'Le :attribute ne peut pas avoir plus de :max éléments.',
        'file' => 'Le :attribute ne peut pas être supérieur à :max kilobytes.',
        'numeric' => 'Le :attribute ne peut pas être supérieur à :max.',
        'string' => 'Le :attribute ne peut pas être supérieur à :max caractères.',
    ],
    'mimes' => 'Le :attribute doit être un fichier de type: :values.',
    'min' => [
        'array' => 'Le :attribute doit avoir au moins :min éléments.',
        'file' => 'Le :attribute doit être au moins :min kilobytes.',
        'numeric' => 'Le :attribute doit être au moins :min.',
        'string' => 'Le :attribute doit avoir au moins :min caractères.',
    ],

    'min_digits' => "L'attribut :attribute doit avoir au moins :min chiffres.",
    'multiple_of' => "L'attribut :attribute doit être un multiple de :value.",
    'not_in' => "L'attribut :attribute sélectionné n'est pas valide.",
    'not_regex' => "Le format de l'attribut :attribute n'est pas valide.",
    'numeric' => "L'attribut :attribute doit être un nombre.",
    'password' => [
        'letters' => "L'attribut :attribute doit contenir au moins une lettre.",
        'mixed' => "L'attribut :attribute doit contenir au moins une lettre majuscule et une lettre minuscule.",
        'numbers' => "L'attribut :attribute doit contenir au moins un nombre.",
        'symbols' => "L'attribut :attribute doit contenir au moins un symbole.",
        'uncompromised' => "L'attribut :attribute donné a été divulgué dans une fuite de données. Veuillez choisir un autre attribut :attribute.",
    ],
    'present' => 'Le champ :attribute doit être présent.',
    'prohibited' => "Le champ d'attribut :attribute est interdit.",
    'prohibited_if' => "Le champ d'attribut :attribute est interdit lorsque :other est :value.",
    'prohibited_unless' => "Le champ d'attribut :attribute est interdit à moins que :other ne soit dans :values.",
    'prohibits' => "Le champ d'attribut :attribute interdit la présence de :other.",
    'regex' => 'Le format de :attribute est invalide.',
    'required' => 'Le champ :attribute est requis.',
    'required_if' => 'Le champ :attribute est requis lorsque :other est :value.',
    'required_unless' => 'Le champ :attribute est requis sauf si :other est :values.',
    'required_with' => 'Le champ :attribute est requis lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est requis lorsque :values sont tous présents.',
    'required_without' => "Le champ :attribute est requis lorsque :values n'est pas présent.",
    'required_without_all' => "Le champ :attribute est requis lorsque aucun de :values n'est présent.",
    'same' => 'Le :attribute et :other doivent correspondre.',
    'size' => [
        'array' => 'Le :attribute doit contenir :size éléments.',
        'file' => 'Le :attribute doit être de :size kilobytes.',
        'numeric' => 'Le :attribute doit être :size.',
        'string' => 'Le :attribute doit être de :size caractères.',
    ],
    'starts_with' => "Le :attribute doit commencer par l'une des valeurs suivantes : :values.",
    'string' => 'Le :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le :attribute doit être une zone valide.',
    'unique' => 'Le :attribute a déjà été pris.',
    'uploaded' => "Le :attribute n'a pas pu être téléchargé.",
    'url' => 'Le format de :attribute est invalide.',
    'uuid' => 'Le :attribute doit être un UUID valide.',

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
