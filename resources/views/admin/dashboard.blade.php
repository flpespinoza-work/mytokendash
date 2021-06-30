<x-admin-layout>
    <x-slot name="back_button">
        <x-back-link route="{{ url()->previous() }}"/>
    </x-slot>
    <x-slot name="title">Dashboard</x-slot>
    <div>
        <livewire:dashboard/>
    </div>
</x-admin-layout>
