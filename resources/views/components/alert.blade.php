@props([
    'title', 'message', 'type'
])

<div class="absolute top-1 w-11/12 sm:w-80 right-4 px-4 py-4 rounded-md bg-white border shadow-md sm:p-6 sm:pb-4 {{ $type }}">
        <div class="flex items-start">
            <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 bg-red-100 rounded-full sm:h-7 sm:w-7">
                <svg class="w-3 h-3 text-red-600 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
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
