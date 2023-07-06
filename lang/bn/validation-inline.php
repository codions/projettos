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
    'accepted' => 'এই মাঠ গ্রহণ করা আবশ্যক',
    'accepted_if' => 'এই ফিল্ডটি তখন গ্রগণ করা হবে যখন :other হবে :value',
    'active_url' => 'এটি একটি বৈধ ইউআরএল নয়',
    'after' => 'এর পরে একটি তারিখ হতে হবে :date',
    'after_or_equal' => 'এর পরে বা সমান একটি তারিখ হতে হবে :date',
    'alpha' => 'এই ক্ষেত্রটি শুধুমাত্র অক্ষর থাকতে পারে',
    'alpha_dash' => 'এই ক্ষেত্রটি শুধুমাত্র অক্ষর, সংখ্যা, ড্যাশ এবং আন্ডারস্কোর থাকতে পারে',
    'alpha_num' => 'এই ক্ষেত্রটি শুধুমাত্র অক্ষর এবং নম্বর থাকতে পারে.',
    'array' => 'এই ক্ষেত্রটি একটি অ্যারে হতে হবে.',
    'before' => 'এই :date আগে একটি তারিখ হতে হবে.',
    'before_or_equal' => 'এই একটি তারিখ আগে বা সমান হতে হবে :date.',
    'between' => [
        'array' => 'এই কনটেন্টে অবশ্যই :min থেকে :max টি আইটেম থাকতে হবে',
        'file' => 'এই ফাইল অবশ্যই :min থেকে :max কিলোবাইটের মধ্যে থাকতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :min থেকে :max এর মধ্যে থাকতে হবে',
        'string' => 'এটি :min থেকে :max ক্যারেক্টারের মধ্যে থাকতে হবে',
    ],
    'boolean' => 'এই ক্ষেত্রটি সত্য বা মিথ্যা হতে হবে.',
    'confirmed' => 'নিশ্চিতকরণ সাথে মেলে না',
    'current_password' => 'এই পাসওয়ার্ডটি সঠিক নয়',
    'date' => 'এটি একটি বৈধ তারিখ নয়.',
    'date_equals' => 'এই সমান একটি তারিখ হতে হবে :date.',
    'date_format' => 'এই বিন্যাসে সাথে মেলে না :format.',
    'declined' => 'এই ভ্যালু অবশ্যই বাতিল করা হবে',
    'declined_if' => 'এই ভ্যালুটি বাতিল হবে যদি :other হয় :value',
    'different' => 'এই মান থেকে আলাদা হতে হবে :other.',
    'digits' => 'এই হতে হবে :digits সংখ্যা.',
    'digits_between' => 'এই মধ্যে হতে হবে :min এবং :max সংখ্যা.',
    'dimensions' => 'এই ছবিটি অবৈধ মাত্রা আছে.',
    'distinct' => 'এই ক্ষেত্রটি একটি প্রতিলিপি মান আছে.',
    'email' => 'এটি একটি বৈধ ইমেইল ঠিকানা হতে হবে.',
    'ends_with' => 'এই নিম্নলিখিত এক সঙ্গে শেষ করতে হবে: :values.',
    'enum' => 'নির্বাচিত মানটি অবৈধ ৷',
    'exists' => 'নির্বাচিত মান অকার্যকর',
    'file' => 'বিষয়বস্তু একটি ফাইল হতে হবে.',
    'filled' => 'এই ক্ষেত্রটি একটি মান থাকতে হবে.',
    'gt' => [
        'array' => 'এই কনটেন্টে অবশ্যই :value এর বেশি আইটেম থাকতে হবে',
        'file' => 'এই ফাইল অবশ্যই :value কিলোবাইটের বেশি হতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :value এর বেশি হতে হবে',
        'string' => 'এটি অবশ্যই :value ক্যারেক্টারের বেশি হতে হবে',
    ],
    'gte' => [
        'array' => 'এই কনটেন্টে অবশ্যই :value বা এর বেশি আইটেম থাকতে হবে',
        'file' => 'এই ফাইল অবশ্যই :value কিলোবাইটের সমান বা বেশি হতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :value এর সমান বা বেশি হতে হবে',
        'string' => 'এটি অবশ্যই :value ক্যারেক্টারের সমান বা বেশি হতে হবে',
    ],
    'image' => 'এটি একটি চিত্র হতে হবে.',
    'in' => 'নির্বাচিত মান অকার্যকর',
    'in_array' => 'এই মান বিদ্যমান নেই :other.',
    'integer' => 'এটি একটি পূর্ণসংখ্যা হতে হবে.',
    'ip' => 'এটি একটি বৈধ আইপি ঠিকানা হতে হবে.',
    'ipv4' => 'এটি একটি বৈধ আইপিভি 4 ঠিকানা হতে হবে.',
    'ipv6' => 'এটি একটি বৈধ আইপিভি6 ঠিকানা হতে হবে.',
    'json' => 'এটি একটি বৈধ পলসন স্ট্রিং হতে হবে.',
    'lt' => [
        'array' => 'এই কনটেন্টে অবশ্যই :value এর কম আইটেম থাকতে হবে',
        'file' => 'এই ফাইল অবশ্যই :value কিলোবাইটের কম হতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :value এর কম হতে হবে',
        'string' => 'এটি অবশ্যই :value ক্যারেক্টারের কম হতে হবে',
    ],
    'lte' => [
        'array' => 'এই কনটেন্টে অবশ্যই :value বা এর কম আইটেম থাকতে হবে',
        'file' => 'এই ফাইল অবশ্যই :value কিলোবাইটের সমান বা কম হতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :value এর সমান বা কম হতে হবে',
        'string' => 'এটি অবশ্যই :value ক্যারেক্টারের সমান বা কম হতে হবে',
    ],
    'mac_address' => 'মান অবশ্যই একটি বৈধ MAC ঠিকানা হতে হবে ।',
    'max' => [
        'array' => 'এই কনটেন্টে অবশ্যই :max এর বেশি আইটেম থাকতে পারবে না',
        'file' => 'এই ফাইল অবশ্যই :max কিলোবাইটের বেশি হতে পারবে না',
        'numeric' => 'এর ভ্যালু অবশ্যই :max এর বেশি হতে পারবে না',
        'string' => 'এটি অবশ্যই :max ক্যারেক্টারের বেশি হতে পারবে না',
    ],
    'mimes' => 'এই ধরনের একটি ফাইল হতে হবে: :values.',
    'mimetypes' => 'এই ধরনের একটি ফাইল হতে হবে: :values.',
    'min' => [
        'array' => 'এই কনটেন্টে অবশ্যই :min এর কম আইটেম থাকতে পারবে না',
        'file' => 'এই ফাইল অবশ্যই :min কিলোবাইটের কম হতে পারবে না',
        'numeric' => 'এর ভ্যালু অবশ্যই :min এর কম হতে পারবে না',
        'string' => 'এটি অবশ্যই :min ক্যারেক্টারের কম হতে পারবে না',
    ],
    'multiple_of' => 'মূল্য :value একাধিক হতে হবে',
    'not_in' => 'নির্বাচিত মান অকার্যকর',
    'not_regex' => 'এই বিন্যাসটি অবৈধ.',
    'numeric' => 'এটা নিশ্চয়ই কোন নাম্বার.',
    'password' => 'পাসওয়ার্ড ভুল.',
    'present' => 'এই ক্ষেত্রটি উপস্থিত থাকতে হবে.',
    'prohibited' => 'এই ক্ষেত্র নিষিদ্ধ.',
    'prohibited_if' => 'এই ক্ষেত্রটি :other :value যখন নিষিদ্ধ.',
    'prohibited_unless' => 'এই ক্ষেত্রটি নিষিদ্ধ, যদি না :other সালে হয় :values.',
    'prohibits' => 'এই ফিল্ডটি বাতিল :other যখন থাকবে',
    'regex' => 'এই বিন্যাসটি অবৈধ.',
    'required' => 'এই ক্ষেত্রটি প্রয়োজন.',
    'required_array_keys' => 'এই ক্ষেত্রটিতে অবশ্যই :values এর জন্য এন্ট্রি থাকতে হবে',
    'required_if' => 'এই ক্ষেত্র প্রয়োজন বোধ করা হয় যখন :other হয় :value.',
    'required_unless' => 'এই ক্ষেত্র প্রয়োজন বোধ করা হয়, যদি না :other হয়, :values.',
    'required_with' => ':values উপস্থিত থাকলে এই ক্ষেত্র প্রয়োজন বোধ করা হয়.',
    'required_with_all' => ':values উপস্থিত হয় যখন এই ক্ষেত্র প্রয়োজন বোধ করা হয়.',
    'required_without' => ':values উপস্থিত না হলে এই ক্ষেত্র প্রয়োজন বোধ করা হয়.',
    'required_without_all' => 'কেউ যখন এই ক্ষেত্র প্রয়োজন বোধ করা হয় :values উপস্থিত.',
    'same' => 'এই ক্ষেত্রের মান :other থেকে এক মেলানো.',
    'size' => [
        'array' => 'এই কনটেন্টে অবশ্যই :size আইটেম থাকবে হবে',
        'file' => 'এই ফাইল অবশ্যই :size কিলোবাইটের হতে হবে',
        'numeric' => 'এর ভ্যালু অবশ্যই :size হতে হবে',
        'string' => 'এটি অবশ্যই :size ক্যারেক্টারের হতে হবে',
    ],
    'starts_with' => 'এই নিম্নলিখিত এক সঙ্গে শুরু করতে হবে: :values.',
    'string' => 'এটি একটি স্ট্রিং হতে হবে.',
    'timezone' => 'এটি একটি বৈধ জোন হতে হবে.',
    'unique' => 'এটা ইতিমধ্যেই নেওয়া হয়েছে.',
    'uploaded' => 'এই আপলোড করতে ব্যর্থ হয়েছে.',
    'url' => 'এই বিন্যাসটি অবৈধ.',
    'uuid' => 'এটি একটি বৈধ ইউআইডি হতে হবে.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
];
