<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affine Cipher') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen flex-col">
        <div class="flex-grow mx-8 mt-8 border border-gray-200 bg-gray-100 p-4 rounded-lg h-100">
            chat
        </div>
        <form class="m-8 mt-4 flex flex-col" action="{{ route('message.store') }}" method="POST">
            @csrf
            <textarea name="message" class="bg-white border border-blue-200 p-4 rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Type your message here"></textarea>
            <div>
                <button type="submit" class="block bg-green-400 text-white px-4 py-2 mt-2 rounded-lg border-0">Send</button>
            </div>
        </form>
    </div>

</x-app-layout>
