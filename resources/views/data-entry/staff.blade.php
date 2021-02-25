<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Entry') }}
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
                            <x-label for="quarter" :value="__('Quarter')" />
                            <x-select name="quarter" id="quarter" class="block mt-1 w-full">
                                @php
                                    $list = ['11:00'=>'8:45 am - 11 am',
                                             '13:00'=>'11:15 am - 1 pm',
                                             '15:30'=>'2pm - 3:30 pm',
                                             '17:30'=>'3:45 pm - 5:30 pm'];
                                @endphp
                                @foreach ($list as $key=>$label)
                                <option value="{{ $key }}" @if ($quarter==$key) selected @endif>{{ $label }}</option>
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
                    <div class="mt-2">
                        <x-label for="rating_questions_asked" :value="__('Rating Questions Asked')" />
                        <x-input id="rating_questions_asked" class="block mt-1 text-center" type="number" name="rating_questions_asked" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="dollars_taken" :value="__('Dollars Taken')" />
                        <x-input id="dollars_taken" class="block mt-1 text-center" type="number" name="dollars_taken" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="units_sold" :value="__('Units Sold')" />
                        <x-input id="units_sold" class="block mt-1 text-center" type="number" name="units_sold" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="google_uploads" :value="__('Google Uploads')" />
                        <x-input id="google_uploads" class="block mt-1 text-center" type="number" name="google_uploads" value=""/>
                    </div>
                    <div class="mt-2">
                        <x-label for="product_review_uploads" :value="__('Product Review Uploads')" />
                        <x-input id="product_review_uploads" class="block mt-1 text-center" type="number" name="product_review_uploads" value=""/>
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

            $('select[name=quarter]').on('change', function() {
                loadData();
            });

        });

        function loadData(params) {
            axios.get('/data-entry/staff/' + $('input[name=date]').val() + '/' + $('select[name=quarter]').val())
                .then(function(res){
                    console.log(res.data);
                    // reset
                    $('input[name=calls_dialed]').val(0);
                    $('input[name=conversations]').val(0);
                    $('input[name=rating_questions_asked]').val(0);
                    $('input[name=dollars_taken]').val(0);
                    $('input[name=units_sold]').val(0);
                    $('input[name=google_uploads]').val(0);
                    $('input[name=product_review_uploads]').val(0);

                    if (res.data.id!=undefined) {
                        metaData = JSON.parse(res.data.meta_data)
                        $('input[name=calls_dialed]').val(metaData.calls_dialed!=undefined ? metaData.calls_dialed : 0);
                        $('input[name=conversations]').val(metaData.conversations!=undefined ? metaData.conversations : 0);
                        $('input[name=rating_questions_asked]').val(metaData.rating_questions_asked!=undefined ? metaData.rating_questions_asked : 0);
                        $('input[name=dollars_taken]').val(metaData.dollars_taken!=undefined ? metaData.dollars_taken : 0);
                        $('input[name=units_sold]').val(metaData.units_sold!=undefined ? metaData.units_sold : 0);
                        $('input[name=google_uploads]').val(metaData.google_uploads!=undefined ? metaData.google_uploads : 0);
                        $('input[name=product_review_uploads]').val(metaData.product_review_uploads!=undefined ? metaData.product_review_uploads : 0);
                    }
                })
                .catch(function(error){
                    console.error(error);
                });
        }

        function save(){
            var data = {
                calls_dialed: $('input[name=calls_dialed]').val(),
                conversations: $('input[name=conversations]').val(),
                rating_questions_asked: $('input[name=rating_questions_asked]').val(),
                dollars_taken: $('input[name=dollars_taken]').val(),
                units_sold: $('input[name=units_sold]').val(),
                google_uploads: $('input[name=google_uploads]').val(),
                product_review_uploads: $('input[name=product_review_uploads]').val(),
            }
            axios.post('/data-entry/staff/' + $('input[name=date]').val() + '/' + $('select[name=quarter]').val(), data, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},})
                .then(function(res){
                    alert('Entry has been saved');
                })
                .catch(function(error){
                    alert('An error occured while saving entry')
                })
        }
    </script>

</x-app-layout>
