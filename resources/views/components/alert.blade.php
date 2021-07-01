@props([
    'title', 'message', 'type'
])
<div
x-data="{ showAlert: true }"
x-show="showAlert"
class="absolute top-1 w-11/12 sm:w-80 right-4 px-4 py-2 rounded-md bg-white border border-gray-light shadow-sm sm:p-6 sm:pb-4 {{ $type }}">
    <div class="relative flex items-start">
        <span @click="showAlert = false" class="absolute text-gray-400 cursor-pointer -top-2 -right-2 hover:text-red-dark">
            <x-heroicon-s-x-circle class="w-5 h-5 " />
        </span>
        <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 {{ ($type == 'success') ? 'bg-blue-100' : (($type == 'error') ? 'bg-red-100' : 'bg-yellow-100')  }}  rounded-full sm:h-7 sm:w-7">
            @if($type == 'success')
            <x-heroicon-s-check-circle class="w-4 h-4 text-blue-600 sm:h-5 sm:w-5"/>
            @elseif($type == 'error')
            <x-heroicon-s-x-circle class="w-4 h-4 text-red-600 sm:h-5 sm:w-5"/>
            @else
            <x-heroicon-s-exclamation class="w-4 h-4 text-yellow-600 sm:h-5 sm:w-5"/>
            @endif
        </div>
        <div class="ml-4 text-left">
            <h3 class="text-sm font-bold leading-6 text-gray-dark" id="modal-title">
            {{ $title }}
            </h3>
            <div class="mt-2">
                <p class="text-xs font-normal text-gray">{{ $message}}</p>
            </div>
        </div>
    </div>
</div>
