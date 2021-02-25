<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Entry - Leads') }}
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
                        <x-label for="new_leads_1300" :value="__('New Leads (1300 Number)')" />
                        <x-input id="new_leads_1300" class="block mt-1 text-center" type="number" name="new_leads_1300" value=""/>
                    </div>
                    <div class="">
                        <x-label for="new_leads_website" :value="__('New Leads (Website)')" />
                        <x-input id="new_leads_website" class="block mt-1 text-center" type="number" name="new_leads_website" value=""/>
                    </div>
                    <div class="">
                        <x-label for="new_leads_referral" :value="__('New Leads (Referral)')" />
                        <x-input id="new_leads_referral" class="block mt-1 text-center" type="number" name="new_leads_referral" value=""/>
                    </div>
                    <div class="">
                        <x-label for="new_leads_ppc" :value="__('New Leads (Pay Pay Click)')" />
                        <x-input id="new_leads_ppc" class="block mt-1 text-center" type="number" name="new_leads_ppc" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="ballpark" :value="__('New Leads moved to Ballpark')" />
                        <x-input id="ballpark" class="block mt-1 text-center" type="number" name="ballpark" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="scope" :value="__('New Leads moved to Scope')" />
                        <x-input id="scope" class="block mt-1 text-center" type="number" name="scope" value=""/>
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
            axios.get('/data-entry/leads/' + $('input[name=date]').val())
                .then(function(res){
                    console.log(res.data);
                    // reset
                    $('input[name=new_leads_1300]').val(0);
                    $('input[name=new_leads_website]').val(0);
                    $('input[name=new_leads_referral]').val(0);
                    $('input[name=new_leads_ppc]').val(0);
                    $('input[name=ballpark]').val(0);
                    $('input[name=scope]').val(0);

                    if (res.data.id!=undefined) {
                        metaData = JSON.parse(res.data.meta_data)
                        $('input[name=new_leads_1300]').val(metaData.new_leads_1300!=undefined ? metaData.new_leads_1300 : 0);
                        $('input[name=new_leads_website]').val(metaData.new_leads_website!=undefined ? metaData.new_leads_website : 0);
                        $('input[name=new_leads_referral]').val(metaData.new_leads_referral!=undefined ? metaData.new_leads_referral : 0);
                        $('input[name=new_leads_ppc]').val(metaData.new_leads_ppc!=undefined ? metaData.new_leads_ppc : 0);
                        $('input[name=ballpark]').val(metaData.ballpark!=undefined ? metaData.ballpark : 0);
                        $('input[name=scope]').val(metaData.scope!=undefined ? metaData.scope : 0);
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
        }

        function save(){
            var data = {
                new_leads_1300: $('input[name=new_leads_1300]').val(),
                new_leads_website: $('input[name=new_leads_website]').val(),
                new_leads_referral: $('input[name=new_leads_referral]').val(),
                new_leads_ppc: $('input[name=new_leads_ppc]').val(),
                ballpark: $('input[name=ballpark]').val(),
                scope: $('input[name=scope]').val(),
            }
            axios.post('/data-entry/leads/' + $('input[name=date]').val(), data, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},})
                .then(function(res){
                    alert('Entry has been saved');
                })
                .catch(function(error){
                    alert('An error occured while saving entry')
                })
        }
    </script>

</x-app-layout>
