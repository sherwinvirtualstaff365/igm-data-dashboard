<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    @include('layouts.error-top-bar')

    <form method="POST" action="/user-save" >
    @csrf
    <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
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
                        @if ($user)
                            <x-input disabled value="{{ $user->email }}" id="email" type="email" class="block mt-1 w-full bg-gray-100" />
                        @else
                            <x-input required value="" id="email" name="email" type="email" class="block mt-1 w-full" />
                        @endif
                    </div>
                    <div class="mt-5">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="text" name="password" value="" />
                        @if ($user)
                        <x-label class="mt-1 italic color-gray-500">Leave blank to retain old password</x-label>
                        @endif
                    </div>
                    <div class="mt-5">
                        <x-label for='type'>{{ __('Type') }}</x-label>
                        <x-select name="type" id="type" class="block mt-1 w-full">
                            @foreach (['admin', 'manager', 'staff'] as $i)
                            <option value="{{ $i }}" @if ($user->type==$i) selected @endif>{{ ucfirst($i) }}</option>
                            @endforeach
                        </x-select>
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
