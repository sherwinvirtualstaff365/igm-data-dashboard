<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Entry - Financials') }}
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
                    </div>
                </div>

                <div class="p-6 bg-white">
                    <div class="">
                        <x-label for="funds_transfer_analysis" :value="__('Funds Transfer Analysis')" />
                        <x-input id="funds_transfer_analysis" class="block mt-1 text-center" type="number" name="funds_transfer_analysis" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="new_schedules_added" :value="__('New Schedles Added')" />
                        <x-input id="new_schedules_added" class="block mt-1 text-center" type="number" name="new_schedules_added" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="schedules_moved_down" :value="__('Schedules Moved Down')" />
                        <x-input id="schedules_moved_down" class="block mt-1 text-center" type="number" name="schedules_moved_down" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="schedules_moved_up" :value="__('Schedules Moved Up')" />
                        <x-input id="schedules_moved_up" class="block mt-1 text-center" type="number" name="schedules_moved_up" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="schedules_cancelled" :value="__('Schedules Cancelled')" />
                        <x-input id="schedules_cancelled" class="block mt-1 text-center" type="number" name="schedules_cancelled" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="sns_paids_approved" :value="__('SnS Paids Approved')" />
                        <x-input id="sns_paids_approved" class="block mt-1 text-center" type="number" name="sns_paids_approved" value=""/>
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

            $('input[name=date]').on('change', function() {
                loadData();
            });

        });

        function loadData(params) {
            axios.get('/data-entry/financials/' + $('input[name=date]').val())
                .then(function(res){
                    console.log(res.data);
                    // reset
                    $('input[name=funds_transfer_analysis]').val(0);
                    $('input[name=new_schedules_added]').val(0);
                    $('input[name=schedules_moved_down]').val(0);
                    $('input[name=schedules_moved_up]').val(0);
                    $('input[name=schedules_cancelled]').val(0);
                    $('input[name=sns_paids_approved]').val(0);

                    if (res.data.id!=undefined) {
                        metaData = JSON.parse(res.data.meta_data)
                        $('input[name=funds_transfer_analysis]').val(metaData.funds_transfer_analysis!=undefined ? metaData.funds_transfer_analysis : 0);
                        $('input[name=new_schedules_added]').val(metaData.new_schedules_added!=undefined ? metaData.new_schedules_added : 0);
                        $('input[name=schedules_moved_down]').val(metaData.schedules_moved_down!=undefined ? metaData.schedules_moved_down : 0);
                        $('input[name=schedules_moved_up]').val(metaData.schedules_moved_up!=undefined ? metaData.schedules_moved_up : 0);
                        $('input[name=schedules_cancelled]').val(metaData.schedules_cancelled!=undefined ? metaData.schedules_cancelled : 0);
                        $('input[name=sns_paids_approved]').val(metaData.sns_paids_approved!=undefined ? metaData.sns_paids_approved : 0);
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
        }

        function save(){
            var data = {
                funds_transfer_analysis: $('input[name=funds_transfer_analysis]').val(),
                new_schedules_added: $('input[name=new_schedules_added]').val(),
                schedules_moved_down: $('input[name=schedules_moved_down]').val(),
                schedules_moved_up: $('input[name=schedules_moved_up]').val(),
                schedules_cancelled: $('input[name=schedules_cancelled]').val(),
                sns_paids_approved: $('input[name=sns_paids_approved]').val()
            }
            axios.post('/data-entry/financials/' + $('input[name=date]').val(), data, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},})
                .then(function(res){
                    alert('Entry has been saved');
                })
                .catch(function(error){
                    alert('An error occured while saving entry')
                })
        }
    </script>

</x-app-layout>
