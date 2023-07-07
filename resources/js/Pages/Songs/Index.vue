<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddSongForm from '@/Components/Songs/AddSongForm.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SongsTable from '@/Components/Songs/SongsTable.vue';

import { ref } from 'vue';

const showAddSongModal = ref(false);

const props = defineEmits({
    songs: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Songs</h2>
        </template>

        <div class="p-2 flex flex-col">
            <SongsTable :Song="Song" />
        </div>
        <PrimaryButton @click="showAddSongModal = true">
            Add Song
        </PrimaryButton>

        <Modal :show="showAddSongModal" @close="showAddSongModal = false">
            <div class="p-4 relative">
                <div class="absolute right-4 top-4">
                    <button @click="showAddSongModal = false"
                        class="bg-white border-2 border-red-600 text-gray-400 hover:text-white hover:bg-red-600 ">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <AddSongForm @song-added="showAddSongModal = false" />
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>