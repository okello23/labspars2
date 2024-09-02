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

    'accepted' => 'يجب قبول السمة :attribute.',
    'accepted_if' => 'يجب قبول السمة :attribute عندما يكون :other هو :value.',
    'active_url' => 'السمة :attribute ليست عنوان URL صالح.',
    'after' => 'يجب أن تكون السمة :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن تكون السمة :attribute تاريخًا بعد أو يساوي :date.',
    'alpha' => 'يجب أن تحتوي السمة :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن تحتوي السمة :attribute على أحرف وأرقام وشرطات وخطوط تحتية فقط.',
    'alpha_num' => 'يجب أن تحتوي السمة :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن تكون السمة :attribute مجموعة.',
    'before' => 'يجب أن تكون السمة :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن تكون السمة :attribute تاريخًا قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن تتوفر السمة :attribute بين :min و :max عنصر.',
        'file' => 'يجب أن يكون حجم السمة :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون السمة :attribute بين :min و :max.',
        'string' => 'يجب أن تتوفر السمة :attribute بين :min و :max محارف.',
    ],
    'boolean' => 'يجب أن يكون حقل السمة :attribute صحيحًا أو خاطئًا.',
    'confirmed' => 'لا يتطابق تأكيد السمة :attribute.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'السمة :attribute ليست تاريخًا صالحًا.',
    'date_equals' => 'يجب أن تكون السمة :attribute تاريخًا يساوي :date.',
    'date_format' => 'لا يتطابق السمة :attribute مع التنسيق :format.',
    'declined' => 'يجب أن يرفض السمة :attribute.',
    'declined_if' => 'يجب أن يرفض السمة :attribute عندما يكون :other هو :value.',
    'different' => 'يجب أن تكون السمة :attribute و :other مختلفتين.',
    'digits' => 'يجب أن تكون السمة :attribute :digits أرقام.',
    'digits_between' => 'يجب أن تكون السمة :attribute بين :min و :max أرقام.',
    'dimensions' => 'تحتوي السمة :attribute على أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل السمة :attribute على قيمة مكررة.',
    'doesnt_end_with' => 'قد لا ينتهي السمة :attribute بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'قد لا يبدأ السمة :attribute بأحد القيم التالية: :values.',
    'email' => 'يجب أن تكون السمة :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن ينتهي السمة :attribute بأحد القيم التالية: :values.',
    'enum' => 'السمة المختارة :attribute غير صالحة.',
    'exists' => 'السمة المختارة :attribute غير صالحة.',
    'file' => 'يجب أن تكون السمة :attribute ملفًا.',
    'filled' => 'يجب أن يحتوي حقل السمة :attribute على قيمة.',
    'gt' => [
        'array' => 'يجب أن تحتوي السمة :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم السمة :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون السمة :attribute أكبر من :value.',
        'string' => 'يجب أن تتكون السمة :attribute من أكثر من :value محارف.',
    ],
    'gte' => [
        'array' => 'يجب أن تحتوي السمة :attribute على :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم السمة :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون السمة :attribute أكبر من أو يساوي :value.',
        'string' => 'يجب أن تتكون السمة :attribute من :value محارف أو أكثر.',
    ],
    'image' => 'يجب أن تكون السمة :attribute صورة.',
    'in' => 'السمة المختارة :attribute غير صالحة.',
    'in_array' => 'لا يوجد حقل السمة :attribute في :other.',
    'integer' => 'يجب أن تكون السمة :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن تكون السمة :attribute عنوان IP صحيح.',
    'ipv4' => 'يجب أن تكون السمة :attribute عنوان IPv4 صحيح.',
    'ipv6' => 'يجب أن تكون السمة :attribute عنوان IPv6 صحيح.',
    'json' => 'يجب أن تكون السمة :attribute سلسلة JSON صحيحة.',
    'lt' => [
        'array' => 'يجب أن تحتوي السمة :attribute على أقل من :value عناصر.',
        'file' => 'يجب أن يكون حجم السمة :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون السمة :attribute أقل من :value.',
        'string' => 'يجب أن تتكون السمة :attribute من أقل من :value محارف.',
    ],
    'lte' => [
        'array' => 'يجب ألا تحتوي السمة :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن لا يكون حجم السمة :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب ألا يكون السمة :attribute أكبر من :value.',
        'string' => 'يجب ألا تتكون السمة :attribute من أكثر من :value محارف.',
    ],
    'mac_address' => 'يجب أن تكون السمة :attribute عنوان MAC صحيح.',
    'max' => [
        'array' => 'يجب ألا تحتوي السمة :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يكون حجم السمة :attribute أكبر من :max كيلوبايت.',
        'numeric' => 'يجب ألا يكون السمة :attribute أكبر من :max.',
        'string' => 'يجب ألا تتكون السمة :attribute من أكثر من :value محارف.',
    ],
    'mac_address' => 'يجب أن تكون السمة :attribute عنوان MAC صحيح.',
    'max' => [
        'array' => 'يجب ألا تحتوي السمة :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يكون حجم السمة :attribute أكبر من :max كيلوبايت.',
        'numeric' => 'يجب ألا يكون السمة :attribute أكبر من :max.',
        'string' => 'يجب ألا تتكون السمة :attribute من أكثر من :max محارف.',
    ],
    'max_digits' => 'يجب ألا تحتوي السمة :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن تكون السمة :attribute ملف من نوع: :values.',
    'mimetypes' => 'يجب أن تكون السمة :attribute ملف من نوع: :values.',
    'min' => [
        'array' => 'يجب أن تحتوي السمة :attribute على الأقل :min عناصر.',
        'file' => 'يجب أن يكون حجم السمة :attribute الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن يكون السمة :attribute الأقل :min.',
        'string' => 'يجب أن تتكون السمة :attribute من الأقل :min محارف.',
    ],
    'min_digits' => 'يجب أن تحتوي السمة :attribute على الأقل :min أرقام.',
    'multiple_of' => 'يجب أن تكون السمة :attribute عدد مضاعف للقيمة :value.',
    'not_in' => 'السمة المحددة :attribute غير صحيحة.',
    'not_regex' => 'تنسيق السمة :attribute غير صحيح.',
    'numeric' => 'يجب أن تكون السمة :attribute عدد.',
    'password' => [
        'letters' => 'يجب أن تحتوي السمة :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن تحتوي السمة :attribute على حرف واحد صغير وحرف واحد كبير على الأقل.',
        'numbers' => 'يجب أن تحتوي السمة :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن تحتوي السمة :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'تم العثور على السمة المعطاة :attribute في تسريب بيانات. يرجى اختيار سمة مختلفة :attribute.',
    ],
    'present' => 'يجب أن يكون الحقل :attribute موجودًا.',
    'prohibited' => 'ممنوع الحقل :attribute.',
    'prohibited_if' => 'ممنوع الحقل :attribute عندما يكون :other :value.',
    'prohibited_unless' => 'ممنوع الحقل :attribute ما لم يكن :other في :values.',
    'prohibits' => 'يمنع الحقل :attribute من أن يكون :other موجودًا.',
    'regex' => 'تنسيق الحقل :attribute غير صحيح.',
    'required' => 'الحقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي الحقل :attribute على إدخالات ل: :values.',
    'required_if' => 'الحقل :attribute مطلوب عندما يكون :other :value.',
    'required_unless' => 'الحقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'الحقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'الحقل :attribute مطلوب عند وجود :values.',
    'required_without' => 'الحقل :attribute مطلوب عند عدم وجود :values.',
    'required_without_all' => 'الحقل :attribute مطلوب عند عدم وجود أي من :values.',
    'same' => 'يجب أن يتطابق العنصر :attribute و:other.',
    'size' => [
        'array' => 'يجب أن يحتوي العنصر :attribute على :size عناصر.',
        'file' => 'يجب أن يكون العنصر :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن يكون العنصر :attribute :size.',
        'string' => 'يجب أن يكون العنصر :attribute :size حروف.',
    ],
    'starts_with' => 'يجب أن يبدأ العنصر :attribute بأحد التالي: :values.',
    'string' => 'يجب أن يكون العنصر :attribute سلسلة حروف.',
    'timezone' => 'يجب أن يكون العنصر :attribute نطاقًا زمنيًا صالحًا.',
    'unique' => 'تم اختيار العنصر :attribute مسبقًا.',
    'uploaded' => 'فشل في تحميل العنصر :attribute.',
    'url' => 'يجب أن يكون الخاصية :attribute عنوان URL صالح.',
    'uuid' => 'يجب أن يكون الخاصية :attribute رمز UUID صالح.',

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
