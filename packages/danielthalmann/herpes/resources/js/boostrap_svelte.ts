import { mount } from 'svelte'
import Customers from './pages/Customers.svelte'
import AddressCustomers from './pages/AddressCustomers.svelte'
import Invoices from './pages/Invoices.svelte'
import InvoiceItems from './pages/InvoiceItems.svelte'
import Tickets from './pages/Tickets.svelte'
import Transactions from './pages/Transactions.svelte'

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
if (document.getElementById('invoices')) {
    app = mount(Invoices, {
      target: document.getElementById('invoices')!,
      props: { api: document.getElementById('invoices')!.dataset }
    })
}
if (document.getElementById('invoice-item')) {
    app = mount(InvoiceItems, {
      target: document.getElementById('invoice-item')!,
      props: { api: document.getElementById('invoice-item')!.dataset }
    })
}
if (document.getElementById('transactions')) {
    app = mount(Transactions, {
      target: document.getElementById('transactions')!,
      props: { api: document.getElementById('transactions')!.dataset }
    })
}
if (document.getElementById('tickets')) {
    app = mount(Tickets, {
      target: document.getElementById('tickets')!,
      props: { api: document.getElementById('tickets')!.dataset }
    })
}
export default app
