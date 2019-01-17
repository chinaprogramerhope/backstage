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
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 150px"/>
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

      <el-form-item label="人工客服:">
        <el-select v-model="form1.selectManualCustomer" style="width: 150px">
          <el-option
            v-for="item in form1.optionsManualCustomer"
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

    <div style="margin-left: 10px; margin-top: 20px; margin-bottom: 10px">
      总共充值: <span>0</span>元
    </div>
    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="userId" align="center"/>
      <el-table-column min-width="10%" prop="account" label="金额" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="充值前金币" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="充值后金币" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="订单号" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="第三方订单号" align="center"/>
      <el-table-column min-width="10%" prop="account" label="提交时间" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="来源" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectManualCustomer: -1,
        optionsManualCustomer: [{
          label: '全部',
          value: -1
        }],

        userId: '',
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
