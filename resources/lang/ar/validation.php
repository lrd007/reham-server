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

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'يجب أن تكون :attribute تاريخًا بعد :date أو مساويًا له.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => ' :attribute أبعاد الصورة غير صالحة',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute يجب أن يكون رقمًا',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute يجب ألا يكون أكبر من:max',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute لا بد أن يكون على الأقل:min',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'يجب أن تكون :attribute على الأقل:min حرفًا.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => ':attribute التنسيق غير صالح',
    'numeric' => 'يجب أن تكون :attribute رقمًا.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute التنسيق غير صالح',
    'required' => ':attribute الحقل مطلوب',
    'required_if' => ':attribute الحقل مطلوب عندما:other هو :value',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => ':attribute الحقل مطلوب عندما:values حاضر',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'مطلوب حقل :attribute في حالة عدم وجود :values.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'تم أخذ :attribute بالفعل.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

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

    'attributes' => [
        "email" => "بريد الكتروني",
        "password" => "كلمه السر",
        "coupon" => "قسيمة", 
        "thumbnail" => "ظفري",
        "contact" => "اتصل",
        "name" => "اسم",
        "mobile" => "التليفون المحمول",
        "relationship" => "صلة",
        "old_thumbnail" => "الصورة المصغرة القديمة",
        "start_date" => "تاريخ البدء",
        "end_date" => "تاريخ الانتهاء",
        "fee" => "مصاريف",
        "sale_fee" => "رسوم البيع",
        "video" => "فيديو",
        "course" => "مسار",
        "chapter" => "الفصل",
        "duration" => "المدة الزمنية",
        "name_en" => "الاسم EN",
        "name_ar" => "اسم AR",
        "title_ar" => "العنوان AR",
        "title_en" => "العنوان EN",
        "title" => "العنوان",
        "message" => "رسالة",
        "answer_ar" => "إجابه AR",
        "answer_en" => "إجابه EN",
        "question_ar" => "سؤال AR",
        "question_en" => "سؤال EN",
        "tag" => "بطاقة شعار",
        "embeded_code" => "رمز مضمن",
        "vimeo_url" => "رابط فيميو",
        "vimeo" => "فيميو",
        "program" => "برنامج",
        "old_receipt" => "الإيصال القديم",
        "receipt" => "الإيصال",
        "first_name" => "الاسم الاول",
        "last_name" => "الاسم اللقب",
        "mother_last_name" => "اسم الأم الأخير",
        "current-password" => "كلمة المرور الحالية",
        "new-password" => "كلمة المرور الجديدة",
        "applicant_id" => "طالب وظيفة",
        "type" => "يكتب",
        "grade" => "المرتبة",
        "branch" => "فرع",
        "amount" => "مقدار",
        "image" => "صورة",
        "section_title_en" => "عنوان القسم en",
        "section_title_ar" => "عنوان القسم ar",
        "current_password" => "كلمة المرور الحالية"
    ],

    'values' => [
        'type' => [
            "video" => "فيديو",
            "vimeo" => "فيميو",
         ],        
    ],

];
