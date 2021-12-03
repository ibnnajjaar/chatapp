<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Affine Cipher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex min-h-screen flex-col">
                @if ($user->id)
                <form class="mt-4 flex flex-col" action="{{ route('message.store', $user) }}" method="POST">
                    @csrf
                    <textarea name="message"
                              class="bg-white border border-blue-200 p-4 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                              placeholder="Type your message here"></textarea>
                    <div>
                        <button type="submit" class="block bg-green-400 text-white px-4 py-2 mt-2 rounded-lg border-0">
                            Send
                        </button>
                    </div>
                </form>
                @endif

                <div class="mt-6">

                    @foreach ($messages as $message)
                        <div class="bg-blue-600 rounded-full text-white px-4 py-2 mb-2">
                            {{ optional($message->user)->name }}: {{ $message->decryptedMessageToUser($user) }}
                        </div>
                    @endforeach

                </div>

            </div>

        </div>
    </div>


</x-app-layout>
