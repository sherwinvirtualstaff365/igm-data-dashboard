<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 content-center bg-white border-b border-gray-200">

                    {{-- @include('dashboard.staff') --}}
                    @if ('manager'==Auth()->user()->type || 'admin'==Auth()->user()->type)
                        <iframe width="1024" height="768" src="https://datastudio.google.com/embed/reporting/aa32561c-24fb-4506-aea9-fe027178159d/page/rXX3B" frameborder="0" style="border:0" allowfullscreen></iframe>
                    @else
                        <iframe width="1024" height="768"
                            src="https://datastudio.google.com/embed/reporting/fff6b4b3-24af-401d-8547-c986b181129b/page/rXX3B?params={{ urlencode(json_encode(['ds0.staff'=>Auth()->user()->name])) }}"
                            frameborder="0" style="border:0" allowfullscreen></iframe>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
