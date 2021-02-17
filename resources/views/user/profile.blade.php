<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
        <p class="font-bold">Be Warned</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
    @endif

    <form method="POST">
    @csrf
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" required autofocus />
                    </div>
                    <div class="mt-5">
                        <x-label for="email" :value="__('Email')" />
                        <x-input disabled id="email" class="block mt-1 w-full bg-gray-100" type="email" name="email" value="{{ $user->email }}" required />
                    </div>
                    <div class="mt-5">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="text" name="password" value="" />
                        <x-label class="mt-1 italic color-gray-500">Leave blank to retain old password</x-label>
                    </div>
                </div>

                <div class="p-6 bg-white border-b border-gray-200 text-right">
                    <x-button class="bg-green-500 hover:bg-green-700" onclick="form().submit()">{{ __('Update') }}</x-button>
                </div>

            </div>
        </div>
    </div>
    </form>

</x-app-layout>
