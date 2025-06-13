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
                    href="/authors"
                >
                    Atras
                </v-btn>
            </v-col>
            <v-col cols="12" md="6" class="d-flex justify-end">
                <v-btn
                    color="purple"
                    variant="tonal"
                    append-icon="mdi-arrow-right"
                    class="mb-4"
                    link
                    href="/books"
                >
                    Libros
                </v-btn>
            </v-col>
        </v-row>
        <v-card elevation="4" class="pa-6 rounded">
            <v-row>
                <v-col cols="12" class="text-center">
                    <v-avatar size="96" class="mb-4">
                        <v-icon size="96" color="deep-purple-darken-2"
                            >mdi-account</v-icon
                        >
                    </v-avatar>
                    <h1 class="mb-1">
                        {{ author.name }} {{ author.lastname }}
                    </h1>
                    <v-chip color="grey-darken-1" class="mb-2">
                        <strong>ID:</strong>&nbsp;{{ author.id }}
                    </v-chip>
                </v-col>
            </v-row>
            <v-divider class="my-4"></v-divider>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title
                            >Pais de Procedencia</v-list-item-title
                        >
                        <v-list-item-subtitle>{{
                            author.country || "N/A"
                        }}</v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title>Fecha de Registro</v-list-item-title>
                        <v-list-item-subtitle>
                            {{
                                author.register_date
                                    ? new Date(
                                          author.register_date,
                                      ).toLocaleDateString()
                                    : "N/A"
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title
                            >Fecha de ultima Actualizacion</v-list-item-title
                        >
                        <v-list-item-subtitle>
                            {{
                                author.updated_at
                                    ? new Date(
                                          author.updated_at,
                                      ).toLocaleString()
                                    : "N/A"
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list-item>
                        <v-list-item-title
                            >Libros Registrados</v-list-item-title
                        >
                        <v-list-item-subtitle>
                            {{
                                author.number_of_books_registered ??
                                (author.books ? author.books.length : 0)
                            }}
                        </v-list-item-subtitle>
                    </v-list-item>
                </v-col>
            </v-row>
            <v-divider class="my-4"></v-divider>
            <v-row>
                <v-col cols="12">
                    <h2 class="mb-2">
                        Libros
                        <v-icon
                            size="x-small"
                            start
                            color="medium-emphasis"
                            icon="mdi-book-open-page-variant-outline"
                        ></v-icon>
                    </h2>
                    <v-list
                        v-if="author.books && author.books.length"
                        lines="two"
                    >
                        <v-list-item
                            v-for="book in author.books"
                            :key="book.id"
                            class="mb-2"
                        >
                            <v-list-item-content>
                                <v-list-item-title>
                                    <span>
                                        <a
                                            v-if="book.id"
                                            :href="`/books/${book.id}`"
                                            class="text-decoration-none"
                                        >
                                            <strong>{{ book.name }}</strong>
                                        </a>
                                        <strong v-else>{{ book.name }}</strong>
                                    </span>
                                    <span v-if="book.edition">
                                        (Edicion: {{ book.edition }})
                                    </span>
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="book.publish_date">
                                    Publicado: {{ book.publish_date }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-alert v-else type="info" variant="tonal" class="mt-2">
                        No hay libros registrados.</v-alert
                    >
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
defineProps<{ author: any }>();
</script>
