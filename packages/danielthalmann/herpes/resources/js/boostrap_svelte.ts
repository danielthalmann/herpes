import { mount } from 'svelte'
import Customers from './pages/Customers.svelte'

// import Demo from './pages/Demo.svelte'
/*
import { register, init, getLocaleFromNavigator } from 'svelte-i18n';

register('fr', () => import('./i18n/fr.json'));
init({
  fallbackLocale: 'fr',
  initialLocale: getLocaleFromNavigator(),
});
*/

let app:any = null;
if (document.getElementById('customer')) {
    app = mount(Customers, {
      target: document.getElementById('customer')!,
      props: { api: document.getElementById('customer')!.dataset.url }
    })
}
export default app
