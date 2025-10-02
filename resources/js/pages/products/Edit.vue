<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';


interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{ product: Product }>();
const form = useForm({
    name: props.product.name,
    price: props.product.price,
    description: props.product.description,
});

const handleSubmit = () => {
    console.log(form);
    form.put('/products/' + props.product.id)
}

</script>

<template>
    <Head title="Modifier un produit" />

    <AppLayout :breadcrumbs="[{
            title: 'Modifier un produit',
            href: `/products/${props.product.id}/edit`,
        },]">
        <div
            class="p-4 justify-center flex"
        >
            <form @submit.prevent="handleSubmit" action="" class="w-8/12 space-y-4 ">
                <div class="space-y-2">
                    <Label for="name">Nom du produit</Label>
                    <Input v-model="form.name" type="text" placeholder="Nom du produit"></Input>
                    <div v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="price">Prix du produit</Label>
                    <Input v-model="form.price" type="number" placeholder="Prix du produit"></Input>
                    <div v-if="form.errors.price" class="text-red-600 text-sm">{{ form.errors.price }}</div>
                </div>

                <div class="space-y-2">
                    <Label for="description">Description du produit</Label>
                    <textarea v-model="form.description" placeholder="Description du produit" class="w-full border rounded-md p-5"></textarea>
                    <div v-if="form.errors.description" class="text-red-600 text-sm">{{ form.errors.description }}</div>
                </div>

                <Button type="submit" :disabled="form.processing">Modifier un produit</Button>
            </form>
        </div>
    </AppLayout>
</template>
