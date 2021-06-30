<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-10">
        <div>
            <a href="{{ route('login') }}">
                <x-logo class="w-auto h-12"></x-logo>
            </a>
        </div>
        <div class="w-full max-w-sm mx-auto mt-4 text-sm text-gray-600">
            <p class="px-3">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
        </div>
        <div class="max-w-sm mx-auto mt-4">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="my-3">
                    <x-forms.label for="email" value="{{ __('Email') }}"/>
                    <x-forms.input type="text" id="email" name="email" class="w-full p-2 block mt-2 {{ $errors->has('email') ? ' border-red' : '' }}" placeholder="example@email.com"/>
                    @if($errors->has('email'))
                        <span class="text-red text-xs font-semibold mt-0.5">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="my-5">
                    <x-forms.button class="justify-center w-full h-12">{{ __('Email Password Reset Link') }}</x-forms.button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
