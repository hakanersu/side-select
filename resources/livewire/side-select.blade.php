<div class="flex">
    <div class="flex-1">
        <div class="list bg-white shadow-md rounded-lg border relative">
            <div class="rounded-t-lg overflow-hidden">
                <input wire:model="notSelectedKeyword" type="text" placeholder="{{ __('sideselect::sideselect.search_here') }}" name="left-search" class="px-3 py-2 w-full border-b border-r-0 border-l-0 border-t-0 border-gray-200">
            </div>
            <ul class="p-3  max-h-56 overflow-y-scroll">
                @forelse ($notSelected as $item)
                    <li wire:click="select({{ $item['id'] }})" class="select-none bg-gray-100 hover:bg-blue-500 hover:text-white rounded py-1 px-3 cursor-pointer text-gray-700 mb-1">{{ $item[$label] }}</li>
                @empty
                    <li id="nothing-found" class="select-none bg-gray-100 text-gray-700 rounded py-1 px-3 cursor-pointer mb-1">{{ __('sideselect::sideselect.nothing_found') }}</li>
                @endforelse
            </ul>
            <div class="bg-black text-white flex justify-between rounded-b-lg py-2 px-3 text-sm sticky bottom-0 w-full">
                <span class="cursor-pointer" wire:click="selectAll">{{ __('sideselect::sideselect.select_all') }}</span>
                <span class="bg-blue-600 rounded-full h-4 w-4 flex items-center justify-center text-xs text-white">{{ count($notSelected) }}</span>
            </div>
        </div>
    </div>
    <div class="px-5 flex items-center text-gray-400">
        ‹ ›
    </div>
    <div class="flex-1">
        <div class="list bg-white shadow-md rounded-lg border relative">
            <div class="rounded-t-lg overflow-hidden">
                <input wire:model="selectedKeyword" type="text" placeholder="{{ __('sideselect::sideselect.search_here') }}" name="left-search" class="px-3 py-2 w-full border-b border-r-0 border-l-0 border-t-0 border-gray-200">
            </div>
            <ul class="p-3 max-h-56 overflow-y-scroll">
                @forelse ($selected as $item)
                    @if($item['shown'])
                    <li wire:click="deselect({{ $item['id'] }})" class="select-none bg-blue-500 text-white rounded py-1 px-3 cursor-pointer mb-1">{{ $item[$label] }}</li>
                    @endif
                @empty
                    <li id="nothing-selected" class="select-none bg-gray-100 text-gray-700 rounded py-1 px-3 cursor-pointer mb-1">{{ __('sideselect::sideselect.nothing_selected') }}</li>
                @endforelse
            </ul>
            <div class="bg-black text-white flex justify-between rounded-b-lg py-2 px-3 text-sm sticky bottom-0 w-full">
                <span class="cursor-pointer" wire:click="deselectAll">{{ __('sideselect::sideselect.select_none') }}</span>
                <span class="bg-blue-600 rounded-full h-4 w-4 flex items-center justify-center text-xs text-white">{{ count($selected) }}</span>
            </div>
        </div>
    </div>
    <input type="hidden" name="{{ $name ?? '' }}_selected" value="{{ collect($selected)->map(fn ($item) => $item['id'] )->join(',') }}">
    <input type="hidden" name="{{ $name ?? '' }}_not_selected" value="{{ collect($notSelected)->map(fn ($item) => $item['id'] )->join(',') }}">

</div>
