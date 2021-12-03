
<h1 class="text-2xl mt-8">Users</h1>

@foreach($users as $user)
    @if ($user->id === Auth::user()->id)
        @continue
    @endif
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8 mb-4">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $user->name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $user->email }}
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Public Keys
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        Key1: {{ $user->public_key_one }}, Key2: {{ $user->public_key_two }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Shared Keys
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        SK1: {{ auth()->user()->sharedKeyOneWith($user) }}, SK2: {{ auth()->user()->sharedKeyTwoWith($user) }}
                    </dd>
                </div>
            </dl>
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Affine Cipher Keys
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        AK1: {{ auth()->user()->affineCipherKeyOne($user) }}, AK2: {{ auth()->user()->affineCipherKeyTwo($user) }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        RSA Public Keys
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        ({{ $user->public_key ?? '-' }}, {{ $user->public_n }})
                    </dd>
                </div>
            </dl>
        </div>
    </div>


    <div class="flex">
        <form action="{{ route('generate-shared-keys') }}" method="POST">
            @csrf
            <input type="hidden" name="user" value="{{ $user->id }}">
            <button type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Obtain Shared Keys for {{ $user->name }}
            </button>
        </form>
        <a href="{{ route('message.affine.show', $user) }}" class="ml-2 rounded-md shadow py-2 px-4 border border-transparent text-sm font-medium text-white bg-green-500 hover:bg-green-600">{{ __("Affine Ciphered Chat") }}</a>

        <a href="{{ route('message.rsa.show', $user) }}" class="ml-2 rounded-md shadow py-2 px-4 border border-transparent text-sm font-medium text-white bg-green-500 hover:bg-green-600">
            {{ __("RSA Messaging") }}
        </a>
    </div>

@endforeach
