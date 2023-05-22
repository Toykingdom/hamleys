<div>
    <div class="flex justify-left sm:pt-0">
        <h1 class="text-3xl font-semibold">Customer Search</h1>
    </div>
    <div class="bg-white p-4 space-y-4 mt-8 shadow overflow-hidden sm:rounded-md">
        <form wire:submit.prevent="submit" method="POST">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-2">
                    <input class="border-solid border border-gray-300 p-2 w-full" type="text" placeholder="Search Users" wire:model.defer="term"/>
                </div>
                <div class="md:col-span-1">
                    <button type="submit" class="justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                        Search
                    </button>
                </div>
            </div>
        </form>
        <div class="mt-4" wire:loading>Searching for customers, please wait...</div>
        <div wire:loading.remove>
            <!--
                notice that $term is available as a public
                variable, even though it's not part of the
                data array
            -->
            @if(empty($results))
                @if ($term != "")
                    <div class="mt-4 text-gray-500 text-sm">
                        No matching result were found.
                    </div>
                @endif
            @else
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
                    @if ( sizeof($this->results) > 0)
                        @foreach($this->results as $key => $result)
                            <tr class="{{ ($key % 2) ? "bg-gray-50" : ""  }}">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{$result->account_number}}
                                </td>
                                <td class="px-3 py-2">
                                    {{ ucwords(strtolower($result->first_name)) }} {{ ucwords(strtolower($result->last_name)) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{$result->mobile_number}}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ strtolower($result->email) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-left text-sm font-medium">
                                    <a href="{{route('print_cards', ['customer_code' => $result->account_number ])}}" class="text-xs px-2 font-small text-base bg-green-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-green-300">Cards</a>
                                    <a href="{{route('update_customer', ['customer_code' => $result->account_number])}}" class="text-xs px-2 font-small text-base bg-red-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-red-300">Edit</a>
                                    <a href="{{route('redeem_gifts', ['customer_code' => $result->account_number])}}" class="text-xs px-2 font-small text-base bg-indigo-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-indigo-300">Gifts</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>


            @endif
        </div>
    </div>

</div>
