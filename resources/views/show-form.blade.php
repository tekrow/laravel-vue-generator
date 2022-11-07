@php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
@endphp
<template>
    <dl class="gap-4">
@foreach($columns as $column)
        <lvg-dd>
            <template #dt>{{$column['label']}}:</template>
            {{'{{'}} model.{{$column['name']}} }}
        </lvg-dd>
@endforeach
    @if (isset($relations['belongsTo']) && count($relations["belongsTo"]))
@foreach($relations["belongsTo"] as $parent)
        <lvg-dd>
            <template #dt>{{$parent['related_model_title']}}:</template>
            {{'{{'}} model.{{$parent['relationship_variable']}} ? model.{{$parent['relationship_variable']}}.{{$parent["label_column"]}} : '-' }}
        </lvg-dd>
@endforeach
    @endif
</dl>
</template>

<script>
    import LvgDd from "@/LvgComponents/LvgDd.vue";
    import InertiaButton from "@/LvgComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "Show{{$modelPlural}}Form",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            LvgDd,
        },
        data() {
            return {}
        },
        mounted() {},
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {}
    });
</script>

<style scoped>

</style>
