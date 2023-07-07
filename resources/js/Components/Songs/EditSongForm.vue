<script setup>
import MyTextInput from '../MyTextInput.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';

const emit = defineEmits(['song-updated']);

const props = defineProps({
    song: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    title: props.song.title,
    artist: props.song.artist,
    album: props.song.album,
    genre: props.song.genre,
});

function submit() {
    form.put(route('songs.update', props.song.id), {
        onSuccess: () => {
            emit('song-updated');
        },
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <fieldset class="border shadow-md p-2 rounded-md w-full m-auto">
            <legend class="font-bold">
                Edit Song
            </legend>
            <div>
                <MyTextInput v-model="form.title" label="Title" autofocus />
                <MyTextInput v-model="form.artist" label="Artist" />
                <MyTextInput v-model="form.album" label="Album" />
                <MyTextInput v-model="form.genre" label="Genre" />
                <PrimaryButton type="submit">Save</PrimaryButton>
            </div>
        </fieldset>
    </form>
</template>