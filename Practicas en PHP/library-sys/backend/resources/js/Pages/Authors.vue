<template>
    <v-alert
        v-if="alert.show"
        :type="alert.type"
        dismissible
        @input="alert.show = true"
        variant="tonal"
        border="start"
    >
        {{ alert.message }}
    </v-alert>
    <v-sheet border rounded>
        <v-data-table
            :headers="headers"
            :hide-default-footer="authors.length < 11"
            :items="authors"
            item-value="id"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <v-icon
                            color="medium-emphasis"
                            icon="mdi-book-account"
                            size="x-small"
                            start
                        ></v-icon>

                        Tabla de Autores
                    </v-toolbar-title>

                    <v-btn
                        class="me-2"
                        prepend-icon="mdi-plus"
                        rounded="lg"
                        text="Añade un autor"
                        border
                        @click="addAuthor()"
                    ></v-btn>
                </v-toolbar>
            </template>

            <template v-slot:item.title="{ value }">
                <v-chip
                    :text="value"
                    border="thin opacity-25"
                    prepend-icon="mdi-book-account"
                    label
                >
                    <template v-slot:prepend>
                        <v-icon color="medium-emphasis"></v-icon>
                    </template>
                </v-chip>
            </template>
            <template v-slot:item.name="{ value }">
                <v-chip
                    :text="value"
                    border="thin opacity-25"
                    prepend-icon="mdi-account-outline"
                    label
                >
                    <template v-slot:prepend>
                        <v-icon color="medium-emphasis"></v-icon>
                    </template>
                </v-chip>
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
        <v-form v-model="form" @submit="save()">
            <v-card
                :subtitle="`${isEditing ? 'Update' : 'Añade'} un autor`"
                :title="`${isEditing ? 'Edit' : 'Añadir'}`"
            >
                <template v-slot:text>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="name"
                                label="Nombre"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="lastname"
                                label="Apellido"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                :rules="[required]"
                                :readonly="loading"
                                v-model="country"
                                label="Pais de Procedencia"
                                clearable
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </template>

                <v-divider></v-divider>

                <v-card-actions class="bg-surface-light">
                    <v-btn
                        text="Cancel"
                        variant="plain"
                        @click="dialog = false"
                    ></v-btn>

                    <v-spacer></v-spacer>

                    <v-btn
                        :disabled="!form"
                        :loading="loading"
                        text="Save"
                        type="submit"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script setup lang="ts">
import { Inertia } from "@inertiajs/inertia";
import MainLayout from "../Layouts/MainLayout.vue";
const alert = ref({ show: false, message: "", type: "" });
const props = defineProps<{ authors: Array<any> }>();
// const authors = ref([...props.authors]);
const authors = computed(() => props.authors);
function required(v) {
    return !!v || "Este campo es requerido";
}
const form = ref(false);
const editId = ref(null);
const name = ref(null);
const lastname = ref(null);
const country = ref(null);
const loading = ref(false);

defineOptions({
    layout: MainLayout,
});
import { computed, onMounted, ref, shallowRef } from "vue";
import { usePage } from "@inertiajs/vue3";

const dialog = shallowRef(false);
const isEditing = shallowRef(false);

const headers = [
    { title: "Nombre", key: "name", align: "start" },
    { title: "Apellido", key: "lastname" },
    { title: "Pais de Procedencia", key: "country" },
    { title: "Actions", key: "actions", align: "end", sortable: false },
];

onMounted(() => {
    reset();
});

function showAlert(message, type) {
    alert.value = { show: true, message, type };
    setTimeout(() => (alert.value.show = false), 3000);
}

function addAuthor() {
    isEditing.value = false;
    dialog.value = true;
}

function edit(id: string) {
    isEditing.value = true;

    const authors = computed(() => usePage().props.authors ?? []);
    const found = authors.value.find((a) => a && a.id === id);

    console.log(found);
    editId.value = found.id;
    name.value = found.name;
    lastname.value = found.lastname;
    country.value = found.country;

    dialog.value = true;
}

function remove(id) {
    const index = authors.value.findIndex((author) => author.id === id);
    authors.value.splice(index, 1);
}
function save() {
    if (!form.value) return;
    const payload = {
        name: name.value,
        lastname: lastname.value,
        country: country.value,
    };
    if (isEditing.value) {
        loading.value = true;
        Inertia.put(`/authors/${editId.value}`, payload, {
            onSuccess: () => {
                dialog.value = false;
                showAlert("Autor actualizado exitosamente", "success");
            },
            onError: (error) => {
                dialog.value = false;
                showAlert(error, "error");
            },
            onFinish: () => {
                dialog.value = false;
                loading.value = false;
                reset();
            },
        });
    } else {
        loading.value = true;
        Inertia.post("/authors", payload, {
            onSuccess: (event) => {
                dialog.value = false;
                showAlert("Autor creado exitosamente", "success");
            },
            onError: (error) => {
                dialog.value = false;
                showAlert(error, "error");
            },
            onFinish: () => {
                reset();
                loading.value = false;
                showAlert("Autor creado exitosamente", "success");
            },
        });
    }
}
function reset() {
    console.log("running reset");
    dialog.value = false;
    name.value = null;
    lastname.value = null;
    country.value = null;
}
</script>
