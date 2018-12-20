<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">

      <el-form-item label="帐变类型:">
        <el-select v-model="form1.selectMoneyChangeType" placeholder="全部">
          <el-option
            v-for="item in form1.optionsMoneyChangeType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="会员账号:">
        <el-input v-model="form1.vipAccount" placeholder=""/>
      </el-form-item>

      <el-form-item label="ID号:">
        <el-input v-model="form1.id" placeholder=""/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.date"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe
    >
      <el-table-column prop="orderId" label="订单号/局号" sortable align="center"/>
      <el-table-column prop="userName" label="用户名" sortable align="center"/>
      <el-table-column prop="id" label="ID号" sortable align="center"/>
      <el-table-column prop="moneyChangeType" label="帐变类型" sortable align="center"/>
      <el-table-column prop="moneyChangeBefore" label="帐变前余额" sortable align="center"/>
      <el-table-column prop="moneyChange" label="帐变金额" sortable align="center"/>
      <el-table-column prop="moneyChangeAfter" label="帐变后余额" sortable align="center"/>
      <el-table-column prop="moneyChangeTime" label="帐变时间" sortable align="center"/>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

  </div>
</template>

<script>

export default {
  data() {
    return {

      form1: {
        vipAccount: '',
        id: '',
        date: '',
        selectMoneyChangeType: '',
        optionsMoneyChangeType: [{
          label: '全部',
          value: 'all'
        }, {
          label: '充值',
          value: 'charge'
        }, {
          label: '注册送',
          value: 'register'
        }, {
          label: '首充送',
          value: 'firCharge'
        }, {
          label: '人工存款',
          value: 'manualDeposit'
        }, {
          label: '优惠活动',
          value: 'discountActivity'
        }, {
          label: '人工提款',
          value: 'manualDraw'
        }, {
          label: '误存提款',
          value: 'falseDraw'
        }, {
          label: '行政提款',
          value: 'administrationDraw'
        }, {
          label: '银行卡出款',
          value: 'bankCardPayOut'
        }, {
          label: '支付宝出款',
          value: 'alipayPayOut'
        }, {
          label: '自动出款',
          value: 'autoPayOut'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }, {
          label: '账户余额转保险箱',
          value: 'balanceToSafeBox'
        }]
      },

      // tableData
      tableData: [{
        orderId: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        orderId: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage: 4

    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {
    },
    handleCurrentChange(val) {
    }
  }
}
</script>
