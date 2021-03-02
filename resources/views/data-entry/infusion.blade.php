<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Entry - Infusion') }}
        </h2>
    </x-slot>

    @include('layouts.error-top-bar')

    <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white">
                    <div class="grid grid-cols-2 gap-4 border-b-2 pb-2">
                        <div class="">
                            <x-label for="date" :value="__('Date')" />
                            <x-input id="date" class="block mt-1 w-full" type="date" name="date" value="{{ $date }}" required autofocus />
                        </div>
                        <div class="">
                            <x-label for="staff" :value="__('Staff')" />
                            <x-select name="staff" id="staff" class="block mt-1 w-full">
                                @foreach (\App\Models\User::where('type','staff')->orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white">
                    <div class="">
                        <x-label for="calls_dialed" :value="__('Calls Dialed')" />
                        <x-input id="calls_dialed" class="block mt-1 text-center" type="number" name="calls_dialed" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="conversations" :value="__('Conversations')" />
                        <x-input id="conversations" class="block mt-1 text-center" type="number" name="conversations" value=""/>
                    </div>
                </div>

                <div class="p-6 bg-white border-t-2 border-gray-200 text-right">
                    <x-button class="bg-green-500 hover:bg-green-700" onclick="save()">{{ __('Save') }}</x-button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            loadData();

            $('input[name=date], select[name=staff]').on('change', function() {
                loadData();
            });

        });

        function loadData(params) {
            axios.get('/data-entry/infusion/' + $('input[name=date]').val() + '/' + $('select[name=staff]').val())
                .then(function(res){
                    console.log(res.data);
                    // reset
                    $('input[name=calls_dialed]').val(0);
                    $('input[name=conversations]').val(0);

                    if (res.data.id!=undefined) {
                        metaData = JSON.parse(res.data.meta_data)
                        $('input[name=calls_dialed]').val(metaData.calls_dialed!=undefined ? metaData.calls_dialed : 0);
                        $('input[name=conversations]').val(metaData.conversations!=undefined ? metaData.conversations : 0);
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
        }

        function save(){
            var data = {
                staff: $('input[name=staff]').val(),
                calls_dialed: $('input[name=calls_dialed]').val(),
                conversations: $('input[name=conversations]').val(),
            }
            axios.post('/data-entry/infusion/' + $('input[name=date]').val() + '/' + $('select[name=staff]').val(), data, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},})
                .then(function(res){
                    alert('Entry has been saved');
                })
                .catch(function(error){
                    alert('An error occured while saving entry')
                })
        }
    </script>

</x-app-layout>
