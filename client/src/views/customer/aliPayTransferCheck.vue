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
      <el-table-column min-width="10%" prop="id" label="userId" align="center"/>
      <el-table-column min-width="10%" prop="account" label="金币(不是rmb)" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="订单号" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="转入支付宝" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="支付宝订单号" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="提交时间" align="center"/>
      <el-table-column min-width="10%" prop="account" label="到账时间" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="截图" align="center"/>
    </el-table>

  </div>
</template>

<script>
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
