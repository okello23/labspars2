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

    'accepted' => ':attribute lazma iwe katika mpango.',
    'accepted_if' => ':attribute lazma iwe katika mpango wakati :other ni :value.',
    'active_url' => ':attribute sio URL sahihi.',
    'after' => ':attribute lazma iwe tarehe baada ya :date.',
    'after_or_equal' => ':attribute lazma iwe tarehe baada au sawa na :date.',
    'alpha' => ':attribute lazma iwe na herufi tu.',
    'alpha_dash' => ':attribute lazma iwe na herufi, nambari, dash na underscore tu.',
    'alpha_num' => ':attribute lazma iwe na herufi na nambari tu.',
    'array' => ':attribute lazma iwe sehemu.',
    'before' => ':attribute lazma iwe tarehe kabla ya :date.',
    'before_or_equal' => ':attribute lazma iwe tarehe kabla au sawa na :date.',
    'between' => [
        'array' => ':attribute lazma iwe na vipengele :min na :max.',
        'file' => ':attribute lazma iwe kilobyte :min na :max.',
        'numeric' => ':attribute lazma iwe kati ya :min na :max.',
        'string' => ':attribute lazma iwe na herufi :min na :max.',
    ],

    'boolean' => ':attribute lazma iwe kweli au ukweli.',
    'confirmed' => 'Thibitisho la :attribute halisasiri.',
    'current_password' => 'Nywila sio sahihi.',
    'date' => ':attribute sio tarehe sahihi.',
    'date_equals' => ':attribute lazma iwe tarehe sawa na :date.',
    'date_format' => ':attribute haisahihi kwa muundo wa :format.',
    'declined' => ':attribute lazma iwe kutokwa.',
    'declined_if' => ':attribute lazma iwe kutokwa wakati :other ni :value.',
    'different' => ':attribute na :other lazma iwe tofauti.',
    'digits' => ':attribute lazma iwe nambari :digits.',
    'digits_between' => ':attribute lazma iwe kati ya nambari :min na :max.',
    'dimensions' => ':attribute ina ukubwa wa picha isiyosahihi.',
    'distinct' => ':attribute ina thamani inayojirudisha.',
    'doesnt_end_with' => ':attribute haifai kutamatisha na moja ya vifupi hapo chini: :values.',
    'doesnt_start_with' => ':attribute haifai kuanza na moja ya vifupi hapo chini: :values.',
    'email' => ':attribute lazma iwe anwani sahihi ya email.',
    'ends_with' => ':attribute lazma iwe kutamatisha na moja ya vifupi hapo chini: :values.',
    'enum' => ':attribute iliyochaguliwa haisahihi.',
    'exists' => ':attribute iliyochaguliwa haisahihi.',
    'file' => ':attribute lazma iwe faili.',
    'filled' => ':attribute inahitaji thamani.',
    'gt' => [
        'array' => ':attribute lazma iwe na vipengele zaidi ya :value.',
        'file' => ':attribute lazma iwe kilobyte zaidi ya :value.',
        'numeric' => ':attribute lazma iwe zaidi ya :value.',
        'string' => ':attribute lazma iwe herufi zaidi ya :value.',
    ],
    'gte' => [
        'array' => ':attribute lazma iwe na vipengele au zaidi ya :value.',
        'file' => ':attribute lazma iwe kilobyte au sawa na :value.',
        'numeric' => ':attribute lazma iwe au sawa na :value.',
        'string' => ':attribute lazma iwe herufi au sawa na :value.',
    ],

    'image' => ':attribute lazma iwe picha.',
    'in' => ':attribute iliyochaguliwa haisahihi.',
    'in_array' => ':attribute haipo katika :other.',
    'integer' => ':attribute lazma iwe nambari kamili.',
    'ip' => ':attribute lazma iwe anwani sahihi ya IP.',
    'ipv4' => ':attribute lazma iwe anwani sahihi ya IPv4.',
    'ipv6' => ':attribute lazma iwe anwani sahihi ya IPv6.',
    'json' => ':attribute lazma iwe chombo sahihi cha JSON.',
    'lt' => [
        'array' => ':attribute lazma iwe na vipengele chini ya :value.',
        'file' => ':attribute lazma iwe kilobyte chini ya :value.',
        'numeric' => ':attribute lazma iwe chini ya :value.',
        'string' => ':attribute lazma iwe herufi chini ya :value.',
    ],
    'lte' => [
        'array' => ':attribute haifai kuwa na vipengele zaidi ya :value.',
        'file' => ':attribute lazma iwe kilobyte au sawa na :value.',
        'numeric' => ':attribute lazma iwe au sawa na :value.',
        'string' => ':attribute lazma iwe herufi au sawa na :value.',
    ],
    'mac_address' => ':attribute lazma iwe anwani sahihi ya MAC.',
    'max' => [
        'array' => ':attribute haifai kuwa na vipengele zaidi ya :max.',
        'file' => ':attribute haifai kuwa kilobyte zaidi ya :max.',
        'numeric' => ':attribute haifai kuwa zaidi ya :max.',
        'string' => ':attribute haifai kuwa herufi zaidi ya :max.',
    ],
    'max_digits' => ':attribute haifai kuwa na nambari zaidi ya :max.',
    'mimes' => ':attribute lazma iwe faili ya aina: :values.',
    'mimetypes' => ':attribute lazma iwe faili ya aina: :values.',

    'min' => [
        'array' => ':attribute lazma iwe na vipengele kadhalika :min.',
        'file' => ':attribute lazma iwe kilobyte kadhalika :min.',
        'numeric' => ':attribute lazma iwe kadhalika :min.',
        'string' => ':attribute lazma iwe herufi kadhalika :min.',
    ],
    'min_digits' => ':attribute lazma iwe na nambari kadhalika :min.',
    'multiple_of' => ':attribute lazma iwe wa kadhalika :value.',
    'not_in' => ':attribute iliyochaguliwa haisahihi.',
    'not_regex' => ':attribute ina muundo isiyosahihi.',
    'numeric' => ':attribute lazma iwe nambari.',
    'password' => [
        'letters' => ':attribute lazma iwe na herufi kadhalika moja.',
        'mixed' => ':attribute lazma iwe na herufi kubwa kadhalika moja na herufi ndogo kadhalika moja.',
        'numbers' => ':attribute lazma iwe na nambari kadhalika moja.',
        'symbols' => ':attribute lazma iwe na symbol kadhalika moja.',
        'uncompromised' => ':attribute ulioomba umetokea katika mfasiri wa data. Tafadhali chagua :attribute nyingine.',
    ],

    'present' => ':attribute lazma iwe katika sehemu.',
    'prohibited' => ':attribute sehemu inakataliwa.',
    'prohibited_if' => ':attribute sehemu inakataliwa wakati :other ni :value.',
    'prohibited_unless' => ':attribute sehemu inakataliwa ila :other ni katika :values.',
    'prohibits' => ':attribute sehemu inakataliwa :other kutoka kutokea.',
    'regex' => ':attribute ina muundo isiyosahihi.',
    'required' => ':attribute sehemu inahitajika.',
    'required_array_keys' => ':attribute sehemu lazma iwe na taarifa kwa: :values.',
    'required_if' => ':attribute sehemu inahitajika wakati :other ni :value.',
    'required_unless' => ':attribute sehemu inahitajika ila :other ni katika :values.',
    'required_with' => ':attribute sehemu inahitajika wakati :values inapatikana.',
    'required_with_all' => ':attribute sehemu',
    'required_without' => ':attribute sehemu inahitajika wakati :values haipatikani.',
    'required_without_all' => ':attribute sehemu inahitajika wakati hakuna ya :values yana patikana.',
    'same' => ':attribute na :other lazma iwe sawa.',
    'size' => [
        'array' => ':attribute lazma iwe na vipengele :size.',
        'file' => ':attribute lazma iwe kilobyte :size.',
        'numeric' => ':attribute lazma iwe :size.',
        'string' => ':attribute lazma iwe herufi :size.',
    ],
    'starts_with' => ':attribute lazma iwe iandike na moja wa :values.',
    'string' => ':attribute lazma iwe kama string.',
    'timezone' => ':attribute lazma iwe timezone sahihi.',
    'unique' => ':attribute tayari imepata.',
    'uploaded' => ':attribute haikusaki kupakia.',
    'url' => ':attribute lazma iwe URL sahihi.',
    'uuid' => ':attribute lazma iwe UUID sahihi.',

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
