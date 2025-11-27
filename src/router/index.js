import { createRouter, createWebHistory } from 'vue-router'


import Home from '@/components/Home.vue'
import Login from '@/components/Login.vue'
import Dashboard from '@/components/DashBoard.vue'
import AdminV from '@/components/Admin.vue'

import SupplierList from '@/components/SupplierList.vue'
import SupplierDetails from '@/components/SupplierDetails.vue'

import CarbonInput from '@/components/CarbonEmissionsInputForm.vue'
import CarbonSummary from '@/components/CarbonEmissionsSummaryPage.vue'
import WasteInput from '@/components/WasteTrackingInputForm.vue'
import WasteSummary from '@/components/WasteSummaryPage.vue'
import ResourceInput from '@/components/ResourceUsageInputForm.vue'
import ResourceSummary from '@/components/ResourceUsageSummary.vue'
import Trends from '@/components/Trends.vue'


const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/dashboard', name: 'Dashboard', component: DashboardView },
  { path: '/settings', name: 'Settings', component: SettingsView },
  { path: '/admin', name: 'Admin', component: AdminView },

  { path: '/suppliers', name: 'SupplierList', component: SupplierListView },
  { path: '/supplier/add', name: 'AddSupplier', component: AddSupplierView },
  { path: '/supplier/:id', name: 'SupplierDetails', component: SupplierDetailsView },
  { path: '/supplier/:id/score', name: 'SupplierScore', component: SupplierScoreView },

  { path: '/carbon/input', name: 'CarbonInput', component: CarbonInputView },
  { path: '/carbon/summary', name: 'CarbonSummary', component: CarbonSummaryView },
  { path: '/waste/input', name: 'WasteInput', component: WasteInputView },
  { path: '/waste/summary', name: 'WasteSummary', component: WasteSummaryView },
  { path: '/resources/input', name: 'ResourceInput', component: ResourceInputView },
  { path: '/resources/summary', name: 'ResourceSummary', component: ResourceSummaryView },

  
  { path: '/trends', name: 'Trends', component: TrendsView },
  { path: '/insights', name: 'Insights', component: InsightsView },

  { path: '/:pathMatch(.*)*', redirect: '/' } 
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const isLoggedIn = JSON.parse(localStorage.getItem('isLoggedIn'))
  const isAdmin = JSON.parse(localStorage.getItem('isAdmin')) || false

  
  if (to.path === '/admin' && (!isLoggedIn || !isAdmin)) {
    return next('/login')
  }


  const protectedPaths = [
    '/dashboard','/settings','/suppliers','/supplier/add',
    '/carbon/input','/carbon/summary','/waste/input','/waste/summary',
    '/resources/input','/resources/summary','/reports','/trends','/insights'
  ]
  if (protectedPaths.includes(to.path) && !isLoggedIn) {
    return next('/login')
  }

  next()
})

export default router
