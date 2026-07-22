<x-layouts.admin title="Tambah Pengguna">
    <div class="mx-auto max-w-xl space-y-6">
        <flux:heading size="xl">Tambah Pengguna</flux:heading>
        <x-alert />
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            <flux:input name="name" label="Nama Lengkap" :value="old('name')" required />
            <flux:input name="email" type="email" label="Email" :value="old('email')" required />
            <flux:input name="no_induk" label="No. Induk/NIP" :value="old('no_induk')" />
            <flux:select name="role" label="Role" required>
                @foreach(\App\Enums\UserRole::cases() as $role)
                    <option value="{{ $role->value }}" @selected(old('role') === $role->value)>{{ $role->label() }}</option>
                @endforeach
            </flux:select>
            <flux:input name="password" type="password" label="Password" required />
            <flux:input name="password_confirmation" type="password" label="Konfirmasi Password" required />
            <div class="flex gap-3">
                <flux:button type="submit">Simpan</flux:button>
                <flux:button :href="route('admin.users.index')" variant="ghost" wire:navigate>Batal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
