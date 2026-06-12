import { mount } from 'svelte'
import Customers from './pages/Customers.svelte'
import AddressCustomers from './pages/AddressCustomers.svelte'

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
      props: { api: document.getElementById('customer')!.dataset }
    })
}
if (document.getElementById('address-customer')) {
    app = mount(AddressCustomers, {
      target: document.getElementById('address-customer')!,
      props: { api: document.getElementById('address-customer')!.dataset }
    })
}
export default app
