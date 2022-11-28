<div>
    <x-input wire:model="firstName" label="Name" placeholder="User's first name" />
    <x-select label="Select Relator" placeholder="Select relator" wire:model.defer="model">
        <x-select.user-option img="https://via.placeholder.com/500" label="People 1" value="1" />
        <x-select.user-option img="https://via.placeholder.com/500" label="People 2" value="2" />
        <x-select.user-option img="https://via.placeholder.com/500" label="People 3" value="3" />
        <x-select.user-option img="https://via.placeholder.com/500" label="People 4" value="4" />
    </x-select>
    <x-datetime-picker without-time label="Appointment Date" placeholder="Appointment Date" display-format="DD-MM-YYYY"
        wire:model.defer="displayFormat" />
        <x-datetime-picker
    without-timezone
    label="Appointment Date"
    placeholder="Appointment Date"
    wire:model="withoutTimezone"
/>
<x-button wire:click="alert" primary label="Primary" />
<x-modal blur wire:model.defer="simpleModal">
    <x-card title="Consent Terms">
        <p class="text-gray-600">
            Lorem Ipsum...
        </p>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="I Agree" />
            </div>
        </x-slot>
    </x-card>
</x-modal>
</div>
