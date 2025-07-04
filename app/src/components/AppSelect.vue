<template>
  <AppInput
      v-model="search"
      type="text"
      :placeholder="placeholder"
      :name="'search-' + id"
  />
  <legend v-if="legend">{{legend}}</legend>
  <div class="list-container">
    <div v-for="(value, index) in filteredItems" :key="index + '-' + id">
      <label>
        <input
            type="checkbox"
            :id="`select-${value.id}-${id}`"
            @input="(event) => inputAction(event.target?.checked, value)"
            :checked="isIncluded(value)"
        />
        {{ value[labelInput] }}
      </label>
    </div>
  </div>
</template>

<script lang="ts">
export default defineComponent({
  name: "AppSelect",

  props: {
    modelValue: {
      type: Array as PropType<any[]>,
      require: true,
    },
    items: {
      type: Array as PropType<any[]>,
      require: true
    },
    labelInput: {
      type: String,
      require: true
    },
    placeholder: {
      type: String
    },
    legend: {
      type: String
    },
    id: {
      type: String,
      require: true,
    }
  },
  emits: ['update:modelValue'],

  data: () => ({
    search: '',
  }),

  computed: {
    filteredItems() {
      if(this.search !== '' && this.items?.length > 0) {
        return this.items.filter((item) => item[String(this.labelInput)].toLowerCase().includes(this.search.toLowerCase()));
      }
      return this.items;
    },
    selected: {
      get(): any[] {
        return this.modelValue;
      },
      set(value: any[]) {
        this.$emit('update:modelValue', value.filter(item => item !== null));
      }
    }
  },

  methods: {
    inputAction(checked: boolean, value: any) {
      let internalSelected = [];
      if(checked) {
        internalSelected = [...this.selected, value];
      } else {
        internalSelected = this.selected.filter((item: any) => item.id !== value.id);
      }
      this.selected = internalSelected;
    },
    isIncluded(value: any) {
      return this.selected.some((item: any) => item.id === value.id);
    }
  }
})
</script>

<style scoped lang="scss">
.list-container{
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 10rem;
}
label {
  display: flex;
  flex-direction: row;
  gap:1rem;
}
</style>