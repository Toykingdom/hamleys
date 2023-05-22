<div>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
            @apply: right-0 border-green-400;
            right: 0;
            border-color: #68D391;
        }
        .toggle-checkbox:checked + .toggle-label {
            @apply: bg-green-400;
            background-color: #68D391;
        }
    </style>
    <div class="flex justify-left pt-8 sm:pt-0">
        <h1 class="text-3xl font-semibold">Customer Details</h1>
    </div>
    <!-- Card -->
    <table class="mt-4 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Code
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Full Name
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Mobile Number
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Email
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Actions
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 border-collapse">
            <tr>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{$customer_code}}
                </td>
                <td class="px-3 py-2">
                    {{ ucwords(strtolower($customer['first_name'])) }} {{ ucwords(strtolower($customer['last_name'])) }}
                </td>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{$customer['mobile_number']}}
                </td>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{ strtolower($customer['email']) }}
                </td>
                <td class="px-2 py-2 whitespace-nowrap text-left text-sm font-small">
                    <a href="{{route('print_cards', ['customer_code' => $customer_code ])}}" class="text-xs px-2 font-small text-base bg-green-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-green-300">Cards</a>
                    <a href="{{route('update_customer', ['customer_code' => $customer_code])}}" class="text-xs px-2 font-small text-base bg-red-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-red-300">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Card -->
    @if (!empty($children))
    <div class="flex justify-left mt-8 pt-8 sm:pt-0">
        <h1 class="text-3xl font-semibold">Redeem Gifts</h1>
    </div>
    <form wire:submit.prevent="submit" method="POST">
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-12">
        @foreach($children as $childIndex => $child)
            <div class="col-span-2 p-6">
                <div class="justify-left sm:pt-0 bg-gray-50">
                    <h3 class="text-lg font-semibold p-2">{{ $child['name'] }} <span class="text-xs font-small text-gray-500">[ dob: {{ $child['dob'] }} ]</span></h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Redeem
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($child["gifts"] as $giftIndex => $gift)
                        <tr>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <span>{{ $gift['name']  }}</span>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <span>{{ ucwords($gift['type'])  }}</span>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input
                                        wire:model="redeemed"
                                        type="checkbox"
                                        value="{{ $gift['key'] }}"
                                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" {{ (!$user['is_admin'] && $this->isAlreadyRedeemed($gift['key'])) ? "disabled" : "" }}/>
                                    <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer">
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        </div>
        <div class="grid grid-cols-4 bg-gray-50">
            <div class="col-span-2 p-1">
                <div class="mt-6 px-4 py-3 text-left sm:px-6">
                    <a href="{{ route('search') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel
                    </a>
                </div>
            </div>
            <div class="col-span-2 p-1">
                <div class="mt-6 px-4 py-3 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Confirm and Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    </form>
    @else
        <div class="flex justify-left mt-8 pt-8 sm:pt-0">
            <h1 class="text-3xl font-semibold">Please Print Cards for this Customer before trying to redeem gifts</h1>
        </div>
    @endif
</div>
