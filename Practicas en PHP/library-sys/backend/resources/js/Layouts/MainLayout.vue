<script lang="ts">
export default {
    name: "MainLayout",
};
</script>

<template>
    <v-layout>
        <v-app-bar app color="bg-purple">
            <v-toolbar-title>
                <v-icon icon="mdi-bookshelf"></v-icon>
                Biblioteca
            </v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer
            expand-on-hover
            rail
            class="bg-deep-purple"
            theme="dark"
            permanent
        >
            <v-list color="transparent" nav>
                <v-list-item
                    link
                    prepend-icon="mdi-view-dashboard"
                    title="Dashboard"
                    href="/"
                ></v-list-item>
                <v-list-item
                    link
                    prepend-icon="mdi-book"
                    title="Libros"
                    href="/books"
                ></v-list-item>
                <v-list-item
                    link
                    prepend-icon="mdi-book-account"
                    title="Autores"
                    href="/authors"
                ></v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main class="d-flex fill-height flex-column">
            <slot />
        </v-main>
    </v-layout>
</template>
