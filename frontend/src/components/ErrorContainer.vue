<template>
  <div
    v-if="props?.errors?.message"
    class="alert alert-danger"
    role="alert"
    style="height: auto"
  >
    <div v-if="errorList.length || props.errors.message">
      <div v-if="props.errors.message" style="color: red">
        {{ props.errors.message }}
      </div>
      <div v-for="(index, error) in errorList" :key="index">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  errors: {
    default: null,
    type: Object,
  },
});

let errorsParse = ref([]);

const buildErrorList = () => {
  if (props.errors.details !== undefined) {
    let propertyList = Object.getOwnPropertyNames(props.errors.details);
    if (propertyList && propertyList.length) {
      errorsParse.value =
        propertyList &&
        propertyList.map((item) => {
          return item + " : " + props.errors.details[item].join(",");
        });
    }
  } else {
    errorsParse.value = [];
  }
  return errorsParse;
};

const errorList = computed(() => {
  return buildErrorList();
});
</script>

<style scoped></style>
