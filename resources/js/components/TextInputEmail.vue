<!--<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { CFormLabel, CInputGroup, CInputGroupText, CFormInput } from '@coreui/vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEnvelope } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faEnvelope);

defineProps<{
  modelValue: string;
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
  if (input.value && input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <CFormLabel for="validationCustomUsername">Correo Electrónico</CFormLabel>
  <CInputGroup class="has-validation">
    <CInputGroupText id="inputGroupPrepend">
      <FontAwesomeIcon icon="envelope" />
    </CInputGroupText>
    <CFormInput
      id="validationCustomUsername"
      aria-describedby="inputGroupPrepend"
      feedbackInvalid="Ingresa tu correo electrónico"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
      required
      placeholder="ejemplo@gmail.com"
    />
  </CInputGroup>
</template>-->



<script setup lang="ts">
import { onMounted, ref } from 'vue';
import '@coreui/coreui/dist/css/coreui.min.css';
import { CFormLabel, CInputGroup, CInputGroupText, CFormInput } from '@coreui/vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEnvelope } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faEnvelope);

defineProps<{
    modelValue: string;
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <CFormLabel for="validationCustomUsername">Correo Electrónico</CFormLabel>
      <CInputGroup class="has-validation">
        <CInputGroupText id="inputGroupPrepend"><font-awesome-icon icon="envelope" /></CInputGroupText>
        <CFormInput 
          id="validationCustomUsername"
          aria-describedby="inputGroupPrepend" 
          feedbackInvalid="Ingresa tu correo electrónico"
          :value="modelValue"
          @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
          ref="input"
          required
          placeholder="ejemplo@gmail.com"
        />
    </CInputGroup>
</template>