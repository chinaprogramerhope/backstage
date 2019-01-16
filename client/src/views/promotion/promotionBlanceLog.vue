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

      <el-form-item label="推广账号:">
        <el-input v-model="form1.account" placeholder="推广账号" style="width:100px" clearable/>
      </el-form-item>

      <el-form-item label="用户ID:">
        <el-input v-model="form1.userId" placeholder="用户ID" style="width:250px" clearable/>
      </el-form-item>

      <el-form-item label="日志类型:">
        <el-select v-model="form1.selectLogType">
          <el-option
            v-for="item in form1.optionsLogType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="mini" icon="el-icon-search" @click="onGet()">查询 (默认显示最近30天)</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 24px">
      <el-table-column min-width="10%" prop="addTime" label="日期" sortable align="center"/>
      <el-table-column min-width="10%" prop="agentAccount" label="推广账号" sortable align="center"/>
      <el-table-column min-width="10%" prop="money" label="金额" sortable align="center"/>
      <el-table-column min-width="10%" prop="dataType" label="类型" sortable align="center"/>

      <el-table-column min-width="10%" prop="agentbalanaceBefore" label="操作前信用金余额" sortable align="center"/>
      <el-table-column min-width="10%" prop="userId" label="用户ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="content" label="备注" sortable align="center"/>

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
import { promotionBalanceLogGet } from '@/api/finance'

export default {
  data() {
    return {
      form1: {
        dpValue1: '',
        account: '',
        useId: '',
        selectLogType: -1,
        optionsLogType: [{
          label: '全部',
          value: -1
        }, {
          label: '后台增减信用金',
          value: 1
        }, {
          label: '推广代理充值',
          value: 2
        }]
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4,

      // dialog1 添加
      dialogForm1Visible: false,
      passGameName: '',
      dialogForm1: {
        form1LabelWidth: '120px',

        // 客户类型
        selectCustomerType: 1,
        optionsCustomerType: [{
          label: '个人',
          value: 1
        }, {
          label: '企业',
          value: 2
        }],

        // 资产类型
        selectAccountType: 1,
        optionsAccountType: [{
          label: '借记卡',
          value: 1
        }, {
          label: '企业对公账户',
          value: 2
        }]
      }
    }
  },

  created() {
    const dateRange = this.form1.dpValue1
    const agentAccount = this.form1.account
    const userId = this.form1.userId
    const logType = this.form1.selectLogType

    promotionBalanceLogGet(dateRange, agentAccount, userId, logType).then(response => {
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
      const agentAccount = this.form1.account
      const userId = this.form1.userId
      const logType = this.form1.selectLogType

      promotionBalanceLogGet(dateRange, agentAccount, userId, logType).then(response => {
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

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
