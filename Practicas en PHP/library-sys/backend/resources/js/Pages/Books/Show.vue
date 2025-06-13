<template>
    <v-container class="py-8" max-width="1000">
        <v-row>
            <v-col cols="12" md="6" class="d-flex justify-start">
                <v-btn
                    color="purple"
                    variant="tonal"
                    prepend-icon="mdi-arrow-left"
                    class="mb-4"
                    link
                    href="/books"
                >
                    Back
                </v-btn>
            </v-col>
            <v-col cols="12" md="6" class="d-flex justify-end">
                <v-btn
                    color="purple"
                    variant="tonal"
                    append-icon="mdi-arrow-right"
                    class="mb-4"
                    link
                    href="/authors"
                >
                    Autores
                </v-btn>
            </v-col>
        </v-row>
        <v-card elevation="4" class="pa-6 rounded">
            <v-row>
                <v-col cols="12" class="text-center">
                    <v-avatar size="128" class="mb-4">
                        <v-icon size="96" color="deep-purple-darken-2"
                            >mdi-book-open-page-variant</v-icon
                        >
                    </v-avatar>
                    <h1 class="mb-1">
                        {{ book.name }}
                    </h1>
                    <v-chip color="grey-darken-1" class="mb-2">
                        <strong>ID:</strong>&nbsp;{{ book.id }}
                    </v-chip>
                </v-col>
            </v-row>
            <v-divider class="my-4"></v-divider>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title>Autores</v-list-item-title>
                        <v-list-item-subtitle>
                            <span v-if="book.authors && book.authors.length">
                                <span
                                    v-for="(author, idx) in book.authors"
                                    :key="author.id"
                                >
                                    <span v-if="!author.deleted_at">
                                        <a
                                            :href="`/authors/${author.id}`"
                                            class="text-decoration-none"
                                        >
                                            {{ author.name }}
                                            {{ author.lastname }}
                                        </a>
                                    </span>
                                    <span v-else>
                                        {{ author.name }} {{ author.lastname }}
                                    </span>
                                    <span v-if="idx < book.authors.length - 1"
                                        >,
                                    </span>
                                </span>
                            </span>
                            <span v-else>N/A</span>
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title
                            >Fecha de Publicación</v-list-item-title
                        >
                        <v-list-item-subtitle>
                            {{
                                book.publish_date
                                    ? new Date(
                                          book.publish_date,
                                      ).toLocaleDateString()
                                    : "N/A"
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title>Edición</v-list-item-title>
                        <v-list-item-subtitle>
                            {{ book.edition || "N/A" }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title>Fecha de Registro</v-list-item-title>
                        <v-list-item-subtitle>
                            {{
                                book.created_at
                                    ? new Date(
                                          book.created_at,
                                      ).toLocaleDateString()
                                    : "N/A"
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title
                            >Fecha de última Actualización</v-list-item-title
                        >
                        <v-list-item-subtitle>
                            {{
                                book.updated_at
                                    ? new Date(book.updated_at).toLocaleString()
                                    : "N/A"
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<script setup lang="ts">
import MainLayout from "../../Layouts/MainLayout.vue";
defineOptions({
    layout: MainLayout,
});
defineProps<{ book: any }>();
</script>
