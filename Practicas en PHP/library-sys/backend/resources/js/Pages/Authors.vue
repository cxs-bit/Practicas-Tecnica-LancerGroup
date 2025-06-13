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
                        icon="mdi-info"
                        size="small"
                        @click="edit(item.id)"
                    ></v-icon>
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

const props = defineProps<{ authors: Array<any> }>();
const authors = computed(() => props.authors);
const form = ref(false);
const editId = ref(null);
const name = ref(null);
const lastname = ref(null);
const country = ref(null);
const loading = ref(false);
const dialog = shallowRef(false);
const isEditing = shallowRef(false);

const headers = [
    { title: "Nombre", key: "name", align: "start" },
    { title: "Apellido", key: "lastname" },
    { title: "Pais de Procedencia", key: "country" },
    { title: "Acciones", key: "actions", align: "end", sortable: false },
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

function remove(id: string) {
    Inertia.delete(`/authors/${id}`, {
        onBefore: () => {
            return confirm("Estas seguro que quieres eliminar a este autor?");
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
        lastname: lastname.value,
        country: country.value,
    };
    if (isEditing.value) {
        loading.value = true;
        Inertia.put(`/authors/${editId.value}`, payload, {
            onFinish: () => {
                dialog.value = false;
                loading.value = false;
                reset();
            },
        });
    } else {
        loading.value = true;
        Inertia.post("/authors", payload, {
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
    lastname.value = null;
    country.value = null;
}
</script>
