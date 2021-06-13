<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full px-10">
        <div>
            <x-logo class="w-auto h-14"></x-logo>
        </div>
        <div class="mt-4 text-sm text-gray-600 w-96 lg:w-full">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        <div class="mx-auto mt-4 w-96 lg:w-full">
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
