<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <el-form-item label="时间:">
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

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onUpdate">更新昨日充值数据 (请不要频繁操作)</el-button>
      </el-form-item>
    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="channel" label="渠道" sortable align="center"/>
      <el-table-column prop="rechargeTotal" label="充值总额" sortable align="center"/>
      <el-table-column prop="withDrawalTotal" label="提现总额" sortable align="center"/>
      <el-table-column prop="withDrawalGiveTotal" label="提现赠送总额" sortable align="center"/>
      <el-table-column prop="withDrawalPoundageTotal" label="提现手续费总额" sortable align="center"/>
      <el-table-column prop="pumpTotal" label="抽水总额" sortable align="center"/>
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
import { finStatisticsGet } from '@/api/finance'
import { finStatisticsUpdate } from '@/api/finance'

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
    finStatisticsGet(this.form1.dpValue1).then(response => {
      this.tableData = response.data
    })
  },

  methods: {
    // 查询
    onGet() {
      finStatisticsGet(this.form1.dpValue1).then(response => {
        this.tableData = response.data
      })
    },

    // 更新昨日充值数据(请不要频繁操作)
    onUpdate() {
      finStatisticsUpdate().then(response => {
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
