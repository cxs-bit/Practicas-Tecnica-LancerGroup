<template>
    <v-alert
        v-if="alert.show"
        :type="alert.type"
        dismissible
        @input="alert.show = true"
        variant="elevated"
        border="start"
        location="top center"
        elevation="24"
        class="position-fixed"
        style="
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 300px;
            max-width: 50%;
        "
    >
        {{ alert.message }}
    </v-alert>

    <v-sheet border rounded>
        <v-data-table
            v-model:search="search"
            :filter-keys="['name', 'edition', 'publish_date']"
            :headers="headers"
            :hide-default-footer="books.length < 11"
            :items="books"
            item-value="id"
            :sort-by="[{ key: 'name', order: 'asc' }]"
        >
            <template v-slot:top>
                <v-toolbar>
                    <v-toolbar-title>
                        <v-icon
                            color="medium-emphasis"
                            icon="mdi-book"
                            size="x-small"
                            start
                        ></v-icon>
                        Tabla de Libros
                    </v-toolbar-title>
                    <v-text-field
                        v-model="search"
                        density="compact"
                        label="Buscar"
                        prepend-inner-icon="mdi-magnify"
                        variant="solo"
                        flat
                        hide-details
                        single-line
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="me-2"
                        prepend-icon="mdi-plus"
                        rounded="lg"
                        text="Añade un libro"
                        border
                        @click="add()"
                    ></v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.name="{ value }">
                <v-chip
                    :text="value"
                    border="thin opacity-25"
                    prepend-icon="mdi-book-open-variant-outline"
                    label
                >
                    <template v-slot:prepend>
                        <v-icon color="medium-emphasis"></v-icon>
                    </template>
                </v-chip>
            </template>
            <template v-slot:item.publish_date="{ value }">
                <v-chip
                    :text="value"
                    border="thin opacity-25"
                    prepend-icon="mdi-calendar"
                    label
                >
                    <template v-slot:prepend>
                        <v-icon color="medium-emphasis"></v-icon>
                    </template>
                </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
                <div class="d-flex ga-2 justify-end">
                    <v-btn
                        color="secondary"
                        prepend-icon="mdi-information"
                        variant="tonal"
                        size="small"
                        text="Ver mas"
                        :href="`/books/${item.id}`"
                        link
                    ></v-btn>
                    <v-btn
                        color="success"
                        prepend-icon="mdi-pencil"
                        variant="tonal"
                        size="small"
                        text="Editar"
                        @click="edit(item.id)"
                    ></v-btn>
                    <v-btn
                        color="error"
                        prepend-icon="mdi-delete"
                        variant="tonal"
                        size="small"
                        text="Borrar"
                        @click="remove(item.id)"
                    ></v-btn>
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
        <v-form v-model="form" @submit="save()">
            <v-card
                :subtitle="`${isEditing ? 'Actualiza' : 'Añade'} un libro`"
                :title="`${isEditing ? 'Editar' : 'Añadir'}`"
            >
                <template v-slot:text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="name"
                                label="Nombre"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="edition"
                                label="Edicion"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="publish_date"
                                label="Fecha de Publicacion"
                                type="date"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-select
                                v-model="authors"
                                :items="book_authors"
                                item-title="name"
                                item-value="id"
                                label="Autores"
                                :readonly="loading"
                                :rules="[required]"
                                multiple
                                chips
                                clearable
                                persistent-hint
                                hint="Selecciona uno o más autores"
                            ></v-select>
                        </v-col>
                    </v-row>
                </template>

                <v-divider></v-divider>

                <v-card-actions class="bg-surface-light">
                    <v-btn
                        text="Cancelar"
                        variant="plain"
                        @click="dialog = false"
                    ></v-btn>

                    <v-spacer></v-spacer>

                    <v-btn
                        :disabled="!form"
                        :loading="loading"
                        text="Guardar"
                        type="submit"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script setup lang="ts">
defineOptions({
    layout: MainLayout,
});

import { Inertia } from "@inertiajs/inertia";
import MainLayout from "../Layouts/MainLayout.vue";
import { computed, onMounted, ref, shallowRef, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps<{
    books: Array<any>;
    authors: Array<any>;
    errors?: Record<string, string>;
}>();
const errors = computed(() => usePage().props.errors ?? {});
const books = computed(() => props.books);
const book_authors = computed(() => props.authors);
const form = ref(false);
const editId = ref(null);
const name = ref(null);
const edition = ref(null);
const publish_date = ref(null);
const authors = shallowRef([]);
const loading = ref(false);
const dialog = shallowRef(false);
const isEditing = shallowRef(false);
const search = ref("");

const headers = [
    { title: "Nombre", key: "name", align: "start" as const },
    { title: "Edición", key: "edition" },
    { title: "Fecha de Publicación", key: "publish_date" },
    {
        title: "Acciones",
        key: "actions",
        align: "center" as const,
        sortable: false,
    },
];

onMounted(() => {
    reset();
});

// Alerts
const alert = ref({ show: false, message: "", type: "" });
watchEffect(() => {
    const page = usePage();
    if (page.props.flash && page.props.flash.success) {
        showAlert(page.props.flash.success, "success");
    }
    if (page.props.flash && page.props.flash.error) {
        showAlert(page.props.flash.error, "error");
    }
    if (errors.value && Object.keys(errors.value).length > 0) {
        Object.values(errors.value).forEach((msg) => {
            showAlert(msg as string, "error");
        });
    }
});

function showAlert(
    message: string,
    type: "success" | "error" | "info" | "warning",
) {
    alert.value = { show: true, message, type };
    setTimeout(() => (alert.value.show = false), 3000);
}

// Functions
function required(v) {
    return !!v || "Este campo es requerido";
}

function add() {
    isEditing.value = false;
    dialog.value = true;
}

function edit(id: string) {
    isEditing.value = true;

    const booksList = computed(() => usePage().props.books ?? []);
    const found = booksList.value.find((b: any) => b && b.id === id);

    editId.value = found.id;
    name.value = found.name;
    edition.value = found.edition;
    publish_date.value = found.publish_date;
    authors.value = found.authors ? found.authors.map((a: any) => a.id) : [];
    dialog.value = true;
    console.log(found);
}

function remove(id: string) {
    Inertia.delete(`/books/${id}`, {
        onBefore: () => {
            return confirm("Estas seguro que quieres eliminar este libro?");
        },
        onFinish: () => {
            reset();
        },
    });
}
function save() {
    if (!form.value) return;
    const payload = {
        name: name.value,
        edition: edition.value,
        publish_date: publish_date.value,
        authors: authors.value,
    };
    if (isEditing.value) {
        loading.value = true;
        Inertia.put(`/books/${editId.value}`, payload, {
            onFinish: () => {
                dialog.value = false;
                loading.value = false;
                reset();
            },
        });
    } else {
        loading.value = true;
        Inertia.post("/books", payload, {
            onFinish: () => {
                reset();
                loading.value = false;
            },
        });
    }
}
function reset() {
    dialog.value = false;
    name.value = null;
    edition.value = null;
    publish_date.value = null;
}
</script>
