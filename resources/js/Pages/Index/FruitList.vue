<template>
    <ul>
        <li class="m-4" v-for="(fruit, i) in fruits" :key="fruit.id">
            <jet-input type="text" :id="fruit.id" v-model="form[fruit.id]['label']"/>

            <template v-if="fruit.children.length > 0">
                <fruit-list :fruits="fruit.children"></fruit-list>
            </template>
        </li>
    </ul>
</template>

<script>
import JetInput from '@/Jetstream/Input'
import { inject, ref } from 'vue';

export default {
    props: ['fruits'],

    components: {
        JetInput
    },

    setup(props) {
        let form = inject('form');

        return {
            form
        }
    }
}
</script>

<style scoped>
li
{
    list-style: disc;
}
ul > li > ul
{
    padding-left: 20px;
}
</style>