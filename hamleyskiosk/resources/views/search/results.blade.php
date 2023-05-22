<x-app-layout>
    <div class="mt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:search-herzblut-lw :term="$term"/>
        </div>
    </div>
    <div class="mt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:adduser-herzblut-lw :user="$user"/>
        </div>
    </div>

</x-app-layout>
