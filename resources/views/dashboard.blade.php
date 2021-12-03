<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Key Exchange Information
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Prime Key
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ config('defaults.prime_number') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Primitive Key
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ config('defaults.generator_number') }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Private Key
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ auth()->user()->private_key ?? '-' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Public Key
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ auth()->user()->public_key ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-4 flex">
                <div class="rounded-md shadow">
                    <form action="{{ route('obtain-private-key') }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Obtain Exchange Keys
                        </button>
                    </form>
                </div>
            </div>

            @include('partials._users-table')
        </div>
    </div>


</x-app-layout>