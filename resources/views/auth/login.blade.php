<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full px-10">
        <div>
            <x-logo class="w-auto h-14"></x-logo>
        </div>

        <div class="w-full mt-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="my-3">
                    <x-forms.label for="email" value="{{ __('Email') }}"/>
                    <x-forms.input type="text" id="email" name="email" class="w-full p-2 block mt-2 {{ $errors->has('email') ? 'border-red' : '' }}" placeholder="example@email.com"/>
                    @if($errors->has('email'))
                        <span class="text-red text-xs font-semibold mt-0.5">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="my-3">
                    <x-forms.label for="password" value="{{ __('Password') }}"/>
                    <x-forms.input type="password" id="password" name="password" class="w-full p-2 block mt-2 {{ $errors->has('password') ? ' border-red' : '' }}" placeholder="******"/>
                    @if($errors->has('password'))
                        <span class="text-red text-xs font-semibold mt-0.5">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="my-5">
                    <x-forms.button class="justify-center w-full h-10">{{ __('Log in') }}</x-forms.button>
                </div>

                @if (Route::has('password.request'))
                <div class="my-5">
                    <a class="block text-sm text-center text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
                @endif

            </form>
        </div>
    </div>
</x-guest-layout>
