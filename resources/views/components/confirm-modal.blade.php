@props([
    'title'
])
<x-modal {{ $attributes }}>
    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          {{ $icon }}

          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-sm font-medium leading-6 text-gray-900 md:text-lg" id="modal-title">
              {{ $title }}
            </h3>
            <div class="mt-2">
                {{ $content}}
            </div>
          </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
        {{ $footer }}
    </div>
</x-modal>
