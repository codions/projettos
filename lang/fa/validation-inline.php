<?php

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

return [
    'accepted' => 'این مقدار باید پذیرفته شده باشد.',
    'accepted_if' => 'این مقدار باید پذیرفته شود زمانه که :other برابر با :value.',
    'active_url' => 'این مقدار یک آدرس معتبر نیست.',
    'after' => 'این مقدار باید یک تاریخ بعد از :date باشد.',
    'after_or_equal' => 'این مقدار باید یک تاریخ مساوی یا بعد از :date باشد.',
    'alpha' => 'این مقدار تنها میتواند شامل حروف باشد.',
    'alpha_dash' => 'این مقدار تنها میتواند شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num' => 'این مقداز تنها میتواند شامل حروف و اعداد باشد.',
    'array' => 'این مقدار باید یک آرایه باشد.',
    'before' => 'این مقدار باید یک تاریخ قبل از :date باشد.',
    'before_or_equal' => 'این مقدار باید یک تاریخ مساوی یا قبل از :date باشد.',
    'between' => [
        'array' => 'این مقدار باید بین :min و :max گزینه داشته باشد.',
        'file' => 'حجم این فایل باید بین :min و :max کیلوبایت باشد.',
        'numeric' => 'این مقدار باید بین :min و :max باشد.',
        'string' => 'این رشته باید بین :min و :max حرف داشته باشد.',
    ],
    'boolean' => 'این مقدار باید حتما true و یا false باشد.',
    'confirmed' => 'با مقدار تکرار همخوانی ندارد.',
    'current_password' => 'رمز فعلی اشتباه است.',
    'date' => 'این مقدار یک تاریخ معبتر نیست.',
    'date_equals' => 'این مقدار باید یک تاریخ مساوی با :date باشد.',
    'date_format' => 'این مقدار با فرمت :format همخوانی ندارد.',
    'declined' => 'این مقدار قابل پذیرش نیست.',
    'declined_if' => 'این مقدار قابل پذیرش نیست زمانی که :other برابر با :value.',
    'different' => 'این مقدار باید متفاوت از :other باشد.',
    'digits' => 'این مقدار باید :digits رقمی باشد.',
    'digits_between' => 'تعداد ارقام این مقدار باید بین :min و :max باشد.',
    'dimensions' => 'ابعاد این عکس نامعتبر است.',
    'distinct' => 'مقدار این ورودی تکراری است.',
    'email' => 'این مقدار باید یک آدرس ایمیل معتبر باشد.',
    'ends_with' => 'این مقدار باید با یکی از عبارت های روبرو پایان یابد: :values.',
    'enum' => 'مقدار انتخاب شده معتبر نمی باشد.',
    'exists' => 'مقدار انتخابی نا معتبر است.',
    'file' => 'این ورودی باید یک فایل باشد.',
    'filled' => 'این ورودی باید یک مقدار داشته باشد.',
    'gt' => [
        'array' => 'مقدار ورودی باید بیشتر از :value گزینه داشته باشد.',
        'file' => 'حجم فایل ورودی باید بزرگتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید بزرگتر از :value باشد.',
        'string' => 'تعداد حروف رشته ورودی باید بیشتر از :value باشد.',
    ],
    'gte' => [
        'array' => 'مقدار ورودی باید :value گزینه یا بیشتر داشته باشد.',
        'file' => 'حجم فایل ورودی باید بیشتر یا مساوی :value کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید بزرگتر یا مساوی :value باشد.',
        'string' => 'تعداد حروف رشته ورودی باید بیشتر یا مساوی :value باشد.',
    ],
    'image' => 'این مقدار باید یک عکس باشد.',
    'in' => 'مقدار انتخابی نامعتبر است.',
    'in_array' => 'این مقدار در :other موجود نیست.',
    'integer' => 'این مقدار باید یک عدد صحیح باشد.',
    'ip' => 'این مقدار باید یک آدرس IP معتبر باشد.',
    'ipv4' => 'این مقدار باید یک آدرس IPv4 معتبر باشد.',
    'ipv6' => 'این مقدار باید یک آدرس IPv6 معتبر باشد.',
    'json' => 'این مقدار باید یک رشته معتبر JSON باشد.',
    'lt' => [
        'array' => 'مقدار ورودی باید کمتر از :value گزینه داشته باشد.',
        'file' => 'حجم فایل ورودی باید کمتر از :value کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید کمتر از :value باشد.',
        'string' => 'تعداد حروف رشته ورودی باید کمتر از :value باشد.',
    ],
    'lte' => [
        'array' => 'مقدار ورودی باید :value گزینه یا کمتر داشته باشد.',
        'file' => 'حجم فایل ورودی باید کمتر یا مساوی :value کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید کمتر یا مساوی :value باشد.',
        'string' => 'تعداد حروف رشته ورودی باید کمتر یا مساوی :value باشد.',
    ],
    'mac_address' => 'مک آدرس وارد شده معتبر نمی باشد.',
    'max' => [
        'array' => 'مقدار ورودی نباید بیشتر از :max گزینه داشته باشد.',
        'file' => 'حجم فایل ورودی نباید بیشتر از :max کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی نباید بزرگتر از :max باشد.',
        'string' => 'تعداد حروف رشته ورودی نباید بیشتر از :max باشد.',
    ],
    'mimes' => 'این مقدار باید یک فایل از این انواع باشد: :values.',
    'mimetypes' => 'این مقدار باید یک فایل از این انواع باشد: :values.',
    'min' => [
        'array' => 'مقدار ورودی باید حداقل :min گزینه داشته باشد.',
        'file' => 'حجم فایل ورودی باید حداقل :min کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید حداقل :min باشد.',
        'string' => 'رشته ورودی باید حداقل :min حرف داشته باشد.',
    ],
    'multiple_of' => 'مقدار باید مضربی از :value باشد.',
    'not_in' => 'گزینه انتخابی نامعتبر است.',
    'not_regex' => 'این فرمت نامعتبر است.',
    'numeric' => 'این مقدار باید عددی باشد.',
    'password' => 'رمزعبور اشتباه است.',
    'present' => 'این مقدار باید وارد شده باشد.',
    'prohibited' => 'این فیلد ممنوع است.',
    'prohibited_if' => 'این فیلد زمانی که :other برابر با :value باشد ممنوع است.',
    'prohibited_unless' => 'این فیلد ممنوع است مگر اینکه :other شامل :values باشد.',
    'prohibits' => 'فیلد :other هنگام وجود این فیلد ممنوع است.',
    'regex' => 'این فرمت نامعتبر است.',
    'required' => 'این مقدار ضروری است.',
    'required_array_keys' => 'این فیلد باید حاوی ورودی های :values باشد.',
    'required_if' => 'این مقدار ضروری است وقتی که :other برابر :value است.',
    'required_unless' => 'این مقدار ضروری است مگر اینکه :other برابر :values باشد.',
    'required_with' => 'این مقدار ضروری است وقتی که :values وارد شده باشد.',
    'required_with_all' => 'این مقدار ضروری است وقتی که مقادیر :values وارد شده باشند.',
    'required_without' => 'این مقدار ضروری است وقتی که :values وارد نشده باشد.',
    'required_without_all' => 'این مقدار ضروری است وقتی که هیچکدام از :values وارد نشده باشند.',
    'same' => 'مقدار این ورودی باید یکی از مقدار های :other باشد.',
    'size' => [
        'array' => 'مقدار ورودی باید :size گزینه داشته باشد.',
        'file' => 'حجم فایل ورودی باید :size کیلوبایت باشد.',
        'numeric' => 'مقدار ورودی باید :size باشد.',
        'string' => 'طول رشته ورودی باید :size حرف باشد.',
    ],
    'starts_with' => 'این مقدار باید با یکی از گزینه های روبرو شروع شود: :values.',
    'string' => 'این مقدار باید یک رشته باشد.',
    'timezone' => 'این مقدار باید یک منطقه زمانی باشد.',
    'unique' => 'این مقدار قبلا استفاده شده.',
    'uploaded' => 'این ورودی بارگزاری نشد.',
    'url' => 'این فرمت نامعتبر است.',
    'uuid' => 'این مقدار باید یک UUID معتبر باشد.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
];
