<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-row>
        <el-form-item label="用户id:">
          <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 100px"/>
        </el-form-item>

        <el-form-item label="支付宝账号:">
          <el-input v-model="form1.aliPayAccount" placeholder="支付宝账号" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="订单号:">
          <el-input v-model="form1.orderId" placeholder="订单号" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="日期:">
          <el-date-picker
            v-model="form1.dateRange"
            type="daterange"
            range-separator="~"
            start-placeholder="开始时间"
            end-placeholder="结束时间"
            value-format="yyyy-MM-dd HH:mm:ss"
            style="width: 250px"
          />
        </el-form-item>

        <el-form-item label="订单状态:">
          <el-select v-model="form1.selectOrderStatus" style="width: 100px">
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

        <el-form-item label="">
          未处理订单数:<span>0</span>
        </el-form-item>
      </el-row>

      <el-row style="margin-bottom:20px; margin-left:40px">
        <el-button type="danger" size="small" @click="handleClearAliPayBlacklist()">清空支付宝黑名单</el-button>
      </el-row>

      <el-row style="margin-left: 40px">
        <el-form-item label="">
          <el-button type="danger" size="small" @click="onBatchFinish()">批量处理完成</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="danger" size="small" @click="onBatchReHandle()">批量重新处理</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="danger" size="small" @click="onBatchSuccess()">批量处理成功</el-button>
        </el-form-item>

        <el-form-item label="">
          <span style="color: blue">支付宝提现已经停止, 请通知技术人员查看或开始人工审核</span>
        </el-form-item>
      </el-row>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="" align="center">
        <el-checkbox v-model="checked"/>
      </el-table-column>
      <el-table-column min-width="10%" prop="account" label="用户id" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="提现订单号" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="总充值" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="总提现" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="实际提现金额" align="center"/>
      <el-table-column min-width="10%" prop="account" label="扣除手续费后金额" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="提现赠送金额" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="提现后金币" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="提现时间" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="支付宝账号" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="支付宝实名" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="渠道" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="处理完成/退款时间" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="描述" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini">编辑</el-button>
        </template>
      </el-table-column>
      <el-table-column min-width="10%" prop="gold" label="人工提现" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectEnable: -1,
        optionsEnable: [{
          label: '全部',
          value: -1
        }],

        selectCheckResult: -1,
        optionsCheckResult: [{
          label: '全部',
          value: -1
        }],

        appId: '',
        registerEmail: '',
        operator: '',
        registerIp: '',
        dateRange: ''
      },

      tableData: [{
        id: '11'
      }]
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
