@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __('authui::login.Login') }}</h2>

    <form method="post" class="space-y-4">
        @csrf
        <div>
            <x-ui-input name="email" required="true" :label="__('authui::login.email')" type="email"></x-ui-input>
        </div>

        <div>
            <x-ui-input name="password" required="true" :label="__('authui::login.password')" type="password"></x-ui-input>
        </div>

        <div class="flex items-center justify-between">
            <x-ui-checkbox name="remember" checked="false">{{ __('authui::login.Remember me') }}</x-ui-checkbox>

            {{-- <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a> --}}
        </div>

            <x-ui-button aspect="full" type="submit" name="submit">{{ __('authui::login.Sign In') }}</x-ui-button>
    </form>

  </div>
</div>


@endsection

