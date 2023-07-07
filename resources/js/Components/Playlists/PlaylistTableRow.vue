<script setup>
import Modal from '@/Components/Modal.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import EditPlaylistForm from './EditPlaylistForm.vue';
import MyTextInput from '@/Components/MyTextInput.vue';

import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const showDeleteModal = ref(false);
const showEditModal = ref(false);
const song = ref('');

const props = defineProps({
    playlist: {
        type: Object,
        required: true,
    },
    songs: {
        type: Array,
        required: true,
    },
})

function remove() {
    useForm({}).delete(route('playlists.destroy', props.playlist.id));
}

watch(song, (value) => {
    if (props.songs.map(song => song.title).includes(value)) {
        const song_id = props.songs.find(song => song.title === value).id;
        useForm({}).put(route('playlists.add-song', [props.playlist.id, song_id]), {
            onFinish: () => {
                console.log('finished')
                song.value = '';
            },
        });
    }
});

function removeSong(song_id) {
    useForm({}).delete(route('playlists.remove-song', [props.playlist.id, song_id]));
}

const availableSongs = computed(() => {
    return props.songs.filter(song => !props.playlist.songs.map(song => song.id).includes(song.id));
});
</script>

<template>
    <tr class="border-b">
        <td>{{ playlist.title }}</td>
        <td>
            <div class="flex gap-2 flex-wrap mt-2">
                <div v-for="song in playlist.songs" :key="song.id"
                    class="border shadow text-sm px-1 rounded-md hover:bg-gray-200 group relative overflow-hidden">
                    {{ song.title }}
                    <span class="inline-block w-0 group-hover:w-6 transition-all"></span>
                    <div
                        class="transition-all absolute right-0 top-0 translate-x-6 w-6 group-hover:translate-x-0 z-10 cursor-pointer">
                        <button class="bg-red-400 text-white hover:bg-red-600"
                            @click="removeSong(song.id)">
                            <svg class="h-5 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="scale-75 w-full origin-[0]">
                <MyTextInput v-model="song" class="" :list="`songs-list${playlist.id}`" label="add song" />
                <datalist :id="`songs-list${playlist.id}`">
                    <option v-for="song in availableSongs" :key="song.id" :value="song.title"></option>
                </datalist>
            </div>
        </td>
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
            <h2 class="text-xl font-semibold">Delete Playlist</h2>
            <p class="text-gray-600">Are you sure you want to delete the playlist <strong>{{ playlist.title }}</strong>?</p>
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
            <EditPlaylistForm :playlist="playlist" @playlist-updated="showEditModal = false" />
        </div>
    </Modal>
</template>

<style scoped lang="scss"></style>