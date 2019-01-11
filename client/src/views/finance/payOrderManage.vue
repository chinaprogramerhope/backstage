<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <el-form-item label="日期:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          style="width:250px"
        />
      </el-form-item>

      <el-form-item label="账户ID:">
        <el-input v-model="form1.cardId" placeholder="账户ID" style="width:100px" clearable/>
      </el-form-item>

      <el-form-item label="收款金额:">
        <el-input v-model="form1.amount" placeholder="收款金额" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="订单号:">
        <el-input v-model="form1.outTradeNo" placeholder="订单号" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="是否短信通知:">
        <el-select v-model="form1.selectMessageNotify" style="width:100px">
          <el-option
            v-for="item in form1.optionsMessageNotify"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="订单状态:">
        <el-select v-model="form1.selectOrderStatus" style="width:100px">
          <el-option
            v-for="item in form1.optionsOrderStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="提现平台:">
        <el-select v-model="form1.selectPayPlatform" style="width:100px">
          <el-option
            v-for="item in form1.optionsPayPlatform"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" size="mini" @click="onGet">查询 (默认显示最近30天)</el-button>
      </el-form-item>

      <!-- 原后台被注释了 -->
      <!-- <el-form-item>
        <el-button type="danger" size="mini" @click="onUpdate">更新派支付提款单状态</el-button>
      </el-form-item> -->

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"

      style="width: 100%; margin-bottom: 24px">
      <el-table-column min-width="10%" prop="status" label="状态" sortable align="center"/>
      <el-table-column min-width="10%" prop="amount" label="金额" sortable align="center"/>
      <el-table-column min-width="14%" prop="bankcardNo" label="收款账号" sortable align="center"/>
      <el-table-column min-width="14%" prop="bankBranch" label="支行名称" sortable align="center"/>

      <el-table-column min-width="15%" prop="cardholderName" label="收款人姓名" sortable align="center"/>
      <el-table-column min-width="15%" prop="cardholderMobile" label="收款人手机" sortable align="center"/>
      <el-table-column min-width="13%" prop="notifyCardholder" label="短信通知" sortable align="center"/>
      <el-table-column min-width="13%" prop="customerType" label="客户类型" sortable align="center"/>

      <el-table-column min-width="13%" prop="accountType" label="资产类型" sortable align="center"/>
      <el-table-column min-width="20%" prop="headquartersBankId" label="收款银行卡联行号" sortable align="center"/>
      <el-table-column min-width="10%" prop="issueBankId" label="发卡行联行号" sortable align="center"/>
      <el-table-column min-width="8%" prop="payPlatform" label="平台" sortable align="center"/>

      <el-table-column min-width="10%" prop="addTime" label="创建时间" sortable align="center"/>
      <el-table-column min-width="10%" prop="outTradeNo" label="订单号" sortable align="center"/>
      <el-table-column min-width="10%" prop="platformOrderId" label="平台订单号" sortable align="center"/>
      <el-table-column min-width="10%" prop="operTime" label="处理时间" sortable align="center"/>

      <el-table-column min-width="10%" prop="resMsg" label="结果描述" sortable align="center"/>
    </el-table>

    <!-- 分页 -->
    <!-- <el-row gutter="20">
      <el-col :span="10" style="text-align: center">
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </el-col> -->

  </div>
</template>

<script>
import { payOrderManageGet } from '@/api/finance'
import { payOrderManageUpdate } from '@/api/finance'

export default {
  data() {
    return {
      form1: {
        dpValue1: '',

        selectMessageNotify: -1,
        optionsMessageNotify: [{
          label: '全部',
          value: -1
        }, {
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }],

        selectOrderStatus: -1,
        optionsOrderStatus: [{
          label: '全部',
          value: -1
        }, {
          label: '待处理',
          value: 0
        }, {
          label: '打款成功',
          value: 10000
        }, {
          label: '单笔金额超出支付上限',
          value: 10101
        }, {
          label: '总金额超出支付上限',
          value: 10102
        }, {
          label: '余额不足',
          value: 10103
        }, {
          label: '请求参数不正确',
          value: 10201
        }, {
          label: 'sign 签名不正确',
          value: 10301
        }, {
          label: 'key 值不存在或未开通',
          value: 10302
        }, {
          label: 'appid 错误',
          value: 10303
        }, {
          label: '打款记录已经存在',
          value: 10304
        }, {
          label: '请求异常',
          value: 10401
        }],

        selectPayPlatform: -1,
        optionsPayPlatform: [{
          label: '全部',
          value: -1
        }, {
          label: '微派',
          value: 31
        }, {
          label: '汇亿',
          value: 48
        }, {
          label: '派支付',
          value: 87
        }]
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    const dateRange = this.form1.dpValue1
    const cardId = this.form1.cardId
    const amount = this.form1.amount
    const outTradeNo = this.form1.outTradeNo
    const messageNotify = this.form1.selectMessageNotify
    const orderStatus = this.form1.selectOrderStatus
    const payPlatform = this.form1.selectPayPlatform

    payOrderManageGet(dateRange, cardId, amount, outTradeNo, messageNotify, orderStatus, payPlatform).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败',
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 查询
    onGet() {
      const dateRange = this.form1.dpValue1
      const cardId = this.form1.cardId
      const amount = this.form1.amount
      const outTradeNo = this.form1.outTradeNo
      const messageNotify = this.form1.selectMessageNotify
      const orderStatus = this.form1.selectOrderStatus
      const payPlatform = this.form1.selectPayPlatform

      payOrderManageGet(dateRange, cardId, amount, outTradeNo, messageNotify, orderStatus, payPlatform).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 更新派支付订单状态
    onUpdate() {
      payOrderManageUpdate.then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '更新数据失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
