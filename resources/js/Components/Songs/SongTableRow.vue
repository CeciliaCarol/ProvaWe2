<script setup>
import EditIcon from '@/Components/Icons/EditIcon.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { useForm } from '@inertiajs/vue3';

import { ref } from 'vue';
import EditSongForm from './EditSongForm.vue';

const props = defineProps({
    song: {
        type: Object,
        required: true,
    },
})

const showDeleteModal = ref(false);
const showEditModal = ref(false);


function remove() {
    useForm({}).delete(route('songs.destroy', props.song.id));
}
</script>

<template>
    <tr class="border-b">
        <td>{{ song.title }}</td>
        <td>{{ song.artist }}</td>
        <td>{{ song.album }}</td>
        <td>{{ song.genre }}</td>
        <td>
            <button class="bg-white text-gray-600 hover:text-white hover:bg-red-600 px-4 py-1 rounded-md"
                @click="showDeleteModal = true">
                <DeleteIcon class="h-6 w-6" />
            </button>
            <button class="bg-white text-gray-600 hover:text-white hover:bg-indigo-600 px-4 py-1 rounded-md"
                @click="showEditModal = true">
                <EditIcon class="h-6 w-6" />
            </button>
        </td>
    </tr>

    <Modal :show="showDeleteModal" @close="showDeleteModal = false" maxWidth="sm">
        <div class="p-4">
            <h2 class="text-xl font-semibold">Delete Song</h2>
            <p class="text-gray-600">Are you sure you want to delete the song <strong>{{ song.title }}</strong>?</p>
            <div class="mt-4 flex justify-end gap-2">
                <PrimaryButton @click="showDeleteModal = false">
                    Cancel
                </PrimaryButton>
                <DangerButton @click="remove">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>

    <Modal :show="showEditModal" @close="showEditModal = false" maxWidth="sm">
        <div class="p-4 relative">
            <div class="absolute right-4 top-4">
                <button @click="showEditModal = false"
                    class="bg-white border-2 border-red-600 text-gray-400 hover:text-white hover:bg-red-600 ">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <EditSongForm @song-updated="showEditModal = false" />
        </div>
    </Modal>
</template>