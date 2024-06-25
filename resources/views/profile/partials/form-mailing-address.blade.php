<h2>Mailing Address</h2>

<p>This information is only available to you, system admins, and quest managers who are vetted by Tabletop Gaymers.
	We ask for your mailing address to offer you opportunities specific to you location and if you earn any physical
	rewards as a result of the quests you complete. You may provide as much or as little specificity as you wish.
	For example, you can choose to leave off your street address. <strong>None of these fields are required.</strong></p>

{{-- Street Address Field --}}
<div>
	<x-input-label for="address" :value="__('Street Address')"/>
	<x-text-input id="address" name="address" type="text" class="block mt-1 w-full max-w-md" :value="old('address', $hero->address)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('address')"/>
</div>

{{-- City Field --}}
<div>
	<x-input-label for="city" :value="__('City')"/>
	<x-text-input id="city" name="city" type="text" class="block mt-1 w-full max-w-md" :value="old('city', $hero->city)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('city')"/>
</div>

{{-- State Field --}}
<div>
	<x-input-label for="state" :value="__('State/Providence')"/>
	<x-text-input id="state" name="state" type="text" class="block mt-1 w-full max-w-md" :value="old('state', $hero->state)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('state')"/>
</div>

{{-- Zip Code Field --}}
<div>
	<x-input-label for="zip_code" :value="__('Zip/Postal Code')"/>
	<x-text-input id="zip_code" name="zip_code" type="text" class="block mt-1 w-full max-w-xs" :value="old('zip_code', $hero->zip_code)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('zip_code')"/>
</div>

{{-- Country Field --}}
<div>
	<x-input-label for="country" :value="__('Country')"/>
	<x-text-input id="country" name="country" type="text" class="block mt-1 w-full max-w-xs" :value="old('country', $hero->country)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('country')"/>
</div>