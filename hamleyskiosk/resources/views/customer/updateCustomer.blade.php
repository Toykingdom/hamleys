<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           @livewire('update-customer', ['account_number' => $customer_number])
        </div>
    </div>
</x-app-layout>