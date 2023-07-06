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
    'accepted' => ':attribute تسلیم کرنا لازمی ہے۔',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => ':attribute قابلِ قبول یو آر ایل نہیں ہے۔',
    'after' => ':attribute لازماً :date کے بعد کی کوئی تاریخ ہو۔',
    'after_or_equal' => 'اس :attribute ہونا ضروری ہے ، ایک تاریخ کے بعد یا اس کے برابر :date.',
    'alpha' => ':attribute صرف حروفِ تہجی پر مشتمل ہو سکتا ہے۔',
    'alpha_dash' => ':attribute صرف حروفِ تہجی، اعداد، ڈیشِز پر مشتمل ہو سکتا ہے۔',
    'alpha_num' => ':attribute میں صرف حروفِ تہجی و اعداد شامل ہو سکتے ہیں۔',
    'array' => ':attribute لازماً کسی رینج پر مشتمل ہو۔',
    'before' => ':attribute لازماً :date سے پہلے کی کوئی تاریخ ہو۔',
    'before_or_equal' => 'اس :attribute ہونا ضروری ہے ایک تاریخ سے پہلے یا اس کے برابر :date.',
    'between' => [
        'array' => ':attribute لازماً :min اور :max آئٹمز کے درمیان ہو۔',
        'file' => ':attribute لازماً :min اور :max کلو بائٹس کے درمیان ہو۔',
        'numeric' => ':attribute لازماً :min اور :max کے درمیان ہو۔',
        'string' => ':attribute لازماً :min اور :max کریکٹرز کے درمیان ہو۔',
    ],
    'boolean' => ':attribute لازماً درست یا غلط ہونا چاہیے۔',
    'confirmed' => ':attribute تصدیق سے مطابقت نہیں رکھتا۔',
    'current_password' => 'The password is incorrect.',
    'date' => ':attribute قابلِ قبول تاریخ نہیں ہے۔',
    'date_equals' => 'اس :attribute ہونا ضروری ہے ، ایک تاریخ کے لئے برابر :date.',
    'date_format' => ':attribute فارمیٹ :format کے مطابق نہیں ہے۔',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => ':attribute اور :other لازماً مختلف ہوں۔',
    'digits' => ':attribute لازماً :digits اعداد ہوں۔',
    'digits_between' => ':attribute لازماً :min اور :max اعداد کے درمیان ہو۔',
    'dimensions' => 'اس کے :attribute ہے باطل کی تصویر کے طول و عرض.',
    'distinct' => ':attribute کی دہری ویلیو ہے۔',
    'email' => ':attribute لازماً قابلِ قبول ای میل ہو۔',
    'ends_with' => 'اس :attribute ختم کرنا ضروری ہے کے ساتھ مندرجہ ذیل میں سے ایک: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'منتخب :attribute درست نہیں ہے۔',
    'file' => 'اس :attribute ہونا ضروری ہے ایک فائل.',
    'filled' => ':attribute کو بھرنا ضروری ہے۔',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
    ],
    'image' => ':attribute لازماً کوئی تصویر ہو۔',
    'in' => 'منتخب :attribute قابلِ قبول نہیں ہے۔',
    'in_array' => ':attribute فیلڈ :other میں موجود نہیں ہے۔',
    'integer' => ':attribute لازماً کوئی عدد ہو۔',
    'ip' => ':attribute لازماً قابلِ قبول آئی پی پتہ ہو۔',
    'ipv4' => 'اس :attribute ہونا ضروری ہے ایک درست IPv4 ایڈریس.',
    'ipv6' => 'اس :attribute ہونا ضروری ہے ایک درست IPv6 ایڈریس.',
    'json' => ':attribute لازماً قابلِ قبول JSON سٹرِنگ ہو۔',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal :value.',
        'string' => 'The :attribute must be less than or equal :value characters.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => ':attribute میں :max سے زیادہ آئٹمز نہیں ہو سکتیں۔',
        'file' => ':attribute کو :max کلو بائٹس سے زیادہ نہیں ہونا چاہیے۔',
        'numeric' => ':attribute کو :max سے بڑا نہیں ہونا چاہیے۔',
        'string' => ':attribute کو :max کریکٹرز سے زیادہ نہیں ہونا چاہیے۔',
    ],
    'mimes' => ':attribute لازماً :type :values قسم کی فائل ہو۔',
    'mimetypes' => 'اس :attribute ہونا ضروری ہے ایک فائل کی قسم: :values.',
    'min' => [
        'array' => ':attribute میں لازماً کم از کم :min آئٹمز ہوں۔',
        'file' => ':attribute لازماً کم از کم :min کلو بائٹس کی ہو۔',
        'numeric' => ':attribute لازماً کم از کم :min ہو۔',
        'string' => ':attribute لازماً کم از کم :min کریکٹرز طویل ہو۔',
    ],
    'multiple_of' => 'اس :attribute ہونا ضروری ہے ایک سے زیادہ کے :value',
    'not_in' => 'منتخب :attribute قابلِ قبول نہیں ہے۔',
    'not_regex' => 'اس :attribute شکل باطل ہے.',
    'numeric' => ':attribute لازماً کوئی عدد ہو۔',
    'password' => 'پاس ورڈ غلط ہے.',
    'present' => ':attribute فیلڈ موجود ہونا ضروری ہے۔',
    'prohibited' => 'اس :attribute میدان ممنوع ہے.',
    'prohibited_if' => 'اس :attribute میدان ممنوع ہے جب :other ہے :value.',
    'prohibited_unless' => 'اس :attribute میدان ممنوع ہے جب تک کہ :other میں ہے :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute قابلِ قبول فارمیٹ میں نہیں ہے۔',
    'required' => ':attribute فیلڈ درکار ہے۔',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => ':attribute درکار ہے اگر :other کی ویلیو :value ہو۔',
    'required_unless' => 'جب تک :other :values میں نہ ہو تو :attribute فیلڈ درکار ہے۔',
    'required_with' => ':attribute فیلڈ درکار ہے اگر :values موجود ہوں۔',
    'required_with_all' => ':attribute فیلڈ درکار ہے اگر :values موجود ہوں۔',
    'required_without' => ':attribute درکار ہے جب :values موجود ہو۔',
    'required_without_all' => ':attribute فیلڈ درکار ہے جب :values میں سے کوئی بھی موجود نہ ہو۔',
    'same' => ':attribute اور :other لازماً ایک دوسرے سے مماثل ہوں۔',
    'size' => [
        'array' => ':attribute میں لازماً :size آئٹمز شامل ہوں۔',
        'file' => ':attribute کا سائز لازماً :size کلو بائٹس ہو۔',
        'numeric' => ':attribute لازماً :size ہوں۔',
        'string' => ':attribute لازماً :size کریکٹرز پر مشتمل ہو۔',
    ],
    'starts_with' => 'اس :attribute کے ساتھ شروع ہونا چاہئے مندرجہ ذیل میں سے ایک: :values.',
    'string' => ':attribute لازماً کوئی سٹرنگ ہو۔',
    'timezone' => ':attribute لازماً کوئی قابلِ قبول خطۂِ وقت ہو۔',
    'unique' => ':attribute کو پہلے ہی کسی نے حاصل کر لیا ہے۔',
    'uploaded' => 'اس :attribute ناکام اپ لوڈ کرنے کے لئے.',
    'url' => ':attribute فارمیٹ قابلِ قبول نہیں ہے۔',
    'uuid' => 'اس :attribute ہونا ضروری ہے ایک درست UUID.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
];
