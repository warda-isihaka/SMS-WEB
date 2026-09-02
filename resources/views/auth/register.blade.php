<x-guest-layout>
    <h1 style="color: black; font-size: 20px; text-align: center;">REGISTRATION FORM</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="confirm your password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
    <label class="block font-medium text-sm text-gray-700 mb-2">Select gender:</label>
    
    <div class="flex items-center space-x-6">
        <!-- Option 1 -->
        <label class="inline-flex items-center cursor-pointer">
            <input type="radio" name="gender" value="male" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" checked>
            <span class="ml-2 text-sm text-gray-700">Male</span>
        </label>

        <!-- Option 2 -->
        <label class="inline-flex items-center cursor-pointer">
            <input type="radio" name="gender" value="female" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-700">Female</span>
        </label>
    </div>
</div><br>

        
   

           
            

            <x-primary-button style="background-color: brown; color: black; width: 100%; text-align: centers;" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div></form>

    
</x-guest-layout>
