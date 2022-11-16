<template>
    <dl class="gap-4" v-if="model?.can?.view">
        <LvgDd class="my-1">
            <template #dt>Id</template>
            {{ model?.id || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Type</template>
            {{ model?.type || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Method</template>
            {{ model?.method || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Related Key</template>
            {{ model?.related_key || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Related Table</template>
            {{ model?.related_table || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Local Key</template>
            {{ model?.local_key || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Label Column</template>
            {{ model?.label_column || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Is Recursive</template>
            <Tag
                v-if="model?.is_recursive"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Is Morph</template>
            <Tag
                v-if="model?.is_morph"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Morph Type Column</template>
            {{ model?.morph_type_column || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Morph Id Column</template>
            {{ model?.morph_id_column || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Server Validation</template>
            {{ model?.server_validation || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>In List</template>
            <Tag
                v-if="model?.in_list"
                icon="pi pi-check"
                severity="success"
                value="Yes"
            />
            <Tag v-else icon="pi pi-times" severity="danger" value="No" />
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
        <LvgDd class="my-1">
            <template #dt>Related</template>
            {{ model?.related?.table_name || "-" }}
        </LvgDd>
        <LvgDd class="my-1">
            <template #dt>Schematic</template>
            {{ model?.schematic?.table_name || "-" }}
        </LvgDd>
    </dl>
    <Message v-else severity="error"
        >You are not authorized to view this record</Message
    >
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "RelationshipShowForm",
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
import InputSwitch from "primevue/inputswitch";
import Textarea from "primevue/textarea";
import LvgRichSelect from "@/Components/LvgRichSelect.vue";
</script>

<style scoped></style>
