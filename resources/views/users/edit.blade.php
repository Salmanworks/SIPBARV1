<x-layouts::app :title="__('Edit Pengguna')">
    <div class="mx-auto max-w-xl space-y-6">
        <flux:heading size="xl">Edit Pengguna</flux:heading>
        <x-alert />
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf @method('PUT')
            <flux:input name="name" label="Nama Lengkap" :value="old('name', $user->name)" required />
            <flux:input name="email" type="email" label="Email" :value="old('email', $user->email)" required />
            <flux:input name="no_induk" label="No. Induk/NIP" :value="old('no_induk', $user->no_induk)" />
            <flux:select name="role" label="Role" required>
                @foreach(\App\Enums\UserRole::cases() as $role)
                    <option value="{{ $role->value }}" @selected(old('role', $user->role->value) === $role->value)>{{ $role->label() }}</option>
                @endforeach
            </flux:select>
            <flux:input name="password" type="password" label="Password Baru (kosongkan jika tidak diubah)" />
            <flux:input name="password_confirmation" type="password" label="Konfirmasi Password" />
            <div class="flex gap-3">
                <flux:button type="submit">Perbarui</flux:button>
                <flux:button :href="route('admin.users.index')" variant="ghost" wire:navigate>Batal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
