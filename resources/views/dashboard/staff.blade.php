{{-- top bar figure summary, percentage increase/decrease from previous date --}}
<div class="grid grid-flow-col grid-cols-7 grid-rows-1 gap-1">
    @foreach ($daySummary as $item)
    <div class="bg-green-200 border-5 border-gray rounded p-5 text-center">
        {{ $item }}
        <hr/>
        <div class="">1,213</div>
    </div>
    @endforeach
</div>


{{-- historical chart --}}

{{-- target comparison --}}

