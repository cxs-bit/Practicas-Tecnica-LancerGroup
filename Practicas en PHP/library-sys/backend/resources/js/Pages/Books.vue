<template>
    <v-sheet border rounded>
        <v-data-table
            :headers="headers"
            :hide-default-footer="books.length < 11"
            :items="books"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <v-icon
                            color="medium-emphasis"
                            icon="mdi-book-multiple"
                            size="x-small"
                            start
                        ></v-icon>

                        Tabla de Libros
                    </v-toolbar-title>

                    <v-btn
                        class="me-2"
                        prepend-icon="mdi-plus"
                        rounded="lg"
                        text="Add a Book"
                        border
                        @click="add"
                    ></v-btn>
                </v-toolbar>
            </template>

            <template v-slot:item.title="{ value }">
                <v-chip
                    :text="value"
                    border="thin opacity-25"
                    prepend-icon="mdi-book"
                    label
                >
                    <template v-slot:prepend>
                        <v-icon color="medium-emphasis"></v-icon>
                    </template>
                </v-chip>
            </template>

            <template #item.authors="{ item }">
                <span>
                    {{ item.authors.map((author) => author.name).join(", ") }}
                </span>
            </template>

            <template v-slot:item.actions="{ item }">
                <div class="d-flex ga-2 justify-end">
                    <v-icon
                        color="medium-emphasis"
                        icon="mdi-pencil"
                        size="small"
                        @click="edit(item.id)"
                    ></v-icon>

                    <v-icon
                        color="medium-emphasis"
                        icon="mdi-delete"
                        size="small"
                        @click="remove(item.id)"
                    ></v-icon>
                </div>
            </template>
            <template v-slot:no-data>
                <v-btn
                    prepend-icon="mdi-backup-restore"
                    rounded="lg"
                    text="Reset data"
                    variant="text"
                    border
                    @click="reset"
                ></v-btn>
            </template>
        </v-data-table>
    </v-sheet>

    <v-dialog v-model="dialog" max-width="500">
        <v-card
            :subtitle="`${isEditing ? 'Update' : 'Añade'} tu libro favorito`"
            :title="`${isEditing ? 'Edit' : 'Añadir'}`"
        >
            <template v-slot:text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="record.name"
                            label="Nombre"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="record.authors"
                            label="Autor"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-col cols="12" md="6">
                    <v-date-picker
                        v-model="record.year"
                        :max="adapter.getYear(adapter.date())"
                        :min="1"
                        label="Year"
                    ></v-date-picker>
                </v-col>
            </template>

            <v-divider></v-divider>

            <v-card-actions class="bg-surface-light">
                <v-btn
                    text="Cancel"
                    variant="plain"
                    @click="dialog = false"
                ></v-btn>

                <v-spacer></v-spacer>

                <v-btn text="Save" @click="save"></v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script setup lang="ts">
import MainLayout from "../Layouts/MainLayout.vue";

const props = defineProps<{ books: Array<any> }>();
const books = ref([...props.books]);

defineOptions({
    layout: MainLayout,
});

import { onMounted, ref, shallowRef } from "vue";
import { useDate } from "vuetify";

const adapter = useDate();

const DEFAULT_RECORD = {
    name: "",
    edition: "",
    publish_date: "",
    authors: "",
    pages: 1,
};

const record = ref(DEFAULT_RECORD);
const dialog = shallowRef(false);
const isEditing = shallowRef(false);

const headers = [
    { title: "Name", key: "name" },
    { title: "Edition", key: "edition" },
    { title: "Publish Date", key: "publish_date" },
    { title: "Authors", key: "authors" },
    { title: "Actions", key: "actions", align: "end", sortable: false },
];

onMounted(() => {
    reset();
});

function add() {
    isEditing.value = false;
    record.value = DEFAULT_RECORD;
    dialog.value = true;
}

function edit(id) {
    isEditing.value = true;

    const found = books.value.find((book) => book.id === id);

    record.value = {
        id: found.id,
        title: found.title,
        author: found.author,
        genre: found.genre,
        year: found.year,
        pages: found.pages,
    };

    dialog.value = true;
}

function remove(id) {
    const index = books.value.findIndex((book) => book.id === id);
    books.value.splice(index, 1);
}

function save() {
    if (isEditing.value) {
        const index = books.value.findIndex(
            (book) => book.id === record.value.id,
        );
        books.value[index] = record.value;
    } else {
        record.value.id = books.value.length + 1;
        books.value.push(record.value);
    }

    dialog.value = false;
}

function reset() {
    dialog.value = false;
    record.value = DEFAULT_RECORD;
    books.value = books;
}
</script>
