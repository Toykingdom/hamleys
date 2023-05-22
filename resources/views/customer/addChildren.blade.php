<x-app-layout>
    <div class="mt-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <livewire:user-add-child  :customer_code="$user_details" />
        </div>
    </div>
</x-app-layout>
