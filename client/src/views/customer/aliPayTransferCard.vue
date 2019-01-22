<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-form-item label="支付宝订单号:">
        <el-input v-model="form1.aliPayOrderId" placeholder="支付宝订单号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="支付宝账号:">
        <el-input v-model="form1.aliPayAccount" placeholder="支付宝账号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="卡号:">
        <el-input v-model="form1.cardNumber" placeholder="卡号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="卡密:">
        <el-input v-model="form1.cardPassword" placeholder="卡密" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dateTimeRange"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始时间"
          end-placeholder="结束时间"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="订单状态:">
        <el-select v-model="form1.selectOrderStatus" style="width: 150px">
          <el-option
            v-for="item in form1.optionsOrderStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="id" align="center"/>
      <el-table-column min-width="10%" prop="alipayOrderId" label="支付宝订单号" align="center"/>
      <el-table-column min-width="10%" prop="alipayAccount" label="支付宝账号" align="center"/>
      <el-table-column min-width="10%" prop="userId" label="用户id" align="center"/>
      <el-table-column min-width="10%" prop="cardNum" label="卡号" align="center"/>
      <el-table-column min-width="10%" prop="cardPass" label="卡密" align="center"/>
      <el-table-column min-width="10%" prop="money" label="金额(元)" align="center"/>
      <el-table-column min-width="10%" prop="createTime" label="创建时间" align="center"/>
      <el-table-column min-width="10%" prop="useTime" label="使用时间" align="center"/>
      <el-table-column min-width="10%" prop="status" label="状态" align="center"/>
    </el-table>

  </div>
</template>

<script>
import { aliPayTransferCardGet } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        selectOrderStatus: -1,
        optionsOrderStatus: [{
          label: '全部',
          value: -1
        }],

        aliPayOrderId: '',
        aliPayAccount: '',
        userId: '',
        cardNumber: '',
        cardPassword: '',
        dateTimeRange: ''
      },

      tableData: ''
    }
  },

  created() {
    const aliPayOrderId = this.form1.aliPayOrderId
    const aliPayAccount = this.form1.aliPayAccount
    const userId = this.form1.userId
    const cardNumber = this.form1.cardNumber

    const cardPassword = this.form1.cardPassword
    const orderStatus = this.form1.orderStatus
    const dateTimeRange = this.form1.dateTimeRange

    aliPayTransferCardGet(aliPayOrderId, aliPayAccount, userId, cardNumber, cardPassword, orderStatus, dateTimeRange).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 查询
    handleGet() {
      const aliPayOrderId = this.form1.aliPayOrderId
      const aliPayAccount = this.form1.aliPayAccount
      const userId = this.form1.userId
      const cardNumber = this.form1.cardNumber

      const cardPassword = this.form1.cardPassword
      const orderStatus = this.form1.orderStatus
      const dateTimeRange = this.form1.dateTimeRange

      aliPayTransferCardGet(aliPayOrderId, aliPayAccount, userId, cardNumber, cardPassword, orderStatus, dateTimeRange).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>
