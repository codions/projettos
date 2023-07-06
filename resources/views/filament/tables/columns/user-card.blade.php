@php
	$user = $getRecord();
    if (isset($user->user)) {
        $user = $user->user;
    }
@endphp

<div class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
    <img class="w-10 h-10 rounded-full" src="{{ $user->profile_picture }}" alt="{{ $user->name }}">
    <div class="pl-3">
        <div class="text-base font-semibold">{{ $user->name }}</div>
        <div class="font-normal text-gray-500">{{ $user->email }}</div>
    </div>  
</div>