<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Rocket } from 'lucide-vue-next';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'products',
        href: '/products',
    },
];

const page = usePage();

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    products: Product[];
}

//get props from Inertia
const props = defineProps<Props>();

const formatDate = (date: string) =>
  new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  }).format(new Date(date));

const handleDelete = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer ce produit ?')) {
        router.delete('/products/' + id);
    }   
}
</script>

<template>
    <Head title="produits" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="p-4"
        >
            <div v-if="page.props.flash?.message" class="mb-4">
                <Alert class="bg-blue-200 mb-4">
                    <Rocket class="h-5 w-5" />
                    <AlertTitle>Notification!</AlertTitle>
                    <AlertDescription>
                    {{ page.props.flash.message }}
                    </AlertDescription>
                </Alert>
            </div>   
            <div class="flex justify-end mb-4">
                <Link href="/products/add">
                    <Button>Ajouter un produit</Button>
                </Link>
            </div>
            <div>
                <Table>
                    <TableCaption>Liste des produits</TableCaption>
                    <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                        ID
                        </TableHead>
                        <TableHead>Nom</TableHead>
                        <TableHead>Prix</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead>Date de création</TableHead>
                        <TableHead class="text-center">
                        Action
                        </TableHead>
                    </TableRow>
                    </TableHeader>
                    <TableBody>
                    <TableRow v-for="product in props.products" :key="product.id">
                        <TableCell>{{ product.id }}</TableCell>
                        <TableCell class="font-medium">{{ product.name }}</TableCell>
                        <TableCell>{{ product.price }}</TableCell>
                        <TableCell>{{ product.description }}</TableCell>
                        <TableCell>{{ formatDate(product.created_at) }}</TableCell>
                        <TableCell class="text-center">
                        <Link :href="`/products/${product.id}/edit`">
                            <Button class="bg-blue-500 hover:bg-blue-600 text-white">Edit</Button>
                        </Link>
                        <Button variant="destructive" @click="handleDelete(product.id)" class="ml-2">Delete</Button>
                        
                        </TableCell>
                    </TableRow>
                    </TableBody>
                </Table>
            </div>        
            
        </div>
    </AppLayout>
</template>
