import { createApp } from 'vue'
import './style.css'

import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia';

const pinia = createPinia();

const formatToDecimal = (value) => {
  if (typeof value !== 'number') {
    return value;
  }

  return value.toLocaleString('en-US', {
    maximumFractionDigits: 2,
    minimumFractionDigits: 2,
  });
};

const app = createApp(App);

app.config.globalProperties.$formatToDecimal = formatToDecimal;

app
  .use(router)
  .use(pinia)
  .mount('#app');
