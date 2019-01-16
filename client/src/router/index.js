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
    path: '/member',
    component: Layout,
    redirect: '/member/index',
    alwaysShow: true, // will always show the root menu
    meta: {
      title: '会员管理',
      icon: 'person-stalker',
      roles: ['admin', 'editor'] // you can set roles in root nav
    },
    children: [
      {
        path: 'memberList',
        component: () => import('@/views/member/memberList'),
        name: 'memberList',
        meta: {
          title: '会员列表'
          // if do not set roles, means: this page does not require permission
        }
      },
      {
        path: 'memberDetail',
        component: () => import('@/views/member/memberDetail'),
        name: 'memberDetail',
        meta: { title: 'memberDetail', noCache: true },
        hidden: true
      },
      {
        path: 'memberLog',
        component: () => import('@/views/member/memberLog'),
        name: 'memberLog',
        meta: {
          title: '会员登录日志'
        }
      },
      {
        path: 'memberLabel',
        component: () => import('@/views/member/memberLabel'),
        name: 'memberLabel',
        meta: {
          title: '会员标签',
          roles: ['admin'] // or you can only set roles in sub nav
        }
      },
      {
        path: 'memberLevel',
        component: () => import('@/views/member/memberLevel'),
        name: 'memberLevel',
        meta: {
          title: '会员等级'
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
        path: 'gameList',
        component: () => import('@/views/game/gameList'),
        name: 'gameList',
        meta: {
          title: '游戏列表'
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
        path: 'finStatistics',
        component: () => import('@/views/finance/finStatistics'),
        name: 'finStatistics',
        meta: {
          title: '财务统计'
        }
      },
      {
        path: 'payStatistics',
        component: () => import('@/views/finance/payStatistics'),
        name: 'payStatistics',
        meta: {
          title: '支付统计'
        }
      },
      {
        path: 'withdrawalTotalStatistics',
        component: () => import('@/views/finance/withdrawalTotalStatistics'),
        name: 'withdrawalTotalStatistics',
        meta: {
          title: '提现总额统计'
        }
      },
      {
        path: 'operationStatistics',
        component: () => import('@/views/finance/operationStatistics'),
        name: 'operationStatistics',
        meta: {
          title: '运营统计'
        }
      },
      {
        path: 'reconciliationStatistics',
        component: () => import('@/views/finance/reconciliationStatistics'),
        name: 'reconciliationStatistics',
        meta: {
          title: '对账统计'
        }
      },
      {
        path: 'payAccountManage',
        component: () => import('@/views/finance/payAccountManage'),
        name: 'payAccountManage',
        meta: {
          title: '代付账户管理'
        }
      },
      {
        path: 'payOrderManage',
        component: () => import('@/views/finance/payOrderManage'),
        name: 'payOrderManage',
        meta: {
          title: '代付订单管理'
        }
      },
      {
        path: 'manualOperate',
        component: () => import('@/views/finance/manualOperate'),
        name: 'manualOperate',
        meta: {
          title: '人工存提 - 未开放'
        }
      },
      {
        path: 'officialCharge',
        component: () => import('@/views/finance/officialCharge'),
        name: 'officialCharge',
        meta: {
          title: '官方支付 - 未开放'
        }
      },
      {
        path: 'onlinePay',
        component: () => import('@/views/finance/onlinePay'),
        name: 'onlinePay',
        meta: {
          title: '线上支付 - 未开放'
        }
      },
      {
        path: 'alipayAudit',
        component: () => import('@/views/finance/alipayAudit'),
        name: 'alipayAudit',
        meta: {
          title: '支付宝出款审核 - 未开放'
        }
      },
      {
        path: 'bankCardAudit',
        component: () => import('@/views/finance/bankCardAudit'),
        name: 'bankCardAudit',
        meta: {
          title: '银行卡出款审核 - 未开放'
        }
      },
      {
        path: 'autopayTradeRecord',
        component: () => import('@/views/finance/autopayTradeRecord'),
        name: 'autopayTradeRecord',
        meta: {
          title: '自动出款交易记录 - 未开放'
        }
      },
      {
        path: 'financeConfig',
        component: () => import('@/views/finance/financeConfig'),
        name: 'financeConfig',
        meta: {
          title: '出入款配置 - 未开放'
        }
      }
    ]
  },

  // 公告管理
  {
    path: '/message',
    component: Layout,
    redirect: '/message/index',
    alwaysShow: true, // will always show the root menu
    meta: {
      title: '公告管理',
      icon: 'horn'
    },
    children: [
      {
        path: 'announceList',
        component: () => import('@/views/message/announceList'),
        name: 'announceList',
        meta: {
          title: '公告列表'
        }
      }
      // {
      //   path: 'stationMessage',
      //   component: () => import('@/views/message/stationMessage'),
      //   name: 'stationMessage',
      //   meta: {
      //     title: '站内消息 - 未开放'
      //   }
      // }
    ]
  },

  // 推广管理
  {
    path: '/promotion',
    component: Layout,
    redirect: '/promotion/index',
    alwaysShow: true,
    meta: {
      title: '推广管理 - 未开放',
      icon: 'promotion'
    },
    children: [
      {
        path: 'promotionAccount',
        component: () => import('@/views/promotion/promotionAccount'),
        name: 'promotionAccount',
        meta: {
          title: '推广账号'
        }
      },
      {
        path: 'promotionBlanceLog',
        component: () => import('@/views/promotion/promotionBlanceLog'),
        name: 'promotionBlanceLog',
        meta: {
          title: '推广信用金日志'
        }
      },
      {
        path: 'promotionStatistics',
        component: () => import('@/views/promotion/promotionStatistics'),
        name: 'promotionStatistics',
        meta: {
          title: '推广统计'
        }
      },
      {
        path: 'promotionCorrection',
        component: () => import('@/views/promotion/promotionCorrection'),
        name: 'promotionCorrection',
        meta: {
          title: '推广ID修正'
        }
      },
      {
        path: 'promotionUser',
        component: () => import('@/views/promotion/promotionUser'),
        name: 'promotionUser',
        meta: {
          title: '推广玩家 - 未开放'
        }
      },
      {
        path: 'promotionReport',
        component: () => import('@/views/promotion/promotionReport'),
        name: 'promotionReport',
        meta: {
          title: '推广报表 - 未开放'
        }
      },
      {
        path: 'promotionRebate',
        component: () => import('@/views/promotion/promotionRebate'),
        name: 'promotionRebate',
        meta: {
          title: '推广返利 - 未开放'
        }
      },
      {
        path: 'rebateSettings',
        component: () => import('@/views/promotion/rebateSettings'),
        name: 'rebateSettings',
        meta: {
          title: '返利设置 - 未开放'
        }
      }
    ]
  },

  // 系统设置
  {
    path: '/system',
    component: Layout,
    redirect: '/system/index',
    alwaysShow: true,
    meta: {
      title: '系统设置 - 未开放',
      icon: 'set'
    },
    children: [
      {
        path: 'subAccount',
        component: () => import('@/views/system/subAccount'),
        name: 'subAccount',
        meta: {
          title: '厅主子账号管理'
        }
      },
      {
        path: 'userProfile',
        component: () => import('@/views/system/userProfile'),
        name: 'userProfile',
        meta: {
          title: '个人资料设置'
        }
      },
      {
        path: 'operateLog',
        component: () => import('@/views/system/operateLog'),
        name: 'operateLog',
        meta: {
          title: '操作日志'
        }
      },
      {
        path: 'downloadConf',
        component: () => import('@/views/system/downloadConf'),
        name: 'downloadConf',
        meta: {
          title: '下载设置'
        }
      },
      {
        path: 'roleManage',
        component: () => import('@/views/system/roleManage'),
        name: 'roleManage',
        meta: {
          title: '角色管理'
        }
      },
      {
        path: 'globalParam',
        component: () => import('@/views/system/globalParam'),
        name: 'globalParam',
        meta: {
          title: '全局参数'
        }
      }
    ]
  },

  // 运营管理
  {
    path: '/operation',
    component: Layout,
    redirect: '/operation/index',
    alwaysShow: true,
    meta: {
      title: '运营管理 - 未开放',
      icon: 'mouse'
    },
    children: [
      {
        path: 'announceList',
        component: () => import('@/views/message/announceList'),
        name: 'announceList',
        meta: {
          title: '系统公告'
        }
      },
      {
        path: 'systemMaintenance',
        component: () => import('@/views/operation/systemMaintenance'),
        name: 'systemMaintenance',
        meta: {
          title: '系统维护'
        }
      },
      {
        path: 'packaeUpgrade',
        component: () => import('@/views/operation/packaeUpgrade'),
        name: 'packaeUpgrade',
        meta: {
          title: '整包升级服务器管理'
        }
      },
      {
        path: 'moduleUpgarde',
        component: () => import('@/views/operation/moduleUpgarde'),
        name: 'moduleUpgarde',
        meta: {
          title: '模块升级服务器管理'
        }
      },
      {
        path: 'gameSwitch',
        component: () => import('@/views/operation/gameSwitch'),
        name: 'gameSwitch',
        meta: {
          title: '游戏开关管理'
        }
      },
      {
        path: 'aliPayTransfer',
        component: () => import('@/views/operation/aliPayTransfer'),
        name: 'aliPayTransfer',
        meta: {
          title: '转账支付宝管理'
        }
      },
      {
        path: 'payment',
        component: () => import('@/views/operation/payment'),
        name: 'payment',
        meta: {
          title: '支付管理'
        }
      },
      {
        path: 'proxyIp',
        component: () => import('@/views/operation/proxyIp'),
        name: 'proxyIp',
        meta: {
          title: 'Proxy IP管理'
        }
      },
      {
        path: 'agentAccount',
        component: () => import('@/views/operation/agentAccount'),
        name: 'agentAccount',
        meta: {
          title: '代理账号管理'
        }
      },
      {
        path: 'stopServer',
        component: () => import('@/views/operation/stopServer'),
        name: 'stopServer',
        meta: {
          title: '紧急停服'
        }
      },
      {
        path: 'goldAddLog',
        component: () => import('@/views/operation/goldAddLog'),
        name: 'goldAddLog',
        meta: {
          title: '增加金币记录'
        }
      },
      {
        path: 'bindPhoneLog',
        component: () => import('@/views/operation/bindPhoneLog'),
        name: 'bindPhoneLog',
        meta: {
          title: '绑定手机记录'
        }
      },
      {
        path: 'bindAliPayLog',
        component: () => import('@/views/operation/bindAliPayLog'),
        name: 'bindAliPayLog',
        meta: {
          title: '绑定支付宝记录'
        }
      },
      {
        path: 'payLimit',
        component: () => import('@/views/operation/payLimit'),
        name: 'payLimit',
        meta: {
          title: '禁止支付管理'
        }
      },
      {
        path: 'rechargeLog',
        component: () => import('@/views/operation/rechargeLog'),
        name: 'rechargeLog',
        meta: {
          title: '账号及充值查询'
        }
      },
      {
        path: 'chongLingSwitch',
        component: () => import('@/views/operation/chongLingSwitch'),
        name: 'chongLingSwitch',
        meta: {
          title: '冲领开关'
        }
      },
      {
        path: 'gameReport',
        component: () => import('@/views/operation/gameReport'),
        name: 'gameReport',
        meta: {
          title: '游戏报表 - 未开放'
        }
      },
      {
        path: 'moneyReport',
        component: () => import('@/views/operation/moneyReport'),
        name: 'moneyReport',
        meta: {
          title: '资金帐变 - 未开放'
        }
      },
      {
        path: 'systemProfit',
        component: () => import('@/views/operation/systemProfit'),
        name: 'systemProfit',
        meta: {
          title: '系统利润 - 未开放'
        }
      }
    ]
  },

  // // 活动管理
  // {
  //   path: '/activity',
  //   component: Layout,
  //   redirect: '/activity/index',
  //   alwaysShow: true,
  //   meta: {
  //     title: '活动管理 - 未开放',
  //     icon: 'gift'
  //   },
  //   children: [
  //     {
  //       path: 'activityReport',
  //       component: () => import('@/views/activity/activityReport'),
  //       name: 'activityReport',
  //       meta: {
  //         title: '活动报表'
  //       }
  //     },
  //     {
  //       path: 'activityList',
  //       component: () => import('@/views/activity/activityList'),
  //       name: 'activityList',
  //       meta: {
  //         title: '活动列表'
  //       }
  //     },
  //     {
  //       path: 'commonActivity',
  //       component: () => import('@/views/activity/commonActivity'),
  //       name: 'commonActivity',
  //       meta: {
  //         title: '常规活动'
  //       }
  //     }
  //   ]
  // },

  // // 网站管理
  // {
  //   path: '/website',
  //   component: Layout,
  //   redirect: '/website/index',
  //   alwaysShow: true,
  //   meta: {
  //     title: '网站管理 - 未开放',
  //     icon: 'web'
  //   },
  //   children: [
  //     {
  //       path: 'bannerSetting',
  //       component: () => import('@/views/website/bannerSetting'),
  //       name: 'bannerSetting',
  //       meta: {
  //         title: '轮播图设置'
  //       }
  //     },
  //     {
  //       path: 'adsetting',
  //       component: () => import('@/views/website/adsetting'),
  //       name: 'adsetting',
  //       meta: {
  //         title: '广告图设置'
  //       }
  //     }
  //   ]
  // },

  // 注册
  {
    // path: '/register',
    // component: Layout,
    // hidden: true,
    // redirect: '/register/index',
    // // alwaysShow: true,
    // meta: {
    //   title: '注册',
    //   icon: 'web'
    // },
    // children: [
    //   {
    //     path: 'register',
    //     component: () => import('@/views/register/index'),
    //     name: 'register',
    //     meta: {
    //       title: '注册'
    //     }
    //   }
    // ]

    // path: '/register',
    // component: Layout,
    // redirect: '/register/index',
    // children: [
    //   {
    //     path: '/register',
    //     component: () => import('@/views/register/index'),
    //     name: 'register',
    //     meta: { title: '注册', icon: 'home', noCache: true }
    //   }
    // ]

    path: '/register',
    component: () => import('@/views/register/index'),
    hidden: true
  }
]

export default new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})

export const asyncRouterMap = [
]
