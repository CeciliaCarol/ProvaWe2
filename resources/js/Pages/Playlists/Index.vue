<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PlaylistsTable from '@/Components/Playlists/PlaylistsTable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import AddPlaylistForm from '@/Components/Playlists/AddPlaylistForm.vue';
import { ref } from 'vue';

defineProps({
    Playlists: {
        type: Array,
        required: true,
    },
    songs: {
        type: Array,
    },
});

const showAddPlaylistModal = ref(false);
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Playlists</h2>
        </template>
        <div class="p-2 flex flex-col">
            <PlaylistsTable :Playlists="Playlists" :songs="songs" />
        </div>
        <PrimaryButton @click="showAddPlaylistModal = true">
            Add Playlist
        </PrimaryButton>

        <Modal :show="showAddPlaylistModal" @close="showAddPlaylistModal = false">
            <div class="p-4 relative">
                <div class="absolute right-4 top-4">
                    <button @click="showAddPlaylistModal = false"
                        class="bg-white border-2 border-red-600 text-gray-400 hover:text-white hover:bg-red-600 ">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <AddPlaylistForm @playlist-added="showAddPlaylistModal = false" />
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>