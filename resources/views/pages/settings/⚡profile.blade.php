<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Pengaturan Profil'), Layout('layouts.sipbar-settings-wrapper')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Informasi profil berhasil diperbarui.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full space-y-6">
    <x-pages::settings.layout>
        <div class="grid gap-6 lg:grid-cols-12">

            {{-- Left Column: Avatar & Profile Info Card --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm text-center">
                    <div class="relative inline-block mx-auto mb-4">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-3xl shadow-xl shadow-blue-500/25">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white flex items-center justify-center" title="Status Aktif">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-900 leading-tight mb-0.5">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-slate-500 font-medium mb-3">{{ auth()->user()->email }}</p>

                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                        <x-icon name="shield-check" size="xs" />
                        <span>{{ auth()->user()->role->value ?? 'Admin' }}</span>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 text-left space-y-2 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Status Akun:</span>
                            <span class="font-bold text-emerald-600">Aktif & Terverifikasi</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Bergabung Sejak:</span>
                            <span class="font-semibold text-slate-700">{{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Edit Profile Form --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Informasi Pengguna</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Perbarui nama akun dan alamat email resmi Anda.</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <x-icon name="user" size="md" />
                        </div>
                    </div>

                    <form wire:submit="updateProfileInformation" class="space-y-5">
                        {{-- Name Field --}}
                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                            <div class="relative">
                                <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none"
                                       placeholder="Nama Administrator">
                            </div>
                            @error('name') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Alamat Email</label>
                            <div class="relative">
                                <input wire:model="email" id="email" type="email" required autocomplete="email"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none"
                                       placeholder="email@sekolah.sch.id">
                            </div>
                            @error('email') <p class="text-xs font-bold text-rose-500 mt-1">{{ $message }}</p> @enderror

                            @if ($this->hasUnverifiedEmail)
                                <div class="mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900">
                                    <p class="font-bold">Alamat email Anda belum terverifikasi.</p>
                                    <button wire:click.prevent="resendVerificationNotification" type="button" class="underline font-semibold mt-1 text-amber-700 hover:text-amber-900">
                                        Klik di sini untuk mengirim ulang email verifikasi.
                                    </button>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-bold text-emerald-600">Link verifikasi baru telah dikirimkan ke email Anda.</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                            <button type="submit" data-test="update-profile-button"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs shadow-lg shadow-blue-500/25 hover:shadow-xl hover:scale-[1.02] active:scale-95 transition-all">
                                <x-icon name="check" size="xs" />
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Delete Account Section --}}
                @if ($this->showDeleteUser)
                    <div class="bg-rose-50/50 rounded-2xl p-6 sm:p-7 border border-rose-200/80 shadow-sm">
                        <livewire:pages::settings.delete-user-form />
                    </div>
                @endif
            </div>

        </div>
    </x-pages::settings.layout>
</section>
