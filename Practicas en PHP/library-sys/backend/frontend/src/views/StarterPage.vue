<script setup lang="ts">
import { ref, shallowRef } from 'vue';

import BaseBreadcrumb from '@/components/shared/BaseBreadcrumb.vue';
import UiParentCard from '@/components/shared/UiParentCard.vue';

const page = ref({ title: 'Sample Page' });
const breadcrumbs = shallowRef([
  {
    title: 'Others',
    disabled: false,
    href: '#'
  },
  {
    title: 'Sample Page',
    disabled: true,
    href: '#'
  }
]);
</script>

<template>
  <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
  <v-row>
    <v-col cols="12" md="12">
      <UiParentCard title="Simple Title"> </UiParentCard>
    </v-col>
  </v-row>
</template>
