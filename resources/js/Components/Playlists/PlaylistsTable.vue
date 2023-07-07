<script setup>
import PlaylistTR from './PlaylistTableRow.vue';

defineProps({
    playlists: {
        type: Array,
        required: true,
    },
    songs: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <table>
        <tr class="text-left">
            <th>Title</th>
            <th class="w-2/3">Songs</th>
            <th></th>
        </tr>
        <PlaylistTR v-for="playlist in playlists" :playlist="playlist" :songs="songs" :key="playlist.id" />
    </table>
</template>