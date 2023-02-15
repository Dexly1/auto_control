import { createRouter, createWebHistory } from 'vue-router'
import AuthPage from '../components/AuthPage.vue'
import RecordsList from '../components/RecordsList.vue'
import RecordEdit from '../components/RecordEdit.vue'
import AutosList from '../components/AutosList.vue'
import AutosInPlace from '../components/AutosInPlace.vue'
import AutosOutPlace from '../components/AutosOutPlace.vue'
import RecordPhotoEdit from '../components/RecordPhotoEdit.vue'
import ChangesList from '../components/ChangesList.vue'
import AddAuto from '../components/AddAuto.vue'
import BrandsList from '../components/BrandsList.vue'
import ModelsList from '../components/ModelsList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'AuthPage',
      component: AuthPage
    },
    {
      path: '/records',
      name: 'RecordsList',
      component: RecordsList
    },
    {
      path: '/records/edit',
      name: 'RecordEdit',
      component: RecordEdit
    },
    {
      path: '/autos',
      name: 'AutosList',
      component: AutosList
    },
    {
      path: '/autosInPlace',
      name: 'AutosInPlace',
      component: AutosInPlace
    },
    {
      path: '/autosOutPlace',
      name: 'AutosOutPlace',
      component: AutosOutPlace
    },
    {
      path: '/recordPhotoEdit',
      name: 'RecordPhotoEdit',
      component: RecordPhotoEdit
    },
    {
      path: '/changes',
      name: 'ChangesList',
      component: ChangesList
    },
    {
      path: '/autos/add',
      name: 'AddAuto',
      component: AddAuto
    },
    {
      path: '/brands',
      name: 'BrandsList',
      component: BrandsList
    },
    {
      path: '/models',
      name: 'ModelsList',
      component: ModelsList
    }
  ]
})

export default router
