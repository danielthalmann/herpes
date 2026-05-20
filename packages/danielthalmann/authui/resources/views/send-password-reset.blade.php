@extends('authui::layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">
  <div class="max-w-md w-full text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">{{ __('authui::login.Login') }}</h2>

    <form method="post" class="space-y-4">
        @csrf
        <div>
            <x-authui.input name="email" required="true" :label="__('authui::login.email')" type="email"></x-authui.input>
        </div>

        <div class="flex items-center justify-between pb-5">
            <x-authui.checkbox name="remember" checked="false">{{ __('authui::login.Remember me') }}</x-authui.checkbox>
        </div>


        <x-authui.button aspect="full" type="submit" name="submit">{{ __('authui::login.Reset password') }}</x-authui.button>
        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('authui::login.Forgot password?') }}</a>
    </form>

  </div>
</div>

@endsection

