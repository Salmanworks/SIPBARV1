<?php

use Livewire\Component;

new class extends Component {}; ?>

<div class="space-y-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
            <x-icon name="trash" size="md" />
        </div>
        <div>
            <h3 class="text-sm font-extrabold text-rose-900">Hapus Akun Administrator</h3>
            <p class="text-xs text-rose-700 mt-0.5">Penghapusan akun bersifat permanen. Seluruh data dan akses akun akan terhapus secara menyeluruh.</p>
        </div>
    </div>

    <div class="pt-2">
        <flux:modal.trigger name="confirm-user-deletion">
            <button type="button" data-test="delete-user-button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-700 border border-rose-300 font-bold text-xs transition-all">
                <x-icon name="trash" size="xs" />
                <span>Hapus Akun Permanen</span>
            </button>
        </flux:modal.trigger>

        <livewire:pages::settings.delete-user-modal />
    </div>
</div>
