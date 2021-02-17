<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-3 gap-4 border-b-2 pb-2">
                        <div class="font-bold text-center">Name</div>
                        <div class="font-bold text-center">Email</div>
                        <div class="font-bold text-center">Type</div>
                    </div>
                    @foreach ($list as $item)
                    <a class="grid grid-cols-3 gap-4 mt-3 cursor-pointer hover:bg-gray-200 p-2" href="/user-show/{{ $item->id }}">
                        <div class="">{{ $item->name }}</div>
                        <div class="">{{ $item->email }}</div>
                        <div class="text-center">{{ ucfirst($item->type) }}</div>
                    </a>
                    @endforeach

                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $list->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
