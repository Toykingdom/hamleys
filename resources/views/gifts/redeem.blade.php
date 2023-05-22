<x-app-layout>
    <div class="mt-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <livewire:redeem-gifts  :customer_code="$customer_code" :user="$user" />
        </div>
    </div>
</x-app-layout>
