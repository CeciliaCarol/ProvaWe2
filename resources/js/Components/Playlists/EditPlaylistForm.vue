<script setup>
import MyTextInput from '../MyTextInput.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';

const emit = defineEmits(['playlist-updated']);

const props = defineProps({
    playlist: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    title: props.playlist.title,
});

function submit() {
    form.put(route('playlists.update', props.playlist.id), {
        onSuccess: () => {
            emit('playlist-updated');
        },
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <fieldset class="border shadow-md p-2 rounded-md w-full m-auto">
            <legend class="font-bold">
                Edit Playlist
            </legend>
            <div>
                <MyTextInput v-model="form.title" label="Title" autofocus />
                <PrimaryButton>Save</PrimaryButton>
            </div>
        </fieldset>
    </form>
</template>