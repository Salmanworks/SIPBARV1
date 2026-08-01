<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Pengaturan Tampilan'), Layout('layouts.sipbar-settings-wrapper')] class extends Component {
    //
}; ?>

<section class="w-full space-y-6">
    <x-pages::settings.layout>
        <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Tema & Tampilan Aplikasi</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih preferensi tema visual untuk kenyamanan penggunaan panel admin Anda.</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <x-icon name="sparkles" size="md" />
                </div>
            </div>

            <div class="space-y-4">
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="w-full max-w-md">
                    <flux:radio value="light" icon="sun">{{ __('Terang (Light)') }}</flux:radio>
                    <flux:radio value="dark" icon="moon">{{ __('Gelap (Dark)') }}</flux:radio>
                    <flux:radio value="system" icon="computer-desktop">{{ __('Sistem (Auto)') }}</flux:radio>
                </flux:radio.group>

                <p class="text-xs text-slate-500 font-medium">
                    Tema akan diterapkan secara instan pada seluruh komponen antarmuka SIPBAR.
                </p>
            </div>
        </div>
    </x-pages::settings.layout>
</section>
