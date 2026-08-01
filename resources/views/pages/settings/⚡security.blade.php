<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Laravel\Passkeys\Actions\DeletePasskey;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

new #[Title('Pengaturan Keamanan'), Layout('layouts.sipbar-settings-wrapper')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;
    public bool $twoFactorEnabled;
    public bool $requiresConfirmation;

    #[Locked]
    public bool $canManagePasskeys;

    #[Locked]
    public array $passkeys = [];

    public bool $showDeleteModal = false;

    #[Locked]
    public ?int $deletingPasskeyId = null;

    #[Locked]
    public string $deletingPasskeyName = '';

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

        $this->canManagePasskeys = Features::canManagePasskeys();

        if ($this->canManagePasskeys) {
            $this->loadPasskeys();
        }
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        $user = Auth::user();

        $user->update([
            'password' => $validated['password'],
        ]);

        if ($user->first_login) {
            $user->update(['first_login' => false]);
        }

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: __('Kata sandi berhasil diperbarui.'));
    }

    /**
     * Load the user's passkeys.
     */
    public function loadPasskeys(): void
    {
        $this->passkeys = auth()->user()->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->toArray();
    }

    /**
     * Show the delete confirmation modal.
     */
    public function confirmDelete(int $passkeyId): void
    {
        $passkey = auth()->user()->passkeys()->findOrFail($passkeyId);

        $this->deletingPasskeyId = $passkey->id;
        $this->deletingPasskeyName = $passkey->name;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the passkey.
     */
    public function deletePasskey(DeletePasskey $deletePasskey): void
    {
        if (! $this->deletingPasskeyId) {
            return;
        }

        $passkey = auth()->user()->passkeys()->findOrFail($this->deletingPasskeyId);

        $deletePasskey(auth()->user(), $passkey);

        $this->closeDeleteModal();
        $this->loadPasskeys();
    }

    /**
     * Close the delete confirmation modal.
     */
    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingPasskeyId = null;
        $this->deletingPasskeyName = '';
    }

    /**
     * Handle the two-factor authentication enabled event.
     */
    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full space-y-6">
    <x-pages::settings.layout>
        {{-- ====== CARD UBAH KATA SANDI ====== --}}
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6"
             x-data="{
                 showCurrent: false,
                 showNew: false,
                 showConfirm: false,
                 newPass: '',
                 get score() {
                     let p = this.newPass;
                     if (!p) return 0;
                     let score = 0;
                     if (p.length >= 6) score++;
                     if (p.length >= 8) score++;
                     if (/[A-Z]/.test(p) && /[0-9]/.test(p)) score++;
                     if (/[^A-Za-z0-9]/.test(p)) score++;
                     return score;
                 },
                 get label() {
                     let s = this.score;
                     if (s === 0) return 'Sangat Lemah';
                     if (s === 1) return 'Lemah';
                     if (s === 2) return 'Sedang';
                     if (s === 3) return 'Kuat';
                     return 'Sangat Kuat';
                 },
                 get colorClass() {
                     let s = this.score;
                     if (s <= 1) return 'bg-rose-500';
                     if (s === 2) return 'bg-amber-500';
                     if (s === 3) return 'bg-blue-500';
                     return 'bg-emerald-500';
                 }
             }">

            {{-- Header --}}
            <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                        <x-icon name="shield-check" size="md" />
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 leading-tight">Ubah Kata Sandi</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan.</p>
                    </div>
                </div>
            </div>

            {{-- Form Password --}}
            <form method="POST" wire:submit="updatePassword" class="space-y-5">
                
                {{-- Current Password --}}
                <div class="space-y-1.5">
                    <label for="current_password" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        Kata Sandi Saat Ini
                    </label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'"
                               wire:model="current_password"
                               id="current_password"
                               required
                               autocomplete="current-password"
                               placeholder="Masukkan kata sandi saat ini"
                               class="w-full rounded-xl border border-slate-200/90 bg-white px-4 py-3 text-sm font-semibold text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none pr-11">
                        
                        <button type="button" @click="showCurrent = !showCurrent"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-blue-600 transition-colors focus:outline-none"
                                title="Tampilkan/Sembunyikan Kata Sandi">
                            <template x-if="!showCurrent">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                            <template x-if="showCurrent">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.04 10.04 0 013.122-.463c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.49 4.156M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"/></svg>
                            </template>
                        </button>
                    </div>
                    @error('current_password') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- New Password --}}
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        Kata Sandi Baru
                    </label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'"
                               wire:model.live="password"
                               x-model="newPass"
                               id="password"
                               required
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter (huruf & angka)"
                               class="w-full rounded-xl border border-slate-200/90 bg-white px-4 py-3 text-sm font-semibold text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none pr-11">
                        
                        <button type="button" @click="showNew = !showNew"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-blue-600 transition-colors focus:outline-none">
                            <template x-if="!showNew">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                            <template x-if="showNew">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.04 10.04 0 013.122-.463c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.49 4.156M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"/></svg>
                            </template>
                        </button>
                    </div>

                    {{-- Strength Meter --}}
                    <div x-show="newPass.length > 0" class="pt-2 space-y-1.5 transition-all">
                        <div class="flex items-center justify-between text-[11px] font-extrabold">
                            <span class="text-slate-500">Kekuatan Kata Sandi:</span>
                            <span :class="{
                                'text-rose-500': score <= 1,
                                'text-amber-500': score === 2,
                                'text-blue-500': score === 3,
                                'text-emerald-500': score === 4
                            }" x-text="label"></span>
                        </div>
                        <div class="flex items-center gap-1.5 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden p-0.5">
                            <div class="h-full rounded-full transition-all duration-300" :class="[colorClass]" :style="`width: ${(score / 4) * 100}%`"></div>
                        </div>
                    </div>

                    @error('password') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'"
                               wire:model="password_confirmation"
                               id="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Ulangi kata sandi baru"
                               class="w-full rounded-xl border border-slate-200/90 bg-white px-4 py-3 text-sm font-semibold text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none pr-11">
                        
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-blue-600 transition-colors focus:outline-none">
                            <template x-if="!showConfirm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                            <template x-if="showConfirm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.04 10.04 0 013.122-.463c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.49 4.156M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"/></svg>
                            </template>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Action Button --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" data-test="update-password-button"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2.5 px-7 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 hover:shadow-xl hover:scale-[1.02] active:scale-95 disabled:opacity-75 transition-all cursor-pointer">
                        
                        {{-- Loading Spinner --}}
                        <svg wire:loading wire:target="updatePassword" class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <x-icon wire:loading.remove wire:target="updatePassword" name="check" size="xs" />
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>

            </form>
        </div>

        {{-- ====== CARD 2FA AUTENTIKASI DUA FAKTOR ====== --}}
        @if ($canManageTwoFactor)
            <div class="mt-6 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                            <x-icon name="lock-closed" size="md" />
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 leading-tight">Autentikasi Dua Faktor (2FA)</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Tingkatkan keamanan akun dengan verifikasi dua langkah via aplikasi authenticator.</p>
                        </div>
                    </div>

                    {{-- Modern Toggle Switch Pill for 2FA --}}
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-xs font-bold {{ $twoFactorEnabled ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $twoFactorEnabled ? '2FA Aktif' : '2FA Nonaktif' }}
                        </span>
                        
                        @if ($twoFactorEnabled)
                            <button type="button" wire:click="disable"
                                    class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out bg-gradient-to-r from-blue-600 to-indigo-600 shadow-md shadow-blue-500/30"
                                    title="Klik untuk menonaktifkan 2FA">
                                <span class="translate-x-5 pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-md transition duration-300 ease-in-out flex items-center justify-center text-indigo-600 font-bold text-[10px]">
                                    ✓
                                </span>
                            </button>
                        @else
                            <flux:modal.trigger name="two-factor-setup-modal">
                                <button type="button" wire:click="$dispatch('start-two-factor-setup')"
                                        class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out bg-slate-300 hover:bg-slate-400"
                                        title="Klik untuk mengaktifkan 2FA">
                                    <span class="translate-x-0 pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-sm transition duration-300 ease-in-out flex items-center justify-center text-slate-400 text-[10px]">
                                        ✕
                                    </span>
                                </button>
                            </flux:modal.trigger>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col w-full space-y-4 text-sm" wire:cloak>
                    @if ($twoFactorEnabled)
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 font-semibold flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></div>
                                <span>Akun Anda dilindungi oleh Autentikasi Dua Faktor. PIN acak dari aplikasi TOTP diperlukan saat login.</span>
                            </div>

                            <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>
                    @else
                        <div class="space-y-4">
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Saat Anda mengaktifkan Autentikasi Dua Faktor, sistem akan meminta PIN verifikasi acak yang diambil dari aplikasi Authenticator (seperti Google Authenticator atau Authy) di smartphone Anda setiap kali melakukan login.
                            </p>

                            <flux:modal.trigger name="two-factor-setup-modal">
                                <button type="button" wire:click="$dispatch('start-two-factor-setup')"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs shadow-md shadow-blue-500/25 hover:shadow-lg hover:scale-[1.02] transition-all">
                                    <x-icon name="shield-check" size="xs" />
                                    <span>Aktifkan 2FA Sekarang</span>
                                </button>
                            </flux:modal.trigger>

                            <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Passkeys Section --}}
        @if ($canManagePasskeys)
            <div class="mt-6 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white shadow-md shadow-violet-500/20">
                            <x-icon name="key" size="md" />
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 leading-tight">Passkeys</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola passkey untuk login tanpa kata sandi menggunakan sidik jari/face recognition.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col w-full space-y-4 text-sm" wire:cloak>
                    <div class="border rounded-2xl border-slate-200 overflow-hidden">
                        @forelse ($passkeys as $passkey)
                            <div class="flex items-center justify-between p-4 {{ ! $loop->last ? 'border-b border-slate-100' : '' }}">
                                <div class="flex items-center gap-3.5">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                        <flux:icon.key class="size-5" />
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-xs text-slate-900">{{ $passkey['name'] }}</p>
                                            @if ($passkey['authenticator'])
                                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px] font-bold text-slate-600">{{ $passkey['authenticator'] }}</span>
                                            @endif
                                        </div>
                                        <p class="text-slate-400 text-[11px] mt-0.5">
                                            Dibuat: {{ $passkey['created_at_diff'] }}
                                            @if ($passkey['last_used_at_diff'])
                                                <span class="mx-1">•</span> Terakhir dipakai: {{ $passkey['last_used_at_diff'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <button type="button" wire:click="confirmDelete({{ $passkey['id'] }})"
                                        class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors">
                                    <x-icon name="trash" size="sm" />
                                </button>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="mx-auto mb-3 flex size-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <flux:icon.key class="size-6" />
                                </div>
                                <p class="font-bold text-xs text-slate-700">Belum ada Passkey</p>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan passkey untuk login cepat tanpa mengetik kata sandi.</p>
                            </div>
                        @endforelse
                    </div>

                    <x-passkey-registration />
                </div>
            </div>
        @endif
    </x-pages::settings.layout>

    {{-- Passkey Delete Modal --}}
    <flux:modal
        name="delete-passkey-modal"
        class="max-w-md md:min-w-md"
        @close="closeDeleteModal"
        wire:model="showDeleteModal"
    >
        <div class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">Hapus Passkey</flux:heading>
                <flux:text>
                    Apakah Anda yakin ingin menghapus passkey "{{ $deletingPasskeyName }}"? Anda tidak akan dapat menggunakannya lagi untuk login.
                </flux:text>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button variant="outline" wire:click="closeDeleteModal">Batal</flux:button>
                <flux:button variant="danger" wire:click="deletePasskey">Hapus Passkey</flux:button>
            </div>
        </div>
    </flux:modal>
</section>
