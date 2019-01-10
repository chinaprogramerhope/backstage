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
        />
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onGet">查询 (默认显示最近30天)</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"

      style="width: 100%; margin-bottom: 24px">
      <el-table-column min-width="10%" prop="totalWithdrawals" label="总提现(平台)" sortable align="center"/>
      <el-table-column min-width="10%" prop="totalPoundage" label="总手续费(平台)" sortable align="center"/>
      <el-table-column min-width="10%" prop="manualAmount" label="手动处理的金额" sortable align="center"/>
      <el-table-column min-width="10%" prop="autoAmount" label="自动处理的金额" sortable align="center"/>
      <el-table-column min-width="12%" prop="autoPoundage" label="自动处理手续费(平台)" sortable align="center"/>
      <el-table-column min-width="12%" prop="platformMinus" label="自动金额 减 手续费(平台)" sortable align="center"/>
      <el-table-column min-width="10%" prop="aliPayTotalWithdrawals" label="支付宝总提现" sortable align="center"/>
      <el-table-column min-width="10%" prop="aliPayTotalPoundage" label="支付宝总手续费" sortable align="center"/>
      <el-table-column min-width="14%" prop="aliPayMinus" label="提现金额 减 手续费(支付宝)" sortable align="center"/>
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
import { withdrawalTotalGet } from '@/api/finance'

export default {
  data() {
    return {
      form1: {
        dpValue1: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    const dateRange = this.form1.dpValue1
    withdrawalTotalGet(dateRange).then(response => {
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

      withdrawalTotalGet(dateRange).then(response => {
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
