<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center bg-white border-b border-gray-200">

                    {{-- @include('dashboard.staff') --}}

                    <iframe width="1024" height="768" src="https://datastudio.google.com/embed/reporting/42b8593c-91af-4dfb-ba43-400183196c09/page/CxK3B" frameborder="0" style="border:0" allowfullscreen></iframe>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
