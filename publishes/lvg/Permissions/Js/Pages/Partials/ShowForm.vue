<template>
    <dl class="gap-4" v-if="model?.can?.view">
        <LvgDd class="my-1">
            <template #dt>Id</template>
            {{ model?.id || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Name</template>
            {{ model?.name || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Guard Name</template>
            {{ model?.guard_name || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Created At</template>
            <strong>{{
                model?.created_at
                    ? dayjs(model?.created_at).format("MMM DD, YYYY hh:mm A")
                    : "-"
            }}</strong>
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Updated At</template>
            <strong>{{
                model?.updated_at
                    ? dayjs(model?.updated_at).format("MMM DD, YYYY hh:mm A")
                    : "-"
            }}</strong>
        </LvgDd>
    </dl>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "PermissionShowForm",
});
</script>
<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { computed, defineEmits, nextTick, ref } from "vue";
import dayjs from "dayjs";
import Tag from "primevue/tag";
import { useToast } from "primevue/usetoast";
import Message from "primevue/message";
import LvgDd from "@/Components/LvgDd.vue";
const emit = defineEmits(["updated", "error"]);
const props = defineProps({ model: {} });
const flash = computed(() => usePage().props?.value?.flash) as any;
const existingTables = ref([]);
const showModal = ref(false);
const toast = useToast();
const model = props.model;
import InputText from "primevue/inputtext";
</script>

<style scoped></style>
