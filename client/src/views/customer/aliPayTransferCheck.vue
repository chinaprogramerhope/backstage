<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 100px"/>
      </el-form-item>

      <el-form-item label="订单号:">
        <el-input v-model="form1.orderId" placeholder="订单号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="支付宝订单号:">
        <el-input v-model="form1.aliPayOrderId" placeholder="支付宝订单号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="支付宝账号:">
        <el-input v-model="form1.aliPayAccount" placeholder="支付宝账号" clearable style="width: 150px"/>
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
      <el-table-column min-width="10%" prop="user_id" label="userId" align="center"/>
      <el-table-column min-width="10%" prop="money" label="金币(不是rmb)" align="center"/>
      <el-table-column min-width="10%" prop="order_sn" label="订单号" align="center"/>
      <el-table-column min-width="10%" prop="param" label="转入支付宝" align="center"/>
      <el-table-column min-width="10%" prop="third_order_sn" label="支付宝订单号" align="center"/>
      <el-table-column min-width="10%" prop="add_time" label="提交时间" align="center"/>
      <el-table-column min-width="10%" prop="pay_success_time" label="到账时间" align="center"/>
      <el-table-column min-width="10%" prop="status" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="text" size="mini" @click="handleConfirm(scope.row.order_sn)">确认转账成功</el-button>
          <el-button type="text" size="mini" @click="handleModify(scope.row.order_sn)">修改金额</el-button>
          <el-button type="text" size="mini" @click="handleClose(scope.row.order_sn)">关闭订单</el-button>
        </template>
      </el-table-column>
      <el-table-column min-width="10%" prop="operation" label="截图" align="center"/>
    </el-table>

  </div>
</template>

<script>
import { aliPayTransferCheckGet } from '@/api/customer'
import { aliPayTransferCheckConfirm } from '@/api/customer'
import { aliPayTransferCheckModify } from '@/api/customer'
import { aliPayTransferCheckClose } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        selectOrderStatus: -1,
        optionsOrderStatus: [{
          label: '全部',
          value: -1
        }],

        userId: '',
        orderId: '',
        aliPayOrderId: '',
        aliPayAccount: '',
        dateTimeRange: ''
      },

      tableData: ''
    }
  },

  created() {
    const userId = this.form1.userId
    const orderId = this.form1.orderId
    const aliPayOrderId = this.form1.aliPayOrderId
    const aliPayAccount = this.form1.aliPayAccount

    const dateTimeRange = this.form1.dateTimeRange
    const orderStatus = this.form1.selectOrderStatus

    aliPayTransferCheckGet(userId, orderId, aliPayOrderId, aliPayAccount, dateTimeRange, orderStatus).then(response => {
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
      const userId = this.form1.userId
      const orderId = this.form1.orderId
      const aliPayOrderId = this.form1.aliPayOrderId
      const aliPayAccount = this.form1.aliPayAccount

      const dateTimeRange = this.form1.dateTimeRange
      const orderStatus = this.form1.selectOrderStatus

      aliPayTransferCheckGet(userId, orderId, aliPayOrderId, aliPayAccount, dateTimeRange, orderStatus).then(response => {
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

    // 操作 - 确认转账成功
    handleConfirm(orderId) {
      aliPayTransferCheckConfirm(orderId).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '确认转账失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 操作 - 修改金额
    handleModify(orderId, money) {
      aliPayTransferCheckModify(orderId, money).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '修改金额失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 操作 - 关闭订单
    handleClose(orderId, reason) {
      aliPayTransferCheckClose(orderId, reason).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '关闭订单失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>
