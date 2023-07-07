<script setup>
import { nextTick, ref } from 'vue';

defineOptions({
    inheritAttrs: false,
})
defineProps(['modelValue', 'label']);

defineEmits(['update:modelValue']);

const input = ref(null);

nextTick(() => {
    if (input.value.hasAttribute('autofocus')) {
        document.activeElement.blur();
        input.value.focus();
    }
})

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <label class="block border-b-2 font-bold w-full focus-within:border-b-blue-400 relative my-2 text-lg">
        <input
            class="transition-all border-0 focus:outline-0 focus:ring-0 focus:ring-transparent w-full p-0 m-0 peer mt-5 placeholder-shown:mt-0 focus:mt-5"
            placeholder=" "
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-bind="$attrs"
            ref="input"
        />
        <div class="transition-all text-gray-400 absolute scale-75 top-0 peer-placeholder-shown:scale-100 peer-focus:scale-75 origin-[0]">{{ label }}</div>
    </label>
</template>
