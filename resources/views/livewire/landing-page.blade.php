<div
    x-data="{
         showSubscribeModal : @entangle('showSubscribeModal'),
         showSuccess : @entangle('showSuccess')
     }"
    class="flex flex-col bg-indigo-900 w-full h-screen">
    <nav class="flex pt-5 justify-between container mx-auto text-indigo-200">
        <a class="text-4xl font-bold" href="/">
            <x-application-logo class="w-16 h-16 fill-current "/>
        </a>

        <div class="flex justify-end">
            @auth
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <div class="flex container mx-auto items-center h-full">
        <div class="flex flex-col w-1/3 items-start">
            <h1 class="text-white font-bold text-5xl leading-tight mb-4">
                Simple generic landing page to subscribe
            </h1>

            <p class="text-indigo-200 text-xl mb-10">
                We are just checking the <span class="font-bold underline">TALL</span> stack. Would you mind
                subscribing ?
            </p>

            <x-button class="py-3 px-8 bg-red-500 hover:bg-red-600"
                      @click="showSubscribeModal = true">
                Subscribe
            </x-button>
        </div>
    </div>
    <x-modal trigger="showSubscribeModal" class="bg-pink-500">
        <p class="text-white text-5xl font-extrablod text-center">
            Let's do it!
        </p>
        <form
            wire:submit.prevent="subscribe"
            class="flex flex-col items-center p-24">
            <x-input wire:model="email" class="px-5 py-3 w-80 border-blue-400" type="email"
                     placeholder="Email address"/>
            <span class="text-gray-100 text-xs ">
                {{ $errors->has('email') ? $errors->first('email') : ' We will send you a confirmation email.' }}
            </span>
            <x-button class="px-5 py-3 mt-5 w-80 bg-blue-500 justify-center">
                Get In
            </x-button>
        </form>
    </x-modal>
    <x-modal trigger="showSuccess" class="bg-green-500">
        <p class="animate-pulse text-white text-9xl font-extrablod text-center">
            &check;
        </p>
        <p class="text-white text-5xl font-extrablod text-center mt-12">
            Great!
        </p>
        @if(request('verified'))
            <p class="text-white text-3xl text-center">
                Thanks for confirmation.
            </p>
        @else
            <p class="text-white text-3xl text-center">
                See you in your inbox.
            </p>
        @endif
    </x-modal>
</div>
