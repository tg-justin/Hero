<h2>Change Password</h2>

<p>Make sure your account is using a long, random password to stay secure.</p>

<div class="space-y-6">

	<div>
		<label for="update_password_current_password" class="field-label field-required">Current Password</label>
		<x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password"/>
		<x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
	</div>

	<div>
		<label for="update_password_password" class="field-label field-required">New Password</label>
		<x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
		<x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
	</div>

	<div>
		<label for="update_password_password_confirmation" class="field-label field-required">Confirm Password</label>
		<x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
		<x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
	</div>

</div>