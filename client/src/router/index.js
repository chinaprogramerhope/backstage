import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/views/layout/Layout'

/** note: Submenu only appear when children.length>=1
 *  detail see  https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin','editor']     will control the page roles (you can set multiple roles)
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar,
    noCache: true                if true ,the page will no be cached(default is false)
  }
**/
export const constantRouterMap = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index')
      }
    ]
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/authredirect'),
    hidden: true
  },

  // 首页
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { title: '首页', icon: 'home', noCache: true }
      }
    ]
  },

  // 会员管理
  {
    path: '/vipManage',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true, // will always show the root menu
    meta: {
      title: '会员管理',
      icon: 'person-stalker',
      roles: ['admin', 'editor'] // you can set roles in root nav
    },
    children: [
      {
        path: 'vipTag',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '会员标签',
          roles: ['admin'] // or you can only set roles in sub nav
        }
      },
      {
        path: 'vipList',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '会员列表'
          // if do not set roles, means: this page does not require permission
        }
      },
      {
        path: 'vipLoginLog',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '会员登录日志'
        }
      },
      {
        path: 'vipLv',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '会员等级'
        }
      }
    ]
  },

  // 游戏管理
  {
    path: '/game',
    component: Layout,
    redirect: '/game/index',
    alwaysShow: true,
    meta: {
      title: '游戏管理',
      icon: 'poker'
    },
    children: [
      {
        path: 'gameGroup',
        component: () => import('@/views/game/gameGroup'),
        name: 'gameGroup',
        meta: {
          title: '游戏分组'
        }
      },
      {
        path: 'gameList',
        component: () => import('@/views/game/gameList'),
        name: 'gameList',
        meta: {
          title: '游戏列表'
        }
      },
      {
        path: 'betRecord',
        component: () => import('@/views/game/betRecord'),
        name: 'betRecord',
        meta: {
          title: '投注记录'
        }
      }
    ]
  },

  // 财务管理
  {
    path: '/finance',
    component: Layout,
    redirect: '/finance/index',
    alwaysShow: true,
    meta: {
      title: '财务管理',
      icon: 'money'
    },
    children: [
      {
        path: 'manualOperate',
        component: () => import('@/views/finance/manualOperate'),
        name: 'manualOperate',
        meta: {
          title: '人工存提'
        }
      },
      {
        path: 'officialCharge',
        component: () => import('@/views/finance/officialCharge'),
        name: 'officialCharge',
        meta: {
          title: '官方支付'
        }
      },
      {
        path: 'onlinePay',
        component: () => import('@/views/finance/onlinePay'),
        name: 'onlinePay',
        meta: {
          title: '线上支付'
        }
      },
      {
        path: 'alipayAudit',
        component: () => import('@/views/finance/alipayAudit'),
        name: 'alipayAudit',
        meta: {
          title: '支付宝出款审核'
        }
      },
      {
        path: 'bankCardAudit',
        component: () => import('@/views/finance/bankCardAudit'),
        name: 'bankCardAudit',
        meta: {
          title: '银行卡出款审核'
        }
      },
      {
        path: 'autopayTradeRecord',
        component: () => import('@/views/finance/autopayTradeRecord'),
        name: 'autopayTradeRecord',
        meta: {
          title: '自动出款交易记录'
        }
      },
      {
        path: 'financeConfig',
        component: () => import('@/views/finance/financeConfig'),
        name: 'financeConfig',
        meta: {
          title: '出入款配置'
        }
      }
    ]
  },

  // 公告管理
  {
    path: '/announce',
    component: Layout,
    redirect: '/announce/index',
    alwaysShow: true, // will always show the root menu
    meta: {
      title: '公告管理',
      icon: 'horn'
    },
    children: [
      {
        path: 'announceList',
        component: () => import('@/views/announce/announceList'),
        name: 'announceList',
        meta: {
          title: '公告列表'
        }
      },
      {
        path: 'stationMessage',
        component: () => import('@/views/announce/stationMessage'),
        name: 'stationMessage',
        meta: {
          title: '站内消息'
        }
      }
    ]
  },

  // 推广管理
  {
    path: '/promotion',
    component: Layout,
    redirect: '/promotion/index',
    alwaysShow: true,
    meta: {
      title: '推广管理',
      icon: 'promotion'
    },
    children: [
      {
        path: 'promitionUser',
        component: () => import('@/views/promotion/promitionUser'),
        name: 'promitionUser',
        meta: {
          title: '推广玩家'
        }
      },
      {
        path: 'promotionReport',
        component: () => import('@/views/promotion/promotionReport'),
        name: 'promotionReport',
        meta: {
          title: '推广报表'
        }
      },
      {
        path: 'promotionRebate',
        component: () => import('@/views/promotion/promotionRebate'),
        name: 'promotionRebate',
        meta: {
          title: '推广返利'
        }
      },
      {
        path: 'rebateSettings',
        component: () => import('@/views/promotion/rebateSettings'),
        name: 'rebateSettings',
        meta: {
          title: '返利设置'
        }
      }
    ]
  },

  // 系统设置
  {
    path: '/systemSettings',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true,
    meta: {
      title: '系统设置',
      icon: 'set'
    },
    children: [
      {
        path: 'subAccountManage',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '厅主子账号管理'
        }
      },
      {
        path: 'downloadSettings',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '下载设置'
        }
      },
      {
        path: 'roleManage',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '角色管理'
        }
      },
      {
        path: 'globalParam',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '全局参数'
        }
      },
      {
        path: 'personalDataSettings',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '个人资料设置'
        }
      },
      {
        path: 'operationLog',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '操作日志'
        }
      }
    ]
  },

  // 运营管理
  {
    path: '/operationManage',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true,
    meta: {
      title: '运营管理',
      icon: 'mouse'
    },
    children: [
      {
        path: 'gameReport',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '游戏报表'
        }
      },
      {
        path: 'moneyChange',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '资金帐变'
        }
      }
    ]
  },

  // 活动管理
  {
    path: '/activityManage',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true,
    meta: {
      title: '活动管理',
      icon: 'gift'
    },
    children: [
      {
        path: 'activityReport',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '活动报表'
        }
      },
      {
        path: 'activityList',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '活动列表'
        }
      },
      {
        path: 'commonActivity',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '常规活动'
        }
      }
    ]
  },

  // 网站管理
  {
    path: '/websiteManage',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true,
    meta: {
      title: '网站管理',
      icon: 'web'
    },
    children: [
      {
        path: 'adMapSettings',
        component: () => import('@/views/permission/page'),
        name: 'PagePermission',
        meta: {
          title: '广告图设置'
        }
      },
      {
        path: 'rotationMapSettings',
        component: () => import('@/views/permission/directive'),
        name: 'DirectivePermission',
        meta: {
          title: '轮播图设置'
        }
      }
    ]
  }
]

export default new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})

export const asyncRouterMap = [
]
