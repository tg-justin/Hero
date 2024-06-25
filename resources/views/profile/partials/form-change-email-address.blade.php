<h2>Change Email Address</h2>

<p>Make sure your account is using a long, random password to stay secure.</p>

<div>
	<x-input-label for="update_password_current_password" class="block text-sm font-medium" :value="__('Current Password')"/>
	<x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password"/>
	<x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
</div>

<div>
	<x-input-label for="update_password_password" class="block text-sm font-medium" :value="__('New Password')"/>
	<x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
	<x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
</div>

<div>
	<x-input-label for="update_password_password_confirmation" class="block text-sm font-medium" :value="__('Confirm Password')"/>
	<x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
	<x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
</div>